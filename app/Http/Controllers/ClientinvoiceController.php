<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\ClientDetails;
use Illuminate\Http\Request;
use App\Models\ClientInvoice;
use App\Models\GeneralSettings;
use App\Models\Invoices;
use App\Models\Project;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Gst;
use App\Models\Incomedetails;
use App\Models\IncomeHead;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ClientinvoiceController extends Controller
{
    public function index()
    {

        $clientinvoiceDetails = ClientInvoice::with(['client', 'project', 'centers'])
        ->orderBy('created_at', 'desc') 
        ->get();
$totalAmount = $clientinvoiceDetails->sum('total');
        // dd($clientinvoiceDetails);

        return view('dashboard.clientInvoice.index', compact('clientinvoiceDetails','totalAmount'));
    }


    public function create(Request $request)
    {
        $clientDetails = ClientDetails::with('projects')->get();
        $projects = Project::all();
        $gst = gst::first();
        $generalData = GeneralSettings::first();
        $clientinvoice = Clientinvoice::all();
    
        // Get the last invoice number
        $lastInvoice = Invoices::orderBy('invoiceNumber', 'desc')->first();
    
        // Safely calculate the next invoice number
        $nextInvoiceNumber = $lastInvoice ? (int)$lastInvoice->invoiceNumber + 1 : 1;
    
        $generalData = $generalData ?? [];
        $incomeheadData = IncomeHead::all();
    
        $centerdetails = Center::all();
        
        
    
        return view('dashboard.clientInvoice.create', compact(
            'clientDetails', 
            'gst', 
            'generalData', 
            'projects', 
            'nextInvoiceNumber', 
            'incomeheadData', 
            'centerdetails',
            'clientinvoice' // Passing clientinvoice to view
        ));
    }
    



public function store(Request $request)
{
    // Validate incoming data
    $request->validate([
        'invoiceDate' => 'required|date',
        'client' => 'required|exists:client_details,id',
        'center' => 'required|exists:center,id',
        'projectfee' => 'nullable|numeric|min:1',
        'project' => 'required|exists:projects,id',
        'transactionMethod' => 'required',
        'transactionId' => 'nullable|string',
        'invoiceNumber' => 'required|unique:client_invoice_details,invoiceNumber',
        'transactionTitle' => 'nullable|array',
        'transactionTitle.*' => 'nullable|string', // Validate array elements
        'unitPrice' => 'required|array|min:1',
        'unitPrice.*' => 'required|numeric|min:0',
        'amount' => 'nullable|array',
        'amount.*' => 'nullable|numeric|min:0',
        'gsts' => 'nullable|array',
        'gsts.*' => 'nullable|numeric|min:0', // Validate array elements
        'description' => 'nullable|array|min:1',
        'description.*' => 'nullable|string|min:0',
        'grandtotal' => 'nullable|numeric|min:0',
        'gstamount' => 'nullable|numeric|min:0',
        'subtotal' => 'nullable|numeric|min:0',
        'title' => 'required|string|max:255',
        'note' => 'nullable|string',
        'balance' => 'nullable|numeric|min:0',
        'invoicePrefix' => 'nullable|string|max:10',
        'document' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048',
    ]);

    // Handle file upload if exists
    $documentPath = null;
    if ($request->hasFile('document')) {
        try {
            $document = $request->file('document');
            $documentPath = time() . '_' . $document->getClientOriginalName();
            $document->move(public_path('Invoicedocument'), $documentPath);
            $documentPath = 'Invoicedocument/' . $documentPath;
        } catch (\Exception $e) {
            return back()->withErrors(['document' => 'File upload failed: ' . $e->getMessage()]);
        }
    }

    // Collect the invoice data
    $invoiceData = $request->except('_token', 'gst', 'invoicePrefix');
    $invoiceData['clientName'] = $request->client;
    $invoiceData['total'] = $request->grandtotal;
    $invoiceData['center'] = $request->center;
    $invoiceData['projectfee'] = $request->projectfee;

    // Add the invoicePrefix (the prefix from the form) to the data
    $invoiceData['prefix'] = $request->invoicePrefix;  // Store the prefix

    // Calculate remaining balance
    $remainingBalance = $request->balance - $request->grandtotal;
    $invoiceData['balance'] = $remainingBalance;

    // Ensure JSON fields are correctly encoded
    if ($request->has('transactionTitle')) {
        $invoiceData['transactionTitle'] = json_encode($request->transactionTitle);
    }
    if ($request->has('unitPrice')) {
        $invoiceData['unitPrice'] = json_encode($request->unitPrice);
    }
    if ($request->has('amount')) {
        $invoiceData['amount'] = json_encode($request->amount);
    }
    if ($request->has('gsts')) {
        $invoiceData['gsts'] = json_encode($request->gsts);
    }
    if ($request->has('description')) {
        $invoiceData['description'] = json_encode($request->description);
    }

    if ($documentPath) {
        $invoiceData['document'] = $documentPath;
    }

    // Create the client invoice record
    try {
        $clientInvoice = Clientinvoice::create($invoiceData);
    } catch (\Exception $e) {
        return back()->withErrors(['invoice' => 'Invoice creation failed: ' . $e->getMessage()]);
    }

    // Create the invoice record with the prefix
    $datas = [
        'invoiceNumber' => $request->invoiceNumber,
        'invoiceid' => $clientInvoice->id,
        'prefix' => $request->invoicePrefix, // Save the prefix
    ];

    try {
        Invoices::create($datas);
    } catch (\Exception $e) {
        return back()->withErrors(['invoiceRecord' => 'Invoice record creation failed: ' . $e->getMessage()]);
    }

    // Save income details
    $incomeDetailsData = [
        'head' => $request->head,
        'center' => $request->center,
        'date' => $request->invoiceDate,
        'name' => $request->name,
        'amount' => $request->grandtotal,
        'method' => $request->transactionMethod,
        'invoiceno' => $request->invoiceNumber,
    ];

    try {
        Incomedetails::create($incomeDetailsData);
    } catch (\Exception $e) {
        return back()->withErrors(['incomeDetails' => 'Income details creation failed: ' . $e->getMessage()]);
    }

    return redirect('/admin/clientinvoice')->with('success', 'Invoice created successfully!');
}


 


    public function destroy($id)
    {
        // Find the invoice by its ID
        $invoice = ClientInvoice::find($id);

        if ($invoice) {
            // Delete the associated income details using the invoice number
            $incomeDetail = Incomedetails::where('invoiceno', $invoice->invoiceNumber)->first();

            if ($incomeDetail) {
                // Delete the income detail record
                $incomeDetail->delete();
            }

            // Delete the invoice
            $invoice->delete();

            return response()->json(['message' => 'Client invoice and associated income details deleted successfully!'], 200);
        }

        return response()->json(['message' => 'Invoice not found!'], 404);
    }


    // public function destroy($id)
    // {

    //     ClientInvoice::destroy($id);
    //     return response()->json(['message' => 'Client invoice deleted successfully !'], 200);
    // }


     public function edit($invoiceNumber)
{
    // Fetch the invoice data along with the client details
    $invoiceData = ClientInvoice::with(['project', 'client.projects'])
        ->where('invoiceNumber', $invoiceNumber)
        ->firstOrFail();

    // Fetch all clients, including their projects and company names
    $clientDetails = ClientDetails::with(['projects'])->get();

    $generalData = GeneralSettings::first();
    $gst = Gst::first();
    $clientinvoice = Clientinvoice::all();

    // Decode JSON data to arrays if necessary
    $transactionTitle = json_decode($invoiceData->transactionTitle, true);
    $unitPrices = json_decode($invoiceData->unitPrice, true);
    $description = json_decode($invoiceData->description, true);
    $gsts = json_decode($invoiceData->gsts, true);
    $incomeheadData = IncomeHead::all();
    $centerdetails = Center::all();

    return view('dashboard.clientInvoice.edit', compact(
        'invoiceData',
        'gst',
        'gsts',
        'clientDetails',
        'generalData',
        'transactionTitle',
        'description',
        'unitPrices',
        'incomeheadData',
        'centerdetails',
        'clientinvoice'
    ));
}




    public function update(Request $request, $invoiceNumber)
    {
        // Validate the incoming request
        $request->validate([
            'invoiceDate' => 'nullable|date|before_or_equal:today',
            'transactionMethod' => 'nullable|string',
            'transactionId' => 'nullable|string',
            'balance' => 'nullable',

            'transactionTitle' => 'nullable|array',
            'unitPrice' => 'nullable|array',
            'amount' => 'nullable|array',
            'description' => 'nullable|array',
            'gsts' => 'nullable|array',
            'grandtotal' => 'nullable|numeric|min:0',
            'note' => 'nullable|string',
            'gstamount' => 'nullable|numeric|min:0',
            'subtotal' => 'nullable|numeric|min:0',
            'title' => 'nullable|string',
            'document' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048',
        ]);

        // Fetch the client invoice by invoiceNumber
        $clientInvoice = ClientInvoice::where('invoiceNumber', $invoiceNumber)->firstOrFail();

        // Handle the uploaded document
        $documentPath = $clientInvoice->document; // Keep the current document path
        if ($request->hasFile('document')) {
            // Delete the old document if it exists
            if ($documentPath && file_exists(public_path($documentPath))) {
                unlink(public_path($documentPath));
            }

            // Save the new document
            $document = $request->file('document');
            $documentName = time() . '_' . $document->getClientOriginalName();
            $document->move(public_path('Invoicedocument'), $documentName);
            $documentPath = 'Invoicedocument/' . $documentName;
        }

        // Prepare the data for update
        $invoiceData = $request->except(['_token', 'gst', 'invoicePrefix', 'document']);
        $invoiceData['total'] = $request->input('grandtotal', 0); // Default to 0 if not provided

        // Encode array fields as JSON
        $jsonFields = ['transactionTitle', 'unitPrice', 'amount', 'description', 'gsts'];
        foreach ($jsonFields as $field) {
            if ($request->has($field)) {
                $invoiceData[$field] = json_encode($request->input($field));
            }
        }

        $remainingBalance = $request->balance - $request->grandtotal;
        $invoiceData['balance'] = $remainingBalance;

        // Include the document path if updated
        if ($documentPath) {
            $invoiceData['document'] = $documentPath;
        }

        // Update the client invoice
        $clientInvoice->update($invoiceData);

        // Now, update the IncomeDetails table
        $incomeDetailsData = [
            'head' => $request->input('head'),
            'center' => $request->input('center'),
            'date' => $request->input('invoiceDate'),
            'name' => $request->input('name'),
            'amount' => $request->input('grandtotal'),
            'method' => $request->input('transactionMethod'),
            'invoiceno' => $invoiceNumber, // Ensure this matches the invoice number for the income record
        ];

        // Check if the Incomedetails record exists for this invoice number
        $incomeDetails = Incomedetails::where('invoiceno', $invoiceNumber)->first();

        if ($incomeDetails) {
            // If found, update the record
            $incomeDetails->update($incomeDetailsData);
        } else {
            // If not found, create a new record
            Incomedetails::create($incomeDetailsData);
        }

        // Return a JSON response for success
        return response()->json(['message' => 'Client invoice and income details updated successfully!'], 200);
    }


    // public function update(Request $request, $invoiceNumber)
    // {
    //     // Validate the incoming request
    //     $request->validate([
    //         'invoiceDate' => 'nullable|date|before_or_equal:today',
    //         'transactionMethod' => 'nullable|string',
    //         'transactionId' => 'nullable|string',
    //         'transactionTitle' => 'nullable|array',
    //         'unitPrice' => 'nullable|array',
    //         'amount' => 'nullable|array',
    //         'description' => 'nullable|array',
    //         'gsts' => 'nullable|array',
    //         'grandtotal' => 'nullable|numeric|min:0',
    //         'note' => 'nullable|string',
    //         'gstamount' => 'nullable|numeric|min:0',
    //         'subtotal' => 'nullable|numeric|min:0',
    //         'title' => 'nullable|string',
    //         'document' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048',
    //     ]);

    //     // Fetch the client invoice by invoiceNumber
    //     $clientInvoice = ClientInvoice::where('invoiceNumber', $invoiceNumber)->firstOrFail();

    //     // Handle the uploaded document
    //     $documentPath = $clientInvoice->document; // Keep the current document path
    //     if ($request->hasFile('document')) {
    //         // Delete the old document if it exists
    //         if ($documentPath && file_exists(public_path($documentPath))) {
    //             unlink(public_path($documentPath));
    //         }

    //         // Save the new document
    //         $document = $request->file('document');
    //         $documentName = time() . '_' . $document->getClientOriginalName();
    //         $document->move(public_path('Invoicedocument'), $documentName);
    //         $documentPath = 'Invoicedocument/' . $documentName;
    //     }

    //     // Prepare the data for update
    //     $invoiceData = $request->except(['_token', 'gst', 'invoicePrefix', 'document']);
    //     $invoiceData['total'] = $request->input('grandtotal', 0); // Default to 0 if not provided

    //     // Encode array fields as JSON
    //     $jsonFields = ['transactionTitle', 'unitPrice', 'amount', 'description', 'gsts'];
    //     foreach ($jsonFields as $field) {
    //         if ($request->has($field)) {
    //             $invoiceData[$field] = json_encode($request->input($field));
    //         }
    //     }

    //     // Include the document path if updated
    //     if ($documentPath) {
    //         $invoiceData['document'] = $documentPath;
    //     }

    //     // Update the client invoice
    //     $clientInvoice->update($invoiceData);

    //     // Return a JSON response for success
    //     return response()->json(['message' => 'Client invoice updated successfully!'], 200);
    // }



    // view invoice pdf
    public function view(Request $request, $id)
    {

        $invoiceData = ClientInvoice::with(['project', 'client'])->findOrFail($id);
        $clientDetails = ClientDetails::with('projects')->get();
        $generalData = Gst::first();

        $transactionTitle = json_decode($invoiceData->transactionTitle, true);
        $unitPrices = json_decode($invoiceData->unitPrice, true);
        $description = json_decode($invoiceData->description, true);
        $amount = json_decode($invoiceData->amount, true);
        $gsts = json_decode($invoiceData->gsts, true);
        // dd($invoiceData); 

        // $pdf = PDF::set_option('default_paper_orientation','portrait');
        $generalSettings = GeneralSettings::first();


        $pdf = PDF::loadView('dashboard.invoicePdf.index', compact('invoiceData', 'generalSettings', 'gsts', 'amount', 'clientDetails', 'generalData', 'transactionTitle', 'description', 'unitPrices'));

        return $pdf->stream('invoice.pdf');



        return view('dashboard.invoicePdf.index', compact('invoiceData', 'gsts', 'generalSettings', 'amount', 'clientDetails', 'generalData', 'transactionTitle', 'description', 'unitPrices'));
    }
}
