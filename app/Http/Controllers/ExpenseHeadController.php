<?php

namespace App\Http\Controllers;

use App\Models\ExpenseHead;
use Illuminate\Http\Request;

class ExpenseHeadController extends Controller
{
    public function index(){

        $expenseheadData = ExpenseHead::all();
        // dd($expenseheadData); 
        return view('dashboard.expensehead.index',
        compact('expenseheadData')
    );
    }
    
    public function create(){
        return view('dashboard.expensehead.create');
    }

    public function store(Request $request){
       

        $data = $request->except('_token');
        
        ExpenseHead::create($data);

        // return redirect()->back();
        return redirect('/admin/expensehead');
    }
    
    public function destroy($id){
   
        ExpenseHead::destroy($id);

        return redirect()->back(); 

    }
    
    public function edit($id){
   
        $expenseheadData = ExpenseHead::find($id);
    //  dd($expenseheadData);
        return view('dashboard.expensehead.edit',compact('expenseheadData'));
    }
    
    public function update(Request $request, $id){
        
        $data = $request->except(['id','_token']);

        
        ExpenseHead::find($id)->update($data);
     
        return redirect('/admin/expensehead');

    }
}
