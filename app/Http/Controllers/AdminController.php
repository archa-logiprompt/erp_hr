<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\RolesAndPermission;
use App\Models\User_roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

    public function login()
    {

        if (Auth::user()) {
            return view('dashboard');
        }
        return view('dashboard.login.index');
    }

    public function authenticate(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();


            // Permission start
            $roles = User_roles::where('user_id', Auth::user()->id)->get();
            $permissions = array();
            $permission_type = ['', 'can_add', 'can_view', 'can_update', 'can_delete'];

            foreach ($roles as $role) {

                $permission = RolesAndPermission::with('permissionAssigned')->where('role_id', $role->role_id)->get();
                foreach ($permission as $per) {
                    if ($per->access_id == 2 || $per->access_id == 3) {
                        $code = $per['permissionAssigned']->short_code . '-' . $permission_type[$per->permission_type_id];
                        $permissions[] = $code;
                    }
                    if ($per->access_id == 3) {
                        $code = $per['permissionAssigned']->short_code . '-' . $permission_type[$per->permission_type_id] . '-owned';
                        $permissions[] = $code;
                    }
                }
            }
            Session::put('permissions', $permissions);
            // Permission end


            // return view('dashboard');
            return redirect('/');
        }
        return back();
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
