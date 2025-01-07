<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Studentinvoice;
use App\Models\Student;
use App\Models\Balance;
use App\Models\Gst;
use App\Models\GeneralSettings;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\Fee;
use App\Models\Tax;
use App\Models\StudentInstallment;

class BalanceController extends Controller
{
    // Display the list of balances
    public function create()
    {
        // Fetch all students for the dropdown
        $students = Student::all();
        $studentinvoice = Studentinvoice::all(); // Fetch all student invoices

        // Return the view with students and invoices
        return view('dashboard.balance.create', compact('students', 'studentinvoice'));
    }

    // Handle form submission and display balance
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);
    
        $studentId = $request->student_id;
    
        // Find the student based on the ID
        $student = Student::findOrFail($studentId);
    
        // Fetch the latest invoice for the selected student
        $latestInvoice = Studentinvoice::where('student_id', $studentId)
            ->orderBy('id', 'desc') // Get the latest invoice by ID
            ->first();
    
        // Fetch all invoices up to the latest invoice
        $previousInvoices = Studentinvoice::where('student_id', $studentId)
            ->where('id', '<=', $latestInvoice->id)
            ->orderBy('id', 'asc')
            ->get();
    
        // Fetch course details
        $course = $student->course;
    
        if ($course) {
            $courseFee = $course->fee;
    
            // Calculate the total amount paid from all invoices
            $paidFee = $previousInvoices->sum('unitprice');
    
            // Calculate the balance amount
            $balanceAmount = $courseFee - $paidFee;
        } else {
            $courseFee = null;
            $balanceAmount = null; // No course assigned to the student
        }
    
        // Return view with the fetched data
        return view('dashboard.balance.create', [
            'students' => Student::all(),
            'selectedStudent' => $student,
           'latestBalance' => $balanceAmount,
            'latestInvoice' => $latestInvoice,
            'previousInvoices' => $previousInvoices,
            'courseFee' => $courseFee,
        ]);
    }
    
    // pdf view
    public function view($id)
    {
        $studentinvoicedata = Studentinvoice::with(['student.course'])->findOrFail($id);

        $student = $studentinvoicedata->student;
        $course = $student->course;

        // Fetch course fee
        $courseFee = $course->fee;

        // Calculate balance amount
        $previousInvoices = Studentinvoice::where('student_id', $student->id)
            ->where('id', '<=', $id)
            ->orderBy('id', 'asc') // Ensure invoices are sorted by ID
            ->get();

        // Calculate the balance amount
        $paidFee = $previousInvoices->sum('unitprice');

        // Calculate the balance amount
        $balanceAmount = $courseFee - $paidFee;
        // dd($balanceAmount);
        $generalData = GeneralSettings::first();
        $gstValue = Gst::latest()->value('gstvalue');

        $students = Student::with('course')->get();

        $pdf = PDF::loadView('dashboard.studentinvoicepdf.index', compact(
            'studentinvoicedata',
            'generalData',
            'student',
            'course',
            'gstValue',
            'students',
            'balanceAmount',
            'previousInvoices'
        ));

        return $pdf->stream('invoice.pdf');
    }
     public function report(Request $request){
        
        if ($request->isMethod('get')) {

            return view('dashboard.balance.report');

        }else{
             

            $date = explode('-',$request->month);

            $year = $date[0];
            $month = $date[1];

            $postdate = $request->month;

            $fromdate = date("01-$month-$year");
            $todate = date("t-$month-$year");

            $fromdate = date('Y-m-d',strtotime($fromdate));
            $todate = date('Y-m-d',strtotime($todate));


            // dd([$fromdate,$todate]);

            // $student_payments = Studentinvoice::whereBetween('invoicedate',[$fromdate,$todate])->with('student')->get();
            $student_payments =Student::with(['course','invoices' => function ($q) use ($fromdate, $todate) {
                $q->whereDate('invoicedate','<=', $todate);
            }])
            ->get(); 
            // ->whereHas('studentInstallment', function ($query) use($fromdate){
            //     $query->where('date_from','>=',$fromdate); 
            // })

            
            // dd($student_payments);
            foreach ($student_payments as &$student_data) {
                $total_amount_paid = 0;
                $amount_wo_tax = 0;
                $amount_with_tax = 0;
            
                foreach ($student_data->invoices as $invoice) {

                    $total_amount_paid += $invoice['unitprice'];
                    $amount_wo_tax += $invoice['amount'];
                    $amount_with_tax += $invoice['gst'];
                   
                } 
                
                $installment_data = StudentInstallment::whereMonth('date_from','<=',$month)->where('student_id',$student_data->id);

                // $firstinstallmentdate = StudentInstallment::where('installment_no',1)->where('student_id',$student_data->id)->value('date_from');
                // dd($firstinstallmentdate);

                $amount_to_be_paid = 0;
                $monthly_installment = 0;

                if($installment_data->count()>0){

                    $amount_to_be_paid = $installment_data->sum('amount');
                    $monthly_installment = $installment_data->pluck('amount')[0]; 
                }

                
                $student_data->total_amount_paid = $total_amount_paid;
                $student_data->amount_wo_tax = $amount_wo_tax;
                $student_data->amount_with_tax = $amount_with_tax;
                $student_data->monthly_installment = (int)$monthly_installment;
                $student_data->amount_to_be_paid = (int) $amount_to_be_paid;
                $student_data->amount_diff = (int)($amount_to_be_paid - $total_amount_paid);

                $student_data->admissiondate = $student_data->admissiondate;
                // $student_data->firstinstallmentdate = $firstinstallmentdate;
                // dd($student_data);
            }

            // dd($student_payments);
            // exit;
            // $data['student_data'] = $student_data;
            return view('dashboard.balance.report',compact('student_payments','postdate','fromdate'));
        }

    }
    
}