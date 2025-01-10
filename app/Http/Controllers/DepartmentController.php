<?php

namespace App\Http\Controllers;

use App\Models\department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $department = department::all();

        return view('hr.department.index', compact('department'));
    }
    public function create()
    {
        return view('hr.department.create');
    }
    public function store(Request $request)
    {

        $validated = $request->validate([
            'dep_name' => 'required',
        ], [
            'dep_name.required' => 'The Department Name field is required.',
        ]);
        
        $data = $request->except('_token');
        department::create($data);
        // return redirect()->back();
        return redirect('/admin/department');
    }

    public function destroy($id)
    {

        department::destroy($id);

        return redirect()->back();
    }

}
