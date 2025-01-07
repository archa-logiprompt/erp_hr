<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GstReport;  // Ensure this is correctly imported
use App\Models\Studentinvoice;
use App\Models\Student;  // Correct import for Student model
use App\Models\ClientInvoice;
use App\Models\ClientDetails;  // Correct import for ClientDetails model

class GstreportController extends Controller
{
    public function index()
    {
        // Fetch all GST report details from your database
        $gstreportdetails = \App\Models\GstReport::all();
        
        // Pass the gstreportdetails to the view
        return view('dashboard.gstreport.index', compact('gstreportdetails'));
    }
    
    public function create()
    {
        return view('dashboard.gstreport.create');
    }

    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'gstreport' => 'required|string',
            'fromDate' => 'required|date|before_or_equal:toDate',
            'toDate' => 'required|date|after_or_equal:fromDate',
        ]);

        // Get the input values
        $gstReport = $validated['gstreport'];
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        // Initialize an empty collection for invoices
        $invoices = collect();

        // Process based on the selected GST report category
        switch ($gstReport) {
            case 'all':
                // Fetch all invoices (both student and client) within the date range
                $studentInvoices = \App\Models\Studentinvoice::whereBetween('invoicedate', [$fromDate, $toDate])
                    ->get()
                    ->each(function ($invoice) {
                        // Add student name
                        $invoice->companyOrStudentName = $invoice->student ? $invoice->student->studentname : 'N/A';
                    });

                $clientInvoices = \App\Models\ClientInvoice::whereBetween('invoiceDate', [$fromDate, $toDate])
                    ->get()
                    ->each(function ($invoice) {
                        $invoice->invoiceno = $invoice->prefix . $invoice->invoiceNumber; // Concatenate prefix with invoiceno
                        // Add client company name
                        $invoice->companyOrStudentName = $invoice->client ? $invoice->client->companyName : 'N/A';
                    });

                $invoices = $studentInvoices->concat($clientInvoices);
                break;

            case 'business to business':
                // Fetch student invoices where the related student's GST is not null within the date range
                $studentInvoices = \App\Models\Studentinvoice::whereHas('student', function ($query) {
                    $query->whereNotNull('gstno');
                })->whereBetween('invoicedate', [$fromDate, $toDate])
                ->get()
                ->each(function ($invoice) {
                    // Add student name
                    $invoice->companyOrStudentName = $invoice->student ? $invoice->student->studentname : 'N/A';
                });

                // Fetch client invoices where GST fields are not null within the date range
                $clientInvoices = \App\Models\ClientInvoice::whereNotNull('gsts')
                    ->whereBetween('invoiceDate', [$fromDate, $toDate])
                    ->get()
                    ->each(function ($invoice) {
                        $invoice->invoiceno = $invoice->prefix . $invoice->invoiceNumber; // Concatenate prefix with invoiceno
                        // Add client company name
                        $invoice->companyOrStudentName = $invoice->client ? $invoice->client->companyName : 'N/A';
                    });

                $invoices = $studentInvoices->concat($clientInvoices);
                break;

            case 'business to customer':
                // Fetch student invoices where the related student's GST is null within the date range
                $studentInvoices = \App\Models\Studentinvoice::whereHas('student', function ($query) {
                    $query->whereNull('gstno');
                })->whereBetween('invoicedate', [$fromDate, $toDate])
                ->get()
                ->each(function ($invoice) {
                    // Add student name
                    $invoice->companyOrStudentName = $invoice->student ? $invoice->student->studentname : 'N/A';
                });

                // Fetch client invoices where GST fields are null within the date range
                $clientInvoices = \App\Models\ClientInvoice::whereNull('gsts')
                    ->whereBetween('invoiceDate', [$fromDate, $toDate])
                    ->get()
                    ->each(function ($invoice) {
                        $invoice->invoiceno = $invoice->prefix . $invoice->invoiceNumber; // Concatenate prefix with invoiceno
                        // Add client company name
                        $invoice->companyOrStudentName = $invoice->client ? $invoice->client->companyName : 'N/A';
                    });

                $invoices = $studentInvoices->concat($clientInvoices);
                break;

            default:
                // Redirect back with an error message for invalid category
                return redirect()->back()->with('error', 'Invalid GST Report category selected.');
        }

        // Return the create page with the invoices passed to the view
        return view('dashboard.gstreport.create', compact('invoices'));
    }

    public function destroy($id)
    {
        GstReport::destroy($id);

        return redirect()->back(); 
    }
    
    public function edit($id)
    {
        $gstreportdata = GstReport::find($id);
     
        return view('dashboard.gstreport.edit', compact('gstreportdata'));
    }
    
    public function update(Request $request, $id)
    {
        $data = $request->except(['id','_token']);

        GstReport::find($id)->update($data);
     
        return redirect('/admin/gstreport');
    }
}
