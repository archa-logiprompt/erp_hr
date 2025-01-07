<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Center;
use App\Models\Expenses;
use App\Models\ExpenseHead;

class ExpensereportController extends Controller
{
    public function create()
    {
        return view('dashboard.expenseReport.index');
    }

    public function index(Request $request)
    {
        $expenseDetails = collect(); // Empty collection by default

        // Validate the input dates
        $request->validate([
            'fromDate' => 'required|date|before_or_equal:toDate',
            'toDate' => 'required|date|after_or_equal:fromDate',
        ]);

        if ($request->filled('fromDate') && $request->filled('toDate')) {
            $fromDate = $request->input('fromDate');
            $toDate = $request->input('toDate');

            // Query the database with the date range
            $expenseDetails = Expenses::with(['expenseHead', 'center'])
                ->whereBetween('date', [$fromDate, $toDate])
                ->get();
        }

        return view('dashboard.expenseReport.index', compact('expenseDetails'));
    }
}
