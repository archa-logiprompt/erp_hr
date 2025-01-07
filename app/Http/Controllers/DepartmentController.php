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
}
