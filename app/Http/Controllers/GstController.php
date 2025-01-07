<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gst;


class GstController extends Controller
{
    //
    public function index(){

        $gstdetails = Gst::all(); 
        return view('dashboard.gst.index',compact('gstdetails'));
    }
    
    public function create(){
        return view('dashboard.gst.create');
    }

    public function store(Request $request){
       

        $data = $request->except('_token');
        
        Gst::create($data);

        // return redirect()->back();
        return redirect('/admin/gst');
    }
    
    public function destroy($id){
   
        Gst::destroy($id);

        // return redirect()->back(); 
        return response()->json(['message' => ' Gst deleted successfully !'], 200);

    }
    
    public function edit($id){
   
        $gstdata = Gst::find($id);
     
        return view('dashboard.gst.edit',compact('gstdata'));
    }
    
    public function update(Request $request, $id){
        
        $data = $request->except(['id','_token']);

        
        Gst::find($id)->update($data);
     
        // return redirect('/admin/gst');
        return response()->json(['message' => 'Gst updated successfully in API (8080)!'], 200);

    }
}
