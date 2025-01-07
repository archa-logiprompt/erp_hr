<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ClientDetails;



class ProjectController extends Controller
{
    //
    public function index()
    {
        $projectdetails = Project::with('clientDetails')->get();
        return view('dashboard.project.index', compact('projectdetails'));
    }
    
    
    public function create(){
        $clientdetail = ClientDetails::all();
        return view('dashboard.project.create',compact('clientdetail'));
    }
    // store

    public function store(Request $request){
        $request->validate([

            'projectname' => 'required|max:255',
            'startdate' => 'required|date',
            'deadline' => 'required|date|after_or_equal:startdate',
            'category' => 'required',
            'department' => 'required',
            'client' => 'required',
            'summary' => 'nullable|max:1000',
            'notes' => 'nullable|max:1000',
        ], [
           
            'projectname.required' => 'The Project Name field is required.',
            'startdate.required' => 'The Start Date field is required.',
            'deadline.required' => 'The Deadline field is required.',
            // 'client' => 'required|exists:clients,id',

            'deadline.after_or_equal' => 'Deadline must be after or equal to the Start Date.',
            'category.required' => 'Please select a Project Category.',
            'department.required' => 'Please select a Department.',
            'client.required' => 'Please select a Client.',
        ]);
        $data = $request->except('_token');
            Project::create($data);


        return redirect('/admin/project');
    }
    // delete
    
    public function destroy($id){
   
        Project::destroy($id);

        // return redirect()->back(); 
        return response()->json(['message' => 'project deleted successfully!'], 200);

    }
    // edit
    
   public function edit($id)
{
    // Fetch the project by ID
    $projectdata = Project::findOrFail($id); // Adjust "Project" to your actual model

    // Fetch the categories from the global config
    $categories = config('global.Category');
    $departments = config('global.Departments');
    $clients = ClientDetails::all();

    // Pass the project and categories to the view
    return view('dashboard.project.edit', compact('projectdata', 'categories','departments','clients'));
}

    //update
    public function update(Request $request, $id){
        $request->validate([
            
            'projectname' => 'required|max:255',
            'startdate' => 'required|date',
            'deadline' => 'required|date|after_or_equal:startdate',
            'category' => 'required',
            'projectfee' => 'required',

            'client' => 'required|exists:client_details,id',
            'department' => 'required',
            'summary' => 'required|max:1000',
            'notes' => 'nullable|max:1000',
        ], [
            
            'projectname.required' => 'Project Name is required.',
            'startdate.required' => 'Start Date is required.',
            'deadline.required' => 'Deadline is required.',
            'client.required' => 'Client is required.',

            'deadline.after_or_equal' => 'Deadline must be after or equal to the Start Date.',
            'category.required' => 'Project Category is required.',
            'department.required' => 'Department is required.',
            'summary.required' => 'Project Summary is required.',
            // 'notes.max' => 'Notes must not exceed 1000 characters.',
        ]);
        
   
        $data = $request->except(['id','_token']);

        
        Project::find($id)->update($data);
     
        // return redirect('/admin/project');
        return response()->json(['message' => 'Project updated successfully in web!'], 200);

    }
}
