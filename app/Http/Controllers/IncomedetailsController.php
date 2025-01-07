<?php

namespace App\Http\Controllers;

use App\Models\Center;
use Illuminate\Http\Request;
use App\Models\Incomedetails;
use App\Models\IncomeHead;

class IncomedetailsController extends Controller
{
 public function index()
    {
        $incomeData = \App\Models\Incomedetails::with('centers', 'incomeHead')->get();
        // dd(json_encode($incomeData));
        return view('dashboard.incomedetails.index', compact('incomeData'));
    }
    




    public function create()
    {
        $incomeheadData = IncomeHead::all();

        $centerdetails = Center::all();

        return view('dashboard.incomedetails.create', compact('incomeheadData', 'centerdetails'));
    }

//     public function store(Request $request)
//     {
// dd($request);

//         $data = $request->except('_token');

//         Incomedetails::create($data);

//         // return redirect()->back();
//         return redirect('/admin/incomedetails');
//     }

public function store(Request $request)
{
    // dd($request);
    // Validate the input
    $request->validate([
        'center' => 'required|exists:center,id', // Ensure center exists in the database
        'head' => 'required',
        'date' => 'required|date',
        'name' => 'required|string',
        'amount' => 'required|numeric',
        'method' => 'required|string',
    ]);

    // Save the data
    $data = $request->except('_token');
    
    // dd($data);
    Incomedetails::create($data);

    // Redirect to the list view
    return redirect('/admin/incomedetails')->with('success', 'Income detail added successfully!');
}


    public function destroy($id)
    {

        Incomedetails::destroy($id);

        return redirect()->back();
    }

    public function edit($id)
    {
        $incomeheadData = IncomeHead::all();

        $centerdetails = Center::all();
        $incomeData = Incomedetails::find($id);
        return view('dashboard.incomedetails.edit', compact('incomeData', 'incomeheadData', 'centerdetails'));
    }

    public function update(Request $request, $id)
    {

        $data = $request->except(['id', '_token']);


        Incomedetails::find($id)->update($data);

        return redirect('/admin/incomedetails');
    }
}
