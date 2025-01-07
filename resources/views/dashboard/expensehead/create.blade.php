@extends('layouts.dashboard.app')
@section('content')
<div class="page-body">
    <div class="col-xl-12">
        <div class="card height-equal">
            <div class="card-header">
                <h4>Expense head</h4>
               
            </div>
            <div class="card-body">
                <form class=""  method="POST" action="{{route('admin.expensehead.store')}}" novalidate="">
                    @csrf
                    <div class="col-6">
                            <label class="form-label" for="validationCustom01">Name</label>
                            <input class="form-control" id="validationCustom01" type="text" 
                                name='head' required="">
                            @if ($errors->has('head'))
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first('head') }}
                            </div>
                            @endif
                        </div>

                    <div class="col-12 mt-5">
                        <button class="btn btn-primary" type="submit" >Submit form</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection