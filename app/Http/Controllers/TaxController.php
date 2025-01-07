<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;


class TaxController extends Controller
{
    //
    public function index()
{
    // Retrieve all tax details
    $taxdetails = Tax::all();

    // Decode the JSON fields to arrays
    foreach ($taxdetails as $tax) {
        $tax->subtitle = json_decode($tax->subtitle, true);  // Decode subtitle to an array
        $tax->percentage = json_decode($tax->percentage, true);  // Decode percentage to an array
    }

    // Pass the data to the view
    return view('dashboard.tax.index', compact('taxdetails'));
}

    
    public function create(){
        return view('dashboard.tax.create');
    }

 public function store(Request $request)
    {
        // Validate the inputs
        $request->validate([
            'taxname' => 'nullable|string|max:255|unique:taxes,taxname', // Validate taxname
            'subtitle.*' => 'nullable|string|max:255', // Validate subtitles
            'percentage.*' => 'nullable|numeric|between:0,100', // Validate percentages
            'total' => 'nullable|numeric|between:0,100', // Validate total percentage
        ]);
    
        // Store all subtitles, percentages, and total as JSON
        Tax::create([
            'taxname' => $request->input('taxname'),  // Ensure taxname is stored
            'subtitle' => json_encode($request->input('subtitle')), // Encode subtitles as JSON
            'percentage' => json_encode($request->input('percentage')), // Encode percentages as JSON

            'total' => $request->input('total'), // Store the total percentage
        ]);
    
        return redirect('/admin/tax')->with('success', 'Tax details added successfully.');
    }
    
    

    
    public function destroy($id){
   
        Tax::destroy($id);

        // return redirect()->back(); 
        return response()->json(['message' => ' tax deleted successfully !'], 200);

    }
    
    public function edit($id)
{
    // Retrieve tax data
    $taxdata = Tax::find($id);

    // Ensure subtitle and percentage are arrays
    if (!is_array($taxdata->subtitle)) {
        $taxdata->subtitle = json_decode($taxdata->subtitle, true) ?? [];
    }
    if (!is_array($taxdata->percentage)) {
        $taxdata->percentage = json_decode($taxdata->percentage, true) ?? [];
    }

    // Pass the data to the view
    return view('dashboard.tax.edit', compact('taxdata'));
}

    
    
    public function update(Request $request, $id){
        
        $data = $request->except(['id','_token']);

        
        Tax::find($id)->update($data);
     
        // return redirect('/admin/tax');
        return response()->json(['message' => ' tax updated successfully !'], 200);

    }
}
