@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Permission Group head</h4>

                </div>
                <div class="card-body">
                    <form class="" method="POST" action="{{ route('admin.permission.store-group') }}" novalidate="">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">Group Name</label><small
                                    class="text-danger">*</small>
                                <input class="form-control" id="validationCustom01" type="text" name='permission_group'
                                    required="">
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
                                    required="">
                                @if ($errors->has('short_code'))
                                    <span class="text-danger">
                                        {{ $errors->first('short_code') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 mt-5">
                            <button class="btn btn-primary" type="submit">Submit form</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
