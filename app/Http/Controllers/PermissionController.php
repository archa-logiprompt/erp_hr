<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $permissionData = PermissionGroup::with('permission')->get();
        return view('hr.permission.index', compact('permissionData'));
    }

    public function create()
    {
        $permissionGroup = PermissionGroup::all();
        return view('hr.permission.create', compact('permissionGroup'));
    }
    public function createGroup()
    {

        return view('hr.permission.creategroup');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'permission' => 'required',
            'short_code' => 'required',
        ]);

        $data = $request->except('_token');
        Permission::create($data);

        // return redirect()->back();
        return redirect('/admin/permission');
    }

    public function storeGroup(Request $request)
    {

        $validated = $request->validate([
            'permission_group' => 'required',
            'short_code' => 'required',
        ]);

        $data = $request->except('_token');
        Permission::create($data);

        return redirect('/admin/permission');
    }


    public function destroy($id)
    {

        Permission::destroy($id);

        return redirect()->back();
    }

    public function edit($id)
    {

        $permissionData = Permission::find($id);
        return view('hr.permission.edit', compact('permissionData'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'permission' => 'required',
        ]);
        $data = $request->except(['id', '_token']);

        Permission::find($id)->update($data);

        return redirect('/admin/permission');
    }
}
