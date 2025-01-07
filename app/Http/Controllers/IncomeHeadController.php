<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IncomeHead;

class IncomeHeadController extends Controller
{
    public function index(){

        $incomeheadData = IncomeHead::all();
        // dd($incomeheadData); 
        return view('dashboard.incomehead.index',
        compact('incomeheadData')
    );
    }
    
    public function create(){
        return view('dashboard.incomehead.create');
    }

    public function store(Request $request){
       

        $data = $request->except('_token');
        
        IncomeHead::create($data);

        // return redirect()->back();
        return redirect('/admin/incomehead');
    }
    
    public function destroy($id){
   
        IncomeHead::destroy($id);

        return redirect()->back(); 

    }
    
    public function edit($id){
   
        $incomeheadData = IncomeHead::find($id);
    //  dd($incomeheadData);
        return view('dashboard.incomehead.edit',compact('incomeheadData'));
    }
    
    public function update(Request $request, $id){
        
        $data = $request->except(['id','_token']);

        
        IncomeHead::find($id)->update($data);
     
        return redirect('/admin/incomehead');

    }
}
