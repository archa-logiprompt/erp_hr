@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Edit Course</h4>
                </div>
                <div class="card-body">
                    <form id="courseForms" method="POST" action="{{ route('admin.department.update', $dep->id) }}"
                        novalidate="">
                        @csrf

                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">Name</label>
                                <input class="form-control" id="validationCustom01" type="text" placeholder="Department Name"
                                    name="dep_name" value="{{ $dep->dep_name }}" required="">
                                @if ($errors->has('dep_name'))
                                    <div class="alert alert-danger mt-2">{{ $errors->first('dep_name') }}</div>
                                @endif
                            </div>
                            
                        </div>
                        <div class="col-12 mt-5">
                            <button class="btn btn-primary" id="form-submit-btn" type="submit">Update Department</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



