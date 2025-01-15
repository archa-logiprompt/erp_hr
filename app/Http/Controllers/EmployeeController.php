<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
  public function index()
  {
    // $employee=Employees::all();
    return view('hr.employee.index');
  }
  public function create()
  {
    return view('hr.employee.create');
  }
}
