<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use App\Models\Center;
use Illuminate\Http\Request;
class ExpReportController extends Controller
// {
//     public function index(Request $request)
//     {
//         // Validate the request data
//         $request->validate([
//             'fromDate' => 'required|date|before_or_equal:toDate',
//             'toDate' => 'required|date|after_or_equal:fromDate',
//         ]);

//         $expenseDetails = []; // Initialize an empty array to avoid errors when dates are not provided.

//         // Check if both dates are provided and filter the data accordingly
//         if ($request->filled('fromDate') && $request->filled('toDate')) {
//             $fromDate = $request->input('fromDate');
//             $toDate = $request->input('toDate');

//             // Fetch expense details based on date range
//             $expenseDetails = Expenses::with(['expenseHead', 'center'])
//                 ->whereBetween('date', [$fromDate, $toDate])
//                 ->get();
//         }

//         // Return the view with the expense details
//         return view('dashboard.expReport.index', compact('expenseDetails'));
//     }

//     public function create(Request $request)
//     {
//                 return view('dashboard.expReport.index');

//     }
// }
{
public function create()
{
     $centerdetails = Center::all();
    return view('dashboard.expReport.index',compact('centerdetails'));
}

public function index(Request $request)
{
    // Initialize as an empty collection for safety
    $expdetails = collect(); 
    $centerdetails = Center::all(); // Fetch all centers for the dropdown

    // Check if both fromDate, toDate, and center are provided
    if ($request->filled('fromDate') && $request->filled('toDate') && $request->filled('center')) {
        $fromDate = $request->input('fromDate');
        $toDate = $request->input('toDate');
        $centerId = $request->input('center');

        // Filter expenses based on date range and center
        $expdetails = Expenses::with(['expenseHead', 'centers'])
            ->whereBetween('date', [$fromDate, $toDate])
            ->where('center', $centerId)  // Filtering by center ID
            ->get();
    }

    return view('dashboard.expReport.index', compact('expdetails', 'centerdetails'));
}


}