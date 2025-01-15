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
   public function destroy($id)
   {

       Designation::destroy($id);

       return redirect()->back();
   }
   public function edit($id)
   {
       $des= Designation::find($id);
       return view('hr.designation.edit', compact( 'des'));
   }
   public function update(Request $request, $id)
   {
       $validated = $request->validate([
           'name' => 'required',
       ]);
       $data = $request->except(['id', '_token']);

       Designation::find($id)->update($data);

       return redirect('/admin/designation');
   }

}
