<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralSettings;

class GeneralSettingsController extends Controller
{
    public function index(){

        $generalData = GeneralSettings::all(); 
        return view('dashboard.generalSettings.index',compact('generalData'));
    }

    public function create(){
        return view('dashboard.generalSettings.create');
    }

    public function store(Request $request){
        $request->validate([
             'prefix' => 'required|unique:general_settings',
             'startingNo' => 'nullable',
         ]);
 
         $data = $request->except('_token');
         
         GeneralSettings::create($data);
 
         // return redirect()->back();
         return redirect('/admin/generalsettings');
     }

    public function destroy($id){
   
        GeneralSettings::destroy($id);

        // return redirect()->back(); 
        return response()->json(['message' => ' General settings deleted successfully !'], 200);

    }
    
    public function edit($id){
   
        $generaldata = GeneralSettings::find($id);
     
        return view('dashboard.generalSettings.edit',compact('generaldata'));
    }

    public function update(Request $request, $id){
    

        $request->validate([
            'prefix' => 'required',
            'startingNo' => 'nullable',
        ]);
   
        $data = $request->except(['id','_token']);

        
        GeneralSettings::find($id)->update($data);
     
       
        return response()->json(['message' => 'generalsettings updated successfully in API (8080)!'], 200);

    }
}
