@extends('layouts.dashboard.app')
@section('content')
 
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Income head update</h4>
                  
                </div>
                <div class="card-body">
                    <form class="" method="POST" action="{{url('admin/incomehead/update',$incomeheadData->id)}}" novalidate="">
                        @csrf
                        <div class="row g-3">
                            
                            <div class="col-6 mb-3">
                                <label class="form-label" for="validationCustom01">Name</label>
                                <input class="form-control" id="validationCustom01" type="text" value="{{$incomeheadData->head}}" 
                                    name='head' required="">

                                    @if ($errors->has('head'))
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first('head') }}
                            </div>
                            @endif
                            </div>
                           
                            
                        </div>

                        <div class="col-12">
                            <button class="btn btn-primary" type="submit" id="form-submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection