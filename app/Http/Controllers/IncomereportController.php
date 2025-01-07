<?php

namespace App\Http\Controllers;

use App\Models\Center;
use Illuminate\Http\Request;
use App\Models\Incomedetails;
use App\Models\IncomeHead;

class IncomereportController extends Controller
{
    public function create()
    {
         $centerdetails = Center::all();
        return view('dashboard.incomeReport.index',compact('centerdetails'));
    }

public function index(Request $request)
{
    $centerdetails = Center::all();
    $incomeDetails = [];

    // Check if both fromDate and toDate are provided
    if ($request->filled('fromDate') && $request->filled('toDate')) {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');

        // Initialize the query
        $incomeDetailsQuery = Incomedetails::with(['incomeHead', 'centers'])
            ->whereBetween('date', [$fromDate, $toDate]);

        // Check if a specific center is selected and filter accordingly
        if ($request->filled('center') && $request->input('center') !== 'all') {
            $incomeDetailsQuery->where('center', $request->input('center'));
        }

        // Get the filtered income details
        $incomeDetails = $incomeDetailsQuery->get();
    }

    return view('dashboard.incomeReport.index', compact('incomeDetails', 'centerdetails'));
}


    
}
