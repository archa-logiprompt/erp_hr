<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
   public function index()
   {
    $designation=Designation::all();
    return view('hr.designation.index',compact('designation'));

   }
   public function create()
   {
    return view('hr.designation.create');
   }
   public function store(Request $request)
   {
    $validated = $request->validate([
        'name' => 'required',
    ], [
        'name.required' => 'The Designation Name field is required.',
    ]);
    
    $data = $request->except('_token');
    Designation::create($data);
    // return redirect()->back();
    return redirect('/admin/designation');
   }
}
