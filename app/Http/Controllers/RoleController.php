<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roleData = Role::all();
        return view('hr.role.index', compact('roleData'));
    }

    public function create()
    {
        return view('hr.role.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'role' => 'required',
        ]);

        $data = $request->except('_token');
        Role::create($data);

        // return redirect()->back();
        return redirect('/admin/role');
    }
    public function destroy($id)
    {

        Role::destroy($id);

        return redirect()->back();
    }

    public function edit($id)
    {

        $roleData = Role::find($id);
        return view('hr.role.edit', compact('roleData'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'role' => 'required',
        ]);
        $data = $request->except(['id', '_token']);

        Role::find($id)->update($data);

        return redirect('/admin/role');
    }
}
