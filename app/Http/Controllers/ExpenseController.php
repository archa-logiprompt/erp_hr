<?php

namespace App\Http\Controllers;

use App\Models\Center;
use Illuminate\Http\Request;
use App\Models\Expenses;
use App\Models\ExpenseHead;

class ExpenseController extends Controller
{
    public function index()
{
    $expensedetails = Expenses::with('expenseHead','centers')->get(); // Include related data
    $headdetails = ExpenseHead::all();
    $centerdetails=Center::all();

    return view('dashboard.expense.index', compact('expensedetails', 'headdetails','centerdetails'));
}

    
public function create()
{
    $headdetails = ExpenseHead::all(); // Fetch the expense heads
    $centerdetails=Center::all();

    return view('dashboard.expense.create', compact('headdetails','centerdetails'));
}

public function store(Request $request)
{
    // Validate the request
    $request->validate([
        'head' => 'required|exists:expensehead,id', // Make sure the table name matches your database
        'date' => 'required|date',
        'center' => 'required|exists:center,id', // Make sure the table name matches your database

        'name' => 'required|string|max:255',
        'amount' => 'required|numeric|min:0',
        'invoiceno' => 'nullable|string|unique:expenses,invoiceno',
        'document' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:2048', // Optional file validation
        'description' => 'nullable|string',
    ]);

    // Handle file upload if provided
    $documentPath = null;
    if ($request->hasFile('document')) {
        $document = $request->file('document');
        $documentPath = $document->store('documents', 'public'); // Save in 'public/documents'
    }

    // Prepare data for insertion
    $data = $request->except('_token', 'document'); // Exclude '_token' and 'document'
    $data['document'] = $documentPath; // Add the file path if uploaded
    $data['center'] = $request->input('center');
    // Save the expense
    Expenses::create($data);

    // Redirect with success message
    return redirect('/admin/expense')->with('success', 'Expense added successfully.');
}

    
public function destroy($id)
{
    $expense = Expenses::findOrFail($id); // Find the expense by ID
    $expense->delete(); // Delete the expense record
    
    // Return a response, either redirect or JSON response
    return redirect()->route('admin.expense.index')->with('success', 'Expense deleted successfully!');
}

    
public function edit($id)
{
    $expensedata = Expenses::find($id);
    $headdetails = ExpenseHead::all();
    $centerdetails = Center::all();
    // dd($expensedata);

    // Ensure $expensedata contains the center_id field, and pass it to the view
    return view('dashboard.expense.edit', compact('expensedata', 'headdetails', 'centerdetails'));
}

    
    public function update(Request $request, $id){
        
        $data = $request->except(['id','_token']);

        
        Expenses::find($id)->update($data);
     
        return redirect('/admin/expense');


    }
}
