<?php

namespace App\Http\Controllers;

use App\Models\Center;
use Illuminate\Http\Request;
use App\Models\Studentinvoice;
use App\Models\Student;
use App\Models\Gst;
use App\Models\Fee;
use App\Models\Tax;

use Illuminate\Support\Facades\Log;
use App\Models\Invoices;
use App\Models\GeneralSettings;
use App\Models\Incomedetails;
use App\Models\IncomeHead;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


function array_flatten($array)
{
    $result = [];
    array_walk_recursive($array, function ($a) use (&$result) {
        $result[] = $a;
    });
    return $result;
}



class StudentInvoiceController extends Controller
{
    //
   public function index()
{
    // Fetch student invoice details sorted by the latest created_at timestamp
    $studentinvoicedetails = Studentinvoice::with('student', 'centers')
        ->orderBy('created_at', 'desc') // Sort by created_at in descending order
        ->take(30) // Limit the results to the latest 30 entries
        ->get();

    // Calculate the total unit price for display
    $totalUnitPrice = $studentinvoicedetails->sum('unitprice');

    return view('dashboard.studentinvoice.index', compact('studentinvoicedetails', 'totalUnitPrice'));
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

    public function getFeePercentage($id)
    {
        $totalPercentage = 0;
        foreach (explode(',', $id) as $value) {
            $percentage = Tax::find($value);

            $totalPercentage += $percentage->total;
        }
        return response()->json([
            'percentage' => $totalPercentage

        ]);
    }


    // public function create(){
    // $students = Student::all();
    // $gstValue = Gst::latest()->value('gstvalue');
    //     return view('dashboard.studentinvoice.create', compact('students','gstValue'));
    // }

    public function create(Request $request)
    {
        // Fetch students along with their courses
        
        $students = Student::with(['course', 'invoices'])->get();
        foreach ($students as $key => &$value) {
            $paidfee = 0;
            $course_fee = $value['course']['fee'];
            foreach ($value['invoices'] as $inv_key => $inv_value) {
                $paidfee += $inv_value['unitprice'];
            }
            $value['balancefee'] = $course_fee - $paidfee;
        }

        // Retrieve GST value and general data for the view
        $gstValue = Gst::latest()->value('gstvalue');
        $generalData = GeneralSettings::first();

        // Get the last invoice to generate the next invoice number
        $lastInvoice = Invoices::orderBy('invoiceNumber', 'desc')->first();
        $nextInvoiceNumber = $lastInvoice ? $lastInvoice->invoiceNumber + 1 : 1;

        // Ensure general data is not null
        $generalData = $generalData ?? [];

        // Retrieve all FeeMaster titles
        $feeTitles = Fee::all()->pluck('title', 'id');

        // Initialize variable to store tax details
        $taxDetails = [];
        $totalTaxSum = 0; // Initialize total tax sum

        // Check if a title is selected and fetch only the relevant Fee data
        if ($request->has('feeselect')) {
            $selectedTitleId = $request->input('feeselect');
            // Fetch only the Fee details for the selected title
            $feeDetails = Fee::where('id', $selectedTitleId)->first();

            // Fetch tax details for the selected FeeMaster
            if ($feeDetails && isset($feeDetails->taxes)) {
                $taxIds = json_decode($feeDetails->taxes, true);

                // Flatten the array of tax IDs and remove duplicates
                $flattenedTaxIds = array_unique(array_merge(...$taxIds));

                // Fetch the tax details from the Tax model using the flattened IDs
                $taxDetails = Tax::whereIn('id', $flattenedTaxIds)->get();
            }
        } else {
            // If no title is selected, fetch all Fee details
            $feeDetails = Fee::all();
        }

        // Process splitup calculation and storing invoice data
        if ($request->has('unitprice') && $feeDetails) {
            $unitPrice = $request->input('unitprice');
            $splitup = json_decode($feeDetails->splitup, true); // Assuming it's a JSON string in the database

            // Calculate splitup amounts
            $splitupAmounts = [];
            foreach ($splitup as $percentage) {
                $splitupAmounts[] = ($percentage / 100) * $unitPrice;
            }

            // Create new invoice
            $invoice = new StudentInvoice();
            $invoice->student_id = $request->input('student_id');
            $invoice->unitprice = $unitPrice;
            $invoice->amount = array_sum($splitupAmounts); // Total amount after splitup
            $invoice->gst = $request->input('gst');
            $invoice->total_amount = $invoice->amount + $invoice->gst;
            $invoice->fees_id = $selectedTitleId;
            $invoice->splitup = json_encode($splitupAmounts); // Store the splitup as a JSON array
            $invoice->save();

            return redirect()->route('invoice.index'); // Redirect to the invoice listing page
        }

        $incomeheadData = IncomeHead::all();

        $centerdetails = Center::all();


        // Pass data to the view, including tax details and total tax sum
        return view('dashboard.studentinvoice.create', [
            'incomeheadData' => $incomeheadData,
            'centerdetails' => $centerdetails,
            'students' => $students,
            'gstValue' => $gstValue,
            'generalData' => $generalData,
            'nextInvoiceNumber' => $nextInvoiceNumber,
            'feeTitles' => $feeTitles,
            'feeDetails' => $feeDetails,
            'taxDetails' => $taxDetails,
            'totalTaxSum' => round($totalTaxSum, 2), // Pass total tax sum to the view
        ]);
    }


    // getfeedetails
    public function getFeeDetails($id)
    {
        $fee = Fee::find($id);

        if ($fee) {
            // If `splitup` is a JSON string, decode it
            if (is_string($fee->splitup)) {
                $fee->splitup = json_decode($fee->splitup);
            }

            // Return the fee details as a JSON response
            return response()->json([
                'splitup' => $fee->splitup,
                'taxes' => $fee->taxes, // Assuming 'taxes' is a property of the Fee model
            ]);
        }

        return response()->json(['error' => 'Fee not found'], 404);
    }


    // store
   public function store(Request $request)
{
    // Validate the input fields
    $validated = $request->validate([
        'center' => 'required|exists:center,id', // Ensure center exists in the database
        'description' => 'required|string|max:255',
        'unitprice' => 'required|numeric',
        'amount' => 'required|numeric',
        'gst' => 'required|numeric',
        'total_amount' => 'required|numeric',
        'student_id' => 'required|exists:students,id',
        'balanceamount' => 'nullable|numeric',
        'invoicedate' => 'required|date',
        'transactionmethod' => 'required|string',
        'transactionid' => 'nullable|string',
        'bankaccount' => 'nullable|string',
        'generatedby' => 'nullable|string',
        'notes' => 'nullable|string',
        'feeselect' => 'required|array',
        'splitup' => 'nullable|string', // Add validation for splitup (JSON string)
        'gstAmt' => 'nullable|string',
    ]);

    // Retrieve student by ID
    $student = Student::findOrFail($request->input('student_id'));

    // Initialize unit price
    $unitPrice = $request->input('unitprice');
    $gstRate = 18; // Default GST rate (adjust if needed)
    $gstAmount = $unitPrice * ($gstRate / (100 + $gstRate)); // GST-inclusive formula
    $amountExcludingGST = $unitPrice - $gstAmount; // Amount excluding GST
    $totalAmount = $unitPrice; // Total amount (equal to unit price)

    // Get selected fee masters
    $feeMasters = $request->input('feeselect', []);
    $splitupPercentages = json_decode($request->input('splitup'), true) ?: [100]; // Default to 100% if splitup is empty
    $splitupAmounts = []; // Array to hold split-up amounts

    // Process each selected FeeMaster
    foreach ($feeMasters as $feeId) {
        $fee = Fee::find($feeId); // Fetch FeeMaster details

        // Process split-up logic
        foreach ($splitupPercentages as $percentage) {
            $splitupAmount = ($percentage / 100) * $unitPrice;
            $splitupAmounts[] = $splitupAmount;
        }
    }

    $string = $request->splitup;
    // Normalize the string by replacing multiple spaces and commas
    $splitup = preg_split('/[\s,]+/', trim($string));

    // Check if the first element is '0' and remove it
    if (isset($splitup[0]) && $splitup[0] == '0') {
        array_shift($splitup); // Remove the first element
    }

    // Calculate balance amount
    $balanceAmount = $student->course_fee - $unitPrice;
    $gstAmt = $request->input('gstAmt'); // Get the gstAmt from the request
    $gstAmtArray = $gstAmt ? explode(',', $gstAmt) : [];

    // Calculate the next invoice number
    $lastInvoice = Invoices::orderBy('invoiceNumber', 'desc')->first();
    $nextInvoiceNumber = $lastInvoice ? $lastInvoice->invoiceNumber + 1 : 1;

    // Retrieve the prefix from generalsettings table
    $prefix = GeneralSettings::first()->prefix; // Assuming prefix is stored in the `prefix` field

    // Create a new student invoice
    $invoice = new StudentInvoice();
    $invoice->center = $request->input('center');
    $invoice->description = $request->input('description');
    $invoice->unitprice = $unitPrice;
    $invoice->amount = $request->amount;
    $invoice->gst = $request->gst;
    $invoice->total_amount = $totalAmount;
    $invoice->student_id = $student->id;
    $invoice->transactionmethod = $request->input('transactionmethod');
    $invoice->transactionid = $request->input('transactionid');
    $invoice->invoiceno = $prefix . $nextInvoiceNumber; // Prefix the invoice number with the `prefix`
    $invoice->notes = $request->input('notes');
    $invoice->balanceamount = $request->balanceamount;
    $invoice->generatedby = $request->input('generatedby');
    $invoice->bankaccount = $request->input('bankaccount');
    $invoice->invoicedate = $request->input('invoicedate');
    $invoice->fees_id = implode(',', $feeMasters); // Save FeeMaster IDs as a comma-separated string
    $invoice->splitup = json_encode($splitup); // Store the splitup amounts as a JSON array
    if (!empty($gstAmtArray)) {
        $invoice->gstAmt = json_encode($gstAmtArray); // Store the GST amounts as a JSON array
    }
    $invoice->save();

    // Prepare data for the Invoices table
    $datas['invoiceNumber'] = $nextInvoiceNumber;
    $datas['studentinvoiceid'] = $invoice->id;

    // Create the invoice record in the Invoices table
    Invoices::create($datas);

    $incomeDetailsData = [
        'head' => $request->head,
        'center' => $request->center,
        'date' => $request->invoicedate,
        'name' => $request->name,
        'amount' => $request->total_amount,
        'method' => $request->transactionmethod,
        'invoiceno' => $request->invoiceno,
    ];
    Incomedetails::create($incomeDetailsData);

    // Redirect with a success message
    return redirect('/admin/studentinvoice')->with('success', 'Invoice created successfully.');
}



    // gettaxdetails
    public function gettaxdetails($id)
    {
        // dd($id);

        // Step 1: Fetch all student invoices related to this Fee ID
        $studentInvoices = StudentInvoice::where('fees_id', $id)->get();

        if ($studentInvoices->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No invoices found for this Fee ID.',
            ]);
        }

        // Step 2: Fetch tax details associated with this fee
        $fee = Fee::find($id);
        if (!$fee) {
            return response()->json([
                'success' => false,
                'message' => 'Fee record not found.',
            ]);
        }

        $taxes = json_decode($fee->taxes, true); // Tax IDs for splitup values
        if (empty($taxes)) {
            return response()->json([
                'success' => false,
                'message' => 'No taxes associated with this Fee ID.',
            ]);
        }

        // Step 3: Fetch all tax details from the database
        $flattenedTaxIds = array_merge(...$taxes); // Flatten nested arrays
        $taxDetails = Tax::whereIn('id', $flattenedTaxIds)->get()->keyBy('id');

        // Step 4: Calculate taxes dynamically for each student invoice's splitup amounts
        $allCalculatedTaxes = [];
        $totalTaxSum = 0; // Initialize total tax sum

        foreach ($studentInvoices as $invoice) {
            $splitup = json_decode($invoice->splitup, true); // Decode splitup from invoice

            if (empty($splitup)) {
                continue; // Skip if splitup data is missing
            }

            $calculatedTaxes = [];
            foreach ($splitup as $index => $amount) {
                $currentTaxGroup = $taxes[$index] ?? []; // Tax IDs for the current splitup
                $totalPercentage = 0;
                $totalTax = 0;

                foreach ($currentTaxGroup as $taxId) {
                    if (isset($taxDetails[$taxId])) {
                        $tax = $taxDetails[$taxId];
                        $totalPercentage += $tax->total; // Add tax percentage
                        $totalTax += $amount * ($tax->total / 100); // Calculate tax for the splitup amount
                    }
                }

                $calculatedTaxes[] = [
                    'splitup_amount' => $amount,
                    'total_percentage' => $totalPercentage,
                    'calculated_tax' => round($totalTax, 2),
                ];

                // Add to total tax sum
                $totalTaxSum += $totalTax;
            }

            // Step 5: Update the student invoice with calculated taxes
            $invoice->update([
                'calculated_taxes' => json_encode($calculatedTaxes),
            ]);

            // Append to the overall result
            $allCalculatedTaxes[] = [
                'invoice_id' => $invoice->id,
                'calculated_taxes' => $calculatedTaxes,
            ];
        }

        // Step 6: Return the dynamically calculated taxes and total tax sum
        return response()->json([
            'success' => true,
            'message' => 'Tax details calculated and stored successfully.',
            'total_tax_sum' => round($totalTaxSum, 2), // Total sum of calculated taxes
            'all_calculated_taxes' => $allCalculatedTaxes,
        ]);
    }


    // splitup
    public function calculateSplitup(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'feemaster_id' => 'required|exists:fees,id',
            'unitprice' => 'required|numeric|min:0',
        ]);

        // Fetch FeeMaster details
        $feeDetail = Fee::find($validated['feemaster_id']);
        $unitprice = $validated['unitprice'];

        // Decode the JSON string stored in splitup
        $splitups = json_decode($feeDetail->splitup, true); // Decode JSON string to PHP array
        Log::info('Decoded splitup:', ['splitups' => $splitups]);


        if (!$splitups || !is_array($splitups)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid splitup data in database.',
            ]);
        }

        $splitAmounts = [];

        // Calculate the split amounts
        foreach ($splitups as $percentage) {
            $splitAmounts[] = ($percentage / 100) * $unitprice;
        }

        // Return the split amounts as a JSON response
        return response()->json([
            'success' => true,
            'splitAmounts' => $splitAmounts,
        ]);
    }



    // delete

    public function destroy($id)
    {
        // Find the student invoice by its ID
        $invoice = StudentInvoice::find($id);

        if ($invoice) {
            // Delete the associated income details using the invoice number
            $incomeDetail = IncomeDetails::where('invoiceno', $invoice->invoiceno)->first();

            if ($incomeDetail) {
                // Delete the income detail record
                $incomeDetail->delete();
            }

            // Delete the student invoice
            $invoice->delete();

            return response()->json(['message' => 'Student invoice and associated income details deleted successfully!'], 200);
        }

        return response()->json(['message' => 'Student invoice not found!'], 404);
    }

    // edit

    public function edit($id)
    {
        $studentinvoicedata = Studentinvoice::with('student', 'centers')->findOrFail($id); // Load 'centers' relationship
        $centerdetails = Center::all();
    
        $students = Student::with('course')->get(); // To populate the student dropdown
        $transactionMethods = config('global.TransactonMethod');
    
        // Fetch the latest GST value from the Gst table
        $gstValue = Gst::latest()->value('gstvalue');
        $feeTitles = Fee::pluck('title', 'id')->toArray();
        $selectedFees = explode(',', $studentinvoicedata->fees_id);
    
        return view('dashboard.studentinvoice.edit', compact(
            'studentinvoicedata', 
            'students', 
            'gstValue', 
            'transactionMethods', 
            'selectedFees', 
            'feeTitles', 
            'centerdetails'
        ));
    }
    

    
    // public function update(Request $request, $id)
    // {
    //     // Fetch the existing student invoice
    //     $studentinvoice = StudentInvoice::findOrFail($id);

    //     // Validate the input fields
    //     $validated = $request->validate([
    //         'description' => 'required|string|max:255',
    //         'unitprice' => 'required|numeric',
    //         'amount' => 'required|numeric',
    //         'gst' => 'required|numeric',
    //         'total_amount' => 'required|numeric',
    //         'student_id' => 'required|exists:students,id',
    //         'balanceamount' => 'nullable|numeric',
    //         'invoicedate' => 'required|date',
    //         'transactionmethod' => 'required|string',
    //         'transactionid' => 'nullable|string',
    //         'bankaccount' => 'nullable|string',
    //         'generatedby' => 'nullable|string',
    //         'notes' => 'nullable|string',
    //         'feeselect' => 'required|array',
    //         'splitup' => 'nullable|string', // Add validation for splitup (JSON string)
    //     ]);


    //     // Retrieve the student by ID
    //     $student = Student::findOrFail($request->input('student_id'));

    //     // Initialize unit price
    //     $unitPrice = $request->input('unitprice');
    //     $gstRate = 18; // Default GST rate (adjust if needed)
    //     $gstAmount = $unitPrice * ($gstRate / (100 + $gstRate)); // GST-inclusive formula
    //     $amountExcludingGST = $unitPrice - $gstAmount; // Amount excluding GST
    //     $totalAmount = $unitPrice; // Total amount (equal to unit price)

    //     // Get selected fee masters
    //     $feeMasters = $request->input('feeselect', []);
    //     $splitupPercentages = json_decode($request->input('splitup'), true) ?: [100]; // Default to 100% if splitup is empty
    //     $splitupAmounts = []; // Array to hold split-up amounts

    //     // Process each selected FeeMaster
    //     foreach ($feeMasters as $feeId) {
    //         $fee = Fee::find($feeId); // Fetch FeeMaster details

    //         // Process split-up logic
    //         foreach ($splitupPercentages as $percentage) {
    //             $splitupAmount = ($percentage / 100) * $unitPrice;
    //             $splitupAmounts[] = $splitupAmount;
    //         }
    //     }

    //     // Normalize the splitup string
    //     $string = $request->splitup;
    //     $splitup = preg_split('/[\s,]+/', trim($string));

    //     // Check if the first element is '0' and remove it
    //     if (isset($splitup[0]) && $splitup[0] == '0') {
    //         array_shift($splitup);
    //     }

    //     // Calculate balance amount
    //     $balanceAmount = $student->course_fee - $unitPrice;

    //     // Update the student invoice
    //     $studentinvoice->description = $request->input('description');
    //     $studentinvoice->unitprice = $unitPrice;
    //     $studentinvoice->amount = $request->amount;
    //     $studentinvoice->gst = $request->gst;
    //     $studentinvoice->total_amount = $totalAmount;
    //     $studentinvoice->student_id = $student->id;
    //     $studentinvoice->transactionmethod = $request->input('transactionmethod');
    //     $studentinvoice->transactionid = $request->input('transactionid');
    //     $studentinvoice->notes = $request->input('notes');
    //     $studentinvoice->balanceamount = $request->balanceamount;
    //     $studentinvoice->generatedby = $request->input('generatedby');
    //     $studentinvoice->bankaccount = $request->input('bankaccount');
    //     $studentinvoice->invoicedate = $request->input('invoicedate');
    //     $studentinvoice->fees_id = implode(',', $feeMasters); // Save FeeMaster IDs as a comma-separated string
    //     $studentinvoice->splitup = json_encode($splitup); // Store the splitup amounts as a JSON array
    //     $studentinvoice->save();

    //     // Redirect with a success message
    //     return redirect('/admin/studentinvoice')->with('success', 'Invoice updated successfully.');
    // }

    //update
    public function update(Request $request, $id)
{
    // Fetch the existing student invoice
    $studentinvoice = StudentInvoice::findOrFail($id);

    // Validate the input fields
    $validated = $request->validate([
        'description' => 'required|string|max:255',
        'unitprice' => 'required|numeric',
        'amount' => 'required|numeric',
        'gst' => 'required|numeric',
        'total_amount' => 'required|numeric',
        'student_id' => 'required|exists:students,id',
        'balanceamount' => 'nullable|numeric',
        'invoicedate' => 'required|date',
        'transactionmethod' => 'required|string',
        'transactionid' => 'nullable|string',
        'bankaccount' => 'nullable|string',
        'generatedby' => 'nullable|string',
        'notes' => 'nullable|string',
        'feeselect' => 'required|array',
        'splitup' => 'nullable|string', // Add validation for splitup (JSON string)
    ]);

    // Retrieve the student by ID
    $student = Student::findOrFail($request->input('student_id'));

    // Initialize unit price
    $unitPrice = $request->input('unitprice');
    $gstRate = 18; // Default GST rate (adjust if needed)
    $gstAmount = $unitPrice * ($gstRate / (100 + $gstRate)); // GST-inclusive formula
    $amountExcludingGST = $unitPrice - $gstAmount; // Amount excluding GST
    $totalAmount = $unitPrice; // Total amount (equal to unit price)

    // Get selected fee masters
    $feeMasters = $request->input('feeselect', []);
    $splitupPercentages = json_decode($request->input('splitup'), true) ?: [100]; // Default to 100% if splitup is empty
    $splitupAmounts = []; // Array to hold split-up amounts

    // Process each selected FeeMaster
    foreach ($feeMasters as $feeId) {
        $fee = Fee::find($feeId); // Fetch FeeMaster details

        // Process split-up logic
        foreach ($splitupPercentages as $percentage) {
            $splitupAmount = ($percentage / 100) * $unitPrice;
            $splitupAmounts[] = $splitupAmount;
        }
    }

    // Normalize the splitup string
    $string = $request->splitup;
    $splitup = preg_split('/[\s,]+/', trim($string));

    // Check if the first element is '0' and remove it
    if (isset($splitup[0]) && $splitup[0] == '0') {
        array_shift($splitup);
    }

    // Update the student invoice
    $studentinvoice->description = $request->input('description');
    $studentinvoice->unitprice = $unitPrice;
    $studentinvoice->amount = $request->amount;
    $studentinvoice->gst = $request->gst;
    $studentinvoice->total_amount = $totalAmount;
    $studentinvoice->student_id = $student->id;
    $studentinvoice->transactionmethod = $request->input('transactionmethod');
    $studentinvoice->transactionid = $request->input('transactionid');
    $studentinvoice->notes = $request->input('notes');
    $studentinvoice->balanceamount = $request->input('balanceamount');

    $studentinvoice->generatedby = $request->input('generatedby');
    $studentinvoice->bankaccount = $request->input('bankaccount');
    $studentinvoice->invoicedate = $request->input('invoicedate');
    $studentinvoice->fees_id = implode(',', $feeMasters); // Save FeeMaster IDs as a comma-separated string
    $studentinvoice->splitup = json_encode($splitup); // Store the splitup amounts as a JSON array
    $studentinvoice->save();

    // Find and update the corresponding income details
    $incomeDetails = Incomedetails::where('invoiceno', $studentinvoice->invoiceno)->first();
    if ($incomeDetails) {
        $incomeDetails->head = $request->input('head', $incomeDetails->head);
        $incomeDetails->center = $request->input('center', $incomeDetails->center);
        $incomeDetails->date = $request->input('invoicedate', $incomeDetails->date);
        $incomeDetails->name = $request->input('name', $incomeDetails->name);
        $incomeDetails->amount = $request->input('total_amount', $incomeDetails->amount);
        $incomeDetails->method = $request->input('transactionmethod', $incomeDetails->method);
        $incomeDetails->save();
    }

    // Redirect with a success message
    return redirect('/admin/studentinvoice')->with('success', 'Invoice and income details updated successfully.');
}

}
