<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fee;
use App\Models\Tax;

function array_flatten($array)
{
    $flatArray = [];
    array_walk_recursive($array, function ($value) use (&$flatArray) {
        $flatArray[] = $value;
    });
    return $flatArray;
}

class FeeController extends Controller
{
    //
    public function index()
{
    // Retrieve all fee details
    $feedetails = Fee::all();
    $taxdetails = Tax::all(); // Retrieve all taxes for the select box in the create page

    foreach ($feedetails as $fee) {
        // Decode subtitle and splitup fields only if they are strings
        $fee->subtitle = is_string($fee->subtitle) ? json_decode($fee->subtitle, true) : $fee->subtitle;
        $fee->splitup = is_string($fee->splitup) ? json_decode($fee->splitup, true) : $fee->splitup;

        // Decode taxes field only if it is a string
        if (is_string($fee->taxes)) {
            $fee->taxes = json_decode($fee->taxes, true);
        }

        // Flatten the nested taxes array (e.g., [["2", "3"], ["3", "4"]] becomes [2, 3, 3, 4])
        $fee->taxes = array_flatten($fee->taxes);

        // Retrieve tax names from the database using the flattened array of tax IDs
        $fee->taxes = Tax::whereIn('id', $fee->taxes)->pluck('taxname')->toArray();
    }

    // Pass data to the view
    return view('dashboard.fee.index', compact('feedetails', 'taxdetails'));
}

    
    
    public function create()
    {
        // Retrieve all available taxes
        $taxes = Tax::all();

        // Pass taxes to the view
        return view('dashboard.fee.create', compact('taxes'));
    }

    public function store(Request $request)
{
    // Validate the inputs
    // dd($request);
    $request->validate([
        'title' => 'required|string|max:255|unique:fees,title',
        'subtitle' => 'required|array',
        'subtitle.*' => 'nullable|string|max:255',
        'splitup' => 'required|array',
        'splitup.*' => 'nullable|numeric|between:0,100',
        'taxes' => 'required|array',
        'taxes.*' => 'nullable|array',
        'taxes.*.*' => 'nullable|integer|exists:taxes,id',
    ]);

    // Prepare dynamic fields for saving
    $subtitles = $request->input('subtitle', []);
    $splitups = $request->input('splitup', []);
    $taxesArray = $request->input('taxes', []);

    // Save data to the database
    Fee::create([
        'title' => $request->input('title'),
        'subtitle' => json_encode($subtitles),
        'splitup' => json_encode($splitups),
        'taxes' => json_encode($taxesArray),
    ]);

    // Redirect with success message
    return redirect()->route('admin.fee.index')->with('success', 'Fee details added successfully.');
}

    
    public function destroy($id)
    {
        try {
            $fee = Fee::findOrFail($id); // Find the record or throw a 404
            $fee->delete(); // Delete the record
            // return redirect()->back()->with('success', 'Fee deleted successfully.');
            return response()->json(['message' => 'fee deleted successfully!'], 200);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting Fee: ' . $e->getMessage());
        }
    }
    
    
    public function edit($id)
{
    // Retrieve fee data
    $feedata = Fee::find($id);

    if (!$feedata) {
        return redirect()->route('admin.fee.index')->with('error', 'Fee record not found.');
    }

    // Decode JSON fields into arrays
    $feedata->subtitle = json_decode($feedata->subtitle, true) ?? [];
    $feedata->splitup = json_decode($feedata->splitup, true) ?? [];
    $feedata->taxes = array_map(function ($taxes) {
        return is_string($taxes) ? json_decode($taxes, true) : $taxes;
    }, json_decode($feedata->taxes, true) ?? []);

    // Retrieve all available taxes
    $taxes = Tax::all();

    return view('dashboard.fee.edit', compact('feedata', 'taxes'));
}

    


    
    
public function update(Request $request, $id)
{
    $data = $request->except(['id', '_token']);

    // Handle subtitle and splitup as arrays
    if (isset($data['subtitle'])) {
        $data['subtitle'] = json_encode($data['subtitle']);
    }

    if (isset($data['splitup'])) {
        $data['splitup'] = json_encode($data['splitup']);
    }

    // Handle taxes as a nested array
    if (isset($data['taxes'])) {
        $data['taxes'] = json_encode($data['taxes']);
    }

    // Find the fee by ID and update it
    $fee = Fee::find($id);

    if ($fee) {
        $fee->update($data);
    }

    // return redirect('/admin/fee');
    return response()->json(['message' => 'Course updated successfully !'], 200);

}

}
