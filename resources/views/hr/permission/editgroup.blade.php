@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Permission Group head update</h4>

                </div>
                <div class="card-body">
                    <form class="" method="POST" action="{{ url('admin/permission/update-group', $permissionData->id) }}"
                        novalidate="">
                        @csrf
                        <div class="row g-3">

                            <div class="col-6 mb-3">
                                <label class="form-label" for="validationCustom01">Name</label>
                                <input class="form-control" id="validationCustom01" type="text"
                                    value="{{ $permissionData->permission_group }}" name='permission_group' required="">

                                @if ($errors->has('permission_group'))
                                    <span class="text-danger">
                                        {{ $errors->first('permission_group') }}
                                    </span>
                                @endif
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">Short Code</label><small
                                    class="text-danger">*</small>
                                <input class="form-control" id="validationCustom01" type="text" name='short_code'
                                    required="" value="{{ $permissionData->short_code }}">
                                @if ($errors->has('short_code'))
                                    <span class="text-danger">
                                        {{ $errors->first('short_code') }}
                                    </span>
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
