<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    //
    public function index(){

        $coursedetails = Course::all(); 
        return view('dashboard.courses.index',compact('coursedetails'));
    }
    
    public function create(){
        return view('dashboard.courses.create');
    }

    public function store(Request $request){
       $request->validate([
            'coursename' => 'required|unique:courses',
            'fee' => 'required',
            'duration' => 'required',
        ]);

        $data = $request->except('_token');
        
        Course::create($data);

        // return redirect()->back();
        return redirect('/admin/courses');
    }
    
    public function destroy($id){
   
        Course::destroy($id);

        // return redirect()->back(); 
        return response()->json(['message' => 'Course deleted successfully (8000)!'], 200);

    }
    
    public function edit($id){
   
        $coursedata = Course::find($id);
     
        return view('dashboard.courses.edit',compact('coursedata'));
    }
    
    // public function update(Request $request, $id){
    //     $request->validate([
    //         'coursename' => 'nullable',
    //         'fee' => 'required',
    //         'duration' => 'required',
    //     ]);
   
    //     $data = $request->except(['id','_token']);

        
    //     Course::find($id)->update($data);
     
    //     return redirect('/admin/courses');
    // }

    public function update(Request $request, $id) {
        $request->validate([
            'coursename' => 'required|unique:courses,coursename,' . $id,
            'fee' => 'required|numeric', 
            'duration' => 'required', 
        ]);
    
        $course = Course::find($id);
    
        if (!$course) {
            return response()->json(['error' => 'Course not found.'], 404);
        }
    
        $course->update($request->except(['id', '_token']));
        return response()->json(['message' => 'Course updated successfully !'], 200);
    }
    
}
