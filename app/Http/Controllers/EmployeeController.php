<?php

namespace App\Http\Controllers;
use App\Models\department;
use App\Models\Designation;
use App\Models\Role;
use App\Models\User_roles;
use Nakanakaii\Countries\Countries;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


use App\Models\Employees;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employees::with(['user', 'department', 'designation'])->get();
        return view('hr.employee.index', compact('employees'));
    }
    
  public function create()
  {
    $countries = Countries::all();
    $department = department::all();
    $designation=Designation::all();
    $role=Role::all();

    return view('hr.employee.create',compact('countries','department','designation','role'));
  }
  public function store(Request $request)
  {
     
    $request->validate([
        'empid' => 'required|unique:employees,empid',
        // 'gender' => 'required|in:male,female,other',
        // 'name' => 'required|string|max:255',
        // 'email' => 'required|email|unique:users,email',
        // 'mobile' => 'required|digits:10|unique:employees,mobile',
        // 'password' => 'required|min:8',
        // 'adhaar' => 'required|digits:12|unique:employees,adhaar',
    ], [
        // Custom error messages
        // 'empid.required' => 'Employee ID is required.',
        // 'empid.unique' => 'This Employee ID is already taken.',
        // 'gender.required' => 'Gender is required.',
        // 'gender.in' => 'Gender must be Male, Female, or Other.',
        // 'name.required' => 'Name is required.',
        // 'name.max' => 'Name cannot exceed 255 characters.',
        // 'email.required' => 'Email address is required.',
        // 'email.email' => 'The email address must be a valid format.',
        // 'email.unique' => 'This email address is already in use.',
        // 'mobile.required' => 'Mobile number is required.',
        // 'mobile.digits' => 'Mobile number must be exactly 10 digits.',
        // 'mobile.unique' => 'This mobile number is already taken.',
        // 'password.required' => 'Password is required.',
        // 'password.min' => 'Password must be at least 8 characters long.',
        // 'adhaar.required' => 'Aadhaar number is required.',
        // 'adhaar.digits' => 'Aadhaar number must be exactly 12 digits.',
        // 'adhaar.unique' => 'This Aadhaar number is already in use.',
    ]);

    
      $userId = User::insertGetId([
          'name' => $request->name,
          'email' => $request->email,
          'password' => Hash::make($request->password),
          'role' => 'user',
      ]);
  
      // Initialize filePaths array
      $filePaths = [
          'ProfilePicture' => null,
          'copy_adhaar' => null,
          'pg' => null,
          'ug' => null,
          'twelth' => null,
          'tenth' => null,
      ];
  
      // Handle file uploads for each file
      if ($request->hasFile('ProfilePicture')) {
          $image = $request->file('ProfilePicture');
          $imagePath = 'ProfilePicture/' . time() . '_' . $image->getClientOriginalName();
          $image->move(public_path('ProfilePicture'), $imagePath);
          $filePaths['ProfilePicture'] = $imagePath;  // Store the path in the filePaths array
      }
  
      if ($request->hasFile('copy_adhaar')) {
          $image = $request->file('copy_adhaar');
          $imagePath = 'copy_adhaar/' . time() . '_' . $image->getClientOriginalName();
          $image->move(public_path('copy_adhaar'), $imagePath);
          $filePaths['copy_adhaar'] = $imagePath;  // Store the path in the filePaths array
      }
  
      if ($request->hasFile('pg')) {
          $image = $request->file('pg');
          $imagePath = 'pg/' . time() . '_' . $image->getClientOriginalName();
          $image->move(public_path('pg'), $imagePath);
          $filePaths['pg'] = $imagePath;  // Store the path in the filePaths array
      }
  
      if ($request->hasFile('ug')) {
          $image = $request->file('ug');
          $imagePath = 'ug/' . time() . '_' . $image->getClientOriginalName();
          $image->move(public_path('ug'), $imagePath);
          $filePaths['ug'] = $imagePath;  // Store the path in the filePaths array
      }
  
      if ($request->hasFile('twelth')) {
          $image = $request->file('twelth');
          $imagePath = 'twelth/' . time() . '_' . $image->getClientOriginalName();
          $image->move(public_path('twelth'), $imagePath);
          $filePaths['twelth'] = $imagePath;  // Store the path in the filePaths array
      }
  
      if ($request->hasFile('tenth')) {
          $image = $request->file('tenth');
          $imagePath = 'tenth/' . time() . '_' . $image->getClientOriginalName();
          $image->move(public_path('tenth'), $imagePath);
          $filePaths['tenth'] = $imagePath;  // Store the path in the filePaths array
      }
  
      // Insert employee details
      Employees::create([
          'user_id' => $userId,
          'empid' => $request->empid,
          'country' => $request->country,
          'mobile' => $request->mobile,
          'gender' => $request->gender,
          'ProfilePicture' => $filePaths['ProfilePicture'],
          'joining_date' => $request->joining_date,
          'dob' => $request->dob,
          'dep_name' => $request->dep_name,
          'designation_id' => $request->designation_id,
          'loginYes' => $request->loginYes,
          'recievemailyes' => $request->recievemailyes,
          'hourlyrateyes' => $request->hourlyrateyes,
          'acc_name' => $request->acc_name,
          'account_no' => $request->account_no,
          'bank_name' => $request->bank_name,
          'ifsc' => $request->ifsc,
          'adhaar' => $request->adhaar,
          'branch_name' => $request->branch_name,
          'pg' => $filePaths['pg'],
          'ug' => $filePaths['ug'],
          'twelth' => $filePaths['twelth'],
          'tenth' => $filePaths['tenth'],
          'copy_adhaar' => $filePaths['copy_adhaar'],
          'employee_type' => $request->employee_type,
          'status' => 1
      ]);
  
      // Insert user roles
      if ($request->has('role')) {
          foreach ($request->role as $role) {
              User_roles::create([
                  'user_id' => $userId,
                  'role_id' => $role,
              ]);
          }
      }
      return redirect()->route('role.employee.index')->with('success', 'User and employee details saved successfully!');

      // Redirect back with success message
    //   return redirect()->back()->with('success', 'User and employee details saved successfully!');
  }
  
  public function destroy($id)
{
    $employee = Employees::findOrFail($id); 
    $employee->status = 0; 
    $employee->save(); 

    return redirect()->back()->with('success', 'Employee status updated successfully.');
}

    public function edit($id)
    {
        
        $employees = Employees::with('user')->findOrFail($id);
        $countries = Countries::all();
        $department = department::all();
        $designation=Designation::all();
        $role=Role::all();
        

        return view('hr.employee.edit', compact( 'employees','countries','department','designation','role'));
    }

    public function update(Request $request, $id)
    {
        
        $employee = Employees::findOrFail($id);
        $user = $employee->user;
    
        
        $request->validate([
            'empid'=>'required',
            'gender'=>'required',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,    
            'mobile' => 'required|string|max:15',
            'password' => 'required|nullable|min:8', 
            'adhaar' => 'required|nullable|max:12', 

            
        ],[
            'empid.required' => 'Employee Id is required.',
            'gender.required' => 'Employee Gender is required.',
            'name.required' => 'Employee Name is required.',
            'email.required' => 'Employee Email Id is required.',
            'mobile.required' => 'Mobile No is required.',

        ]);
    
        // Update user details
        $user->name = $request->input('name');
        $user->email = $request->input('email');
    
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        $user->save();
    
        $employee->empid = $request->input('empid');
        $employee->mobile = $request->input('mobile');
        $employee->country = $request->input('country');
        $employee->gender = $request->input('gender');
        $employee->dob = $request->input('dob');
        $employee->dep_name = $request->input('dep_name');
        $employee->designation_id = $request->input('designation_id');
        $employee->joining_date = $request->input('joining_date');
        $employee->employee_type = $request->input('employee_type');
        $employee->adhaar = $request->input('adhaar');
        $employee->loginYes = $request->input('loginYes');
        $employee->recievemailyes = $request->input('recievemailyes');
        $employee->hourlyrateyes = $request->input('hourlyrateyes');
        $employee->acc_name = $request->input('acc_name');
        $employee->account_no = $request->input('account_no');
        $employee->bank_name = $request->input('bank_name');
        $employee->ifsc = $request->input('ifsc');
        $employee->branch_name = $request->input('branch_name');
        $employee->status = 1;
    
        // Handle file uploads and update file paths in the employee table
        if ($request->hasFile('ProfilePicture')) {
            if (!empty($employee->ProfilePicture) && file_exists(public_path($employee->ProfilePicture))) {
                unlink(public_path($employee->ProfilePicture));
            }
    
            $image = $request->file('ProfilePicture');
            $imagePath = 'ProfilePicture/' . time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('ProfilePicture'), $imagePath);
            $employee->ProfilePicture = $imagePath;
        }
    
        if ($request->hasFile('pg')) {
            if (!empty($employee->pg) && file_exists(public_path($employee->pg))) {
                unlink(public_path($employee->pg));
            }
    
            $file = $request->file('pg');
            $filePath = 'pg/' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('pg'), $filePath);
            $employee->pg = $filePath;
        }
    
       
        if ($request->hasFile('ug')) {
            if (!empty($employee->ug) && file_exists(public_path($employee->ug))) {
                unlink(public_path($employee->ug));
            }
    
            $file = $request->file('ug');
            $filePath = 'ug/' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('ug'), $filePath);
            $employee->ug = $filePath; 
        }


        if ($request->hasFile('tenth')) {
            if (!empty($employee->tenth) && file_exists(public_path($employee->tenth))) {
                unlink(public_path($employee->tenth));
            }
    
            $file = $request->file('tenth');
            $filePath = 'tenth/' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('tenth'), $filePath);
            $employee->tenth = $filePath; 
        }

        
        if ($request->hasFile('twelth')) {
            if (!empty($employee->twelth) && file_exists(public_path($employee->twelth))) {
                unlink(public_path($employee->twelth));
            }
    
            $file = $request->file('twelth');
            $filePath = 'twelth/' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('twelth'), $filePath);
            $employee->twelth = $filePath; 
        }


        if ($request->hasFile('copy_adhaar')) {
            if (!empty($employee->copy_adhaar) && file_exists(public_path($employee->copy_adhaar))) {
                unlink(public_path($employee->copy_adhaar));
            }
    
            $file = $request->file('copy_adhaar');
            $filePath = 'copy_adhaar/' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('copy_adhaar'), $filePath);
            $employee->copy_adhaar = $filePath; 
        }
    
        $employee->save();
    
        return redirect()->route('role.employee.index')->with('success', 'Employee updated successfully.');
    }
    

}
