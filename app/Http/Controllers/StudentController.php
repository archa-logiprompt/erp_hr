<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\StudentInstallment;


class StudentController extends Controller
{
    //
    public function index()
    {
        $studentdetails = Student::with('course')->get();
        return view('dashboard.students.index', compact('studentdetails'));
    }

    public function create($id = null)
    {
        $courses = Course::all();
        $studentdata = $id ? Student::find($id) : new Student();

        // Check for old input (after validation errors)
        $selectedCourse = null;
        if (old('course_id')) {
            $selectedCourse = Course::find(old('course_id')); // Find the course selected previously
        } elseif ($id && $studentdata->course_id) {
            // If editing a student, set the selected course
            $selectedCourse = Course::find($studentdata->course_id);
        }

        return view('dashboard.students.create', compact('courses', 'studentdata', 'selectedCourse'));
    }





    public function store(Request $request)
    {
        // dd($request);
        $imagePath = null;
        $logoPath = null;

        // Validation rules
        $request->validate([
            'salutation' => 'nullable',
            'studentname' => 'required|string|max:255',
            'frequency' => 'nullable|integer|min:1|max:24',
            'email' => 'required|email|unique:students,email|regex:/^[^.-][A-Za-z0-9._%+-]*@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}$/',
'admissionnumber' => 'required|integer|unique:students,admissionnumber',
            
           'course_id' => 'required|exists:courses,id',

            'fees' => 'required|numeric',

           
            'flexRadioDefault' => 'required|in:male,female,other',  // Gender validation
            'stedadmissionnumber' => 'unique:students|nullable|integer',
            'admissiondate' => 'required|date',
            'mobile' => 'required|digits:10|unique:students,mobile',
            'additionalcontactno' => 'nullable|digits:10|unique:students,additionalcontactno',
            'gstno' => 'nullable|unique:students,gstno|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[A-Z0-9]{1}[Z]{1}[A-Z0-9]{1}$/|unique:students,gstno,' ,

            'aadhar' => 'required|digits:12|unique:students,aadhar',
            'address' => 'nullable|string|max:255',
            'file' => 'mimes:pdf,doc,docx,jpg,png|max:2048',
            'image' => 'image|mimes:jpg,png,jpeg,gif|max:2048',
        ], [
            // Custom messages
            'course_id.required' => 'Please select a course.',
            'courcourse_idse.exists' => 'The selected course is invalid.',
            'mobile.required' => 'Mobile number is required.',
            'mobile.digits' => 'Mobile number must be 10 digits.',
            'mobile.unique' => 'This mobile number is already in use.',
            'admissionnumber.unique' => 'This admissionnumber is already in use.',
            'stedadmissionnumber.unique' => 'This stedadmissionnumber is already in use.',
'email.unique' => 'This email is already in use.',
            'additionalcontactno.required' => 'Additional contact number is required.',
            'additionalcontactno.digits' => 'Additional contact number must be 10 digits.',
            'additionalcontactno.unique' => 'This additional contact number is already in use.',

            // 'gstno.required' => 'GST number is required.',
            'gstno.unique' => 'This GST number is already in use.',

            'aadhar.required' => 'Aadhar number is required.',
            'aadhar.digits' => 'Aadhar number must be 12 digits.',
            'aadhar.unique' => 'This Aadhar number is already in use.',

            'address.string' => 'Address must be a valid string.',
            'address.max' => 'Address cannot exceed 255 characters.',

            
            'file.mimes' => 'Only PDF, DOC, DOCX, JPG, PNG files are allowed.',
            'file.max' => 'File size cannot exceed 2MB.',

           
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'Only JPG, PNG, JPEG, and GIF images are allowed.',
            'image.max' => 'Image size cannot exceed 2MB.',
            'fees.required' => 'Fees are required.',
            'fees.numeric' => 'Fees must be a valid number.',
            'admissionnumber.required' => 'Admission number is required.',
            'admissionnumber.integer' => 'Admission number must be a valid number.',
            'admissionnumber.unique' => 'This admissionnumber  is already in use.',

            'stedadmissionnumber.required' => 'STED admission number is required.',
            'stedadmissionnumber.integer' => 'STED admission number must be a valid number.',

            'flexRadioDefault.required' => 'Please select your gender.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.regex' => 'Invalid email format. Email should not begin with a full stop or hyphen and must contain "@" symbol.',
        ]);

        // Handle image file upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = 'image/' . time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imagePath);
        }

        // Handle document file upload
        if ($request->hasFile('file')) {
            $logo = $request->file('file');
            $logoPath = 'file/' . time() . '_' . $logo->getClientOriginalName();
            $logo->move(public_path('file'), $logoPath);
        }

        // Store the data
        $data = $request->except('_token');
        $data['image'] = $imagePath;
        $data['file'] = $logoPath;

        $created_student = Student::create($data);
        
        $frequency = $request->frequency;
        $fees = $request->fees;
        $fees_split = $fees / $frequency;


        $installment_arr = [];


        $admissiondate = $request->admissiondate;



        for ($i = 0; $i < $frequency; $i++) {
            $installment_arr[$i]['student_id'] =  $created_student->id;
            $installment_arr[$i]['amount'] =  $fees_split;

            if ($i == 0) {

                $fromdate = date('d-m-Y', strtotime($admissiondate));
            } else {
                $time = strtotime($admissiondate);

                $fromdate = date('d-m-Y', strtotime("+$i month", $time));
            }

            $installment_arr[$i]['date_from'] =  date('Y-m-d', strtotime($fromdate));
            $installment_arr[$i]['date_to'] =  date('Y-m-d', strtotime("+1 month", strtotime($fromdate)));
            $installment_arr[$i]['installment_no'] =  $i + 1;
        }

        StudentInstallment::insert($installment_arr);

        // return response()->json(['message' => 'Student added successfully in the api database!'], 200);

        return redirect('/admin/students');
    }


    public function destroy($id)
    {

        Student::destroy($id);

        // return redirect()->back();
        return response()->json(['message' => 'student deleted successfully!'], 200);
    }

    public function edit($id)
    {
        // Fetch the student record by ID
        $studentdata = Student::find($id);

        // Fetch the list of courses dynamically from the database
        $courses = Course::all();

        // Pass both student data and courses to the view
        return view('dashboard.students.edit', compact('studentdata', 'courses'));
    }


    public function update(Request $request, $id)
    {
        // Retrieve the student record
        $student = Student::findOrFail($id);

        // Validation rules
        $request->validate([
    'salutation' => 'nullable',
    'studentname' => 'required|string|max:255',
    'frequency' => 'nullable|integer|min:1|max:24',
    
    'email' => 'required|email|regex:/^[^.-][A-Za-z0-9._%+-]*@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}$/|unique:students,email,' . $id,
    
    'fees' => 'required|numeric',
    'admissionnumber' => 'required|integer|unique:students,admissionnumber,' . $id,
    'stedadmissionnumber' => 'nullable|integer|unique:students,stedadmissionnumber,' . $id,
    'admissiondate' => 'required|date',
    'mobile' => 'required|digits:10|unique:students,mobile,' . $id,
    'additionalcontactno' => 'nullable|digits:10|unique:students,additionalcontactno,' . $id,
    
    'gstno' => 'nullable|regex:/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[A-Z0-9]{1}[Z]{1}[A-Z0-9]{1}$/|unique:students,gstno,' . $id,
    
    'aadhar' => 'required|digits:12|unique:students,aadhar,' . $id,
    'address' => 'nullable|string|max:255',
    'file' => 'nullable|mimes:pdf,doc,docx,jpg,png|max:2048',
    'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
], [
    'studentname.required' => 'Student name is required.',
    'email.required' => 'Email is required.',
    'email.email' => 'Invalid email format.',
    'mobile.required' => 'Mobile number is required.',
    'mobile.digits' => 'Mobile number must be exactly 10 digits.',
    'mobile.unique' => 'This mobile number is already taken.',
    'admissionnumber.required' => 'Admission number is required.',
    'admissionnumber.unique' => 'This admission number is already in use.',
    'aadhar.required' => 'Aadhar number is required.',
    'aadhar.unique' => 'This Aadhar number is already in use.',
    'file.mimes' => 'Only PDF, DOC, DOCX, JPG, and PNG files are allowed.',
    'image.mimes' => 'Only JPG, PNG, JPEG, and GIF images are allowed.',
    'image.max' => 'Image size must not exceed 2MB.',
]
);

        // Initialize data to update
        $data = $request->except(['_token']);

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if (!empty($student->image) && file_exists(public_path($student->image))) {
                unlink(public_path($student->image));
            }

            // Upload the new image
            $image = $request->file('image');
            $imagePath = 'image/' . time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('image'), $imagePath);
            $data['image'] = $imagePath;
        }

        // Handle the file upload if a new file is uploaded
        if ($request->hasFile('file')) {
            // Delete the old file if it exists
            if (!empty($student->file) && file_exists(public_path($student->file))) {
                unlink(public_path($student->file));
            }

            // Upload the new file
            $file = $request->file('file');
            $filePath = 'file/' . time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('file'), $filePath);
            $data['file'] = $filePath;
        }

        // Update the student record
        $student->update($data);
        
        StudentInstallment::where(['student_id'=>$id])->delete();


        $frequency = $request->frequency;
        $fees = $request->fees;
        $fees_split = $fees / $frequency;


        $installment_arr = [];


        $admissiondate = $request->admissiondate;



        for ($i = 0; $i < $frequency; $i++) {
            $installment_arr[$i]['student_id'] =  $id;
            $installment_arr[$i]['amount'] =  $fees_split;

            if ($i == 0) {

                $fromdate = date('d-m-Y', strtotime($admissiondate));
            } else {
                $time = strtotime($admissiondate);

                $fromdate = date('d-m-Y', strtotime("+$i month", $time));
            }

            $installment_arr[$i]['date_from'] =  date('Y-m-d', strtotime($fromdate));
            $installment_arr[$i]['date_to'] =  date('Y-m-d', strtotime("+1 month", strtotime($fromdate)));
            $installment_arr[$i]['installment_no'] =  $i + 1;
        }

        StudentInstallment::insert($installment_arr);

        return response()->json(['message' => 'Student data updated successfully!'], 200);
        // return redirect('/admin/students')->with('success', 'Student details updated successfully!');
    }
}
