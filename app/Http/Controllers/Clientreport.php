<?php

namespace App\Http\Controllers;

use App\Models\ClientInvoice;
use Illuminate\Http\Request;

class Clientreport extends Controller
{
    public function create()
    {
        return view('dashboard.clientReport.index');
    }

    public function index(Request $request)
    
        {
            $clientinvoiceDetails = [];
    
            // Check if both fromDate and toDate are provided
            if ($request->filled('fromDate') && $request->filled('toDate')) {
                $fromDate = $request->input('fromDate');
                $toDate = $request->input('toDate');
    
                // Query the database with the date range
                $clientinvoiceDetails = ClientInvoice::with(['client', 'project'])
                    ->whereBetween('invoiceDate', [$fromDate, $toDate])
                    ->get();
            }
    
            return view('dashboard.clientReport.index', compact('clientinvoiceDetails'));
        }

}
