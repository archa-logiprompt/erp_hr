@extends('layouts.dashboard.app')
@section('content')
    
    <div class="page-body">
        <div class="loading"></div>
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Assign Permission ({{ $roleData->role }})</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Data Tables</li>
                            <li class="breadcrumb-item active">Assign Permission</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <!-- Zero Configuration  Starts-->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar">
                                <div class="common-flex justify-content-end mb-5">
                                </div>

                                <table class="display" id="basic-1">

                                    {{-- <tbody> --}}

                                    @foreach ($permissionData as $heads)
                                        <thead>
                                            <tr>
                                                <th colspan="5" class="text-center">
                                                    {{ $heads['permission_group'] }}</th>
                                            </tr>
                                            <tr>
                                                <th>Permissions</th>
                                                <th>Add</th>
                                                <th>View</th>
                                                <th>Update</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($heads['permission'] as $index => $permission)
                                                {{-- @php
                                                    $formatedArray = json_decode(
                                                        json_encode($permission['assignedRoles']),
                                                        true,
                                                    );
                                                    $addData=array();
                                                    dd($add);
                                                    $add = array_search(
                                                        1,
                                                        array_column($formatedArray, 'permission_type_id'),
                                                    );
                                                    if ($add >= 0) {
                                                        $addData = $permission['assignedRoles'][$add];
                                                    }
                                                    // $view = array_search(
                                                    //     2,
                                                    //     array_column($formatedArray, 'permission_type_id'),
                                                    // );
                                                    // $update = array_search(
                                                    //     3,
                                                    //     array_column($formatedArray, 'permission_type_id'),
                                                    // );
                                                    // $delete = array_search(
                                                    //     4,
                                                    //     array_column($formatedArray, 'permission_type_id'),
                                                    // );
                                                @endphp --}}

                                                <tr>
                                                    <td>{{ $permission['permission'] }}</td>
                                                    <td><select class="permissions" data-type="1"
                                                            data-permission="{{ $permission['id'] }}" data-id=""
                                                            data-role_id="{{ $roleData['id'] }}">
                                                            <option value="1">None</option>
                                                            <option value="2">All</option>
                                                            <option value="3">Owned</option>

                                                        </select>
                                                    </td>
                                                    <td><select class="permissions" data-type="2"
                                                            data-permission="{{ $permission['id'] }}" data-id=""
                                                            data-role_id="{{ $roleData['id'] }}">
                                                            <option value="1">None</option>
                                                            <option value="2">All</option>
                                                            <option value="3">Owned</option>
                                                        </select>
                                                    </td>
                                                    <td><select class="permissions" data-type="3"
                                                            data-permission="{{ $permission['id'] }}" data-id=""
                                                            data-role_id="{{ $roleData['id'] }}">
                                                            <option value="1">None</option>
                                                            <option value="2">All</option>
                                                            <option value="3">Owned</option>
                                                        </select>
                                                    </td>
                                                    <td><select class="permissions" data-type="4"
                                                            data-permission="{{ $permission['id'] }}" data-id=""
                                                            data-role_id="{{ $roleData['id'] }}">
                                                            <option value="1">None</option>
                                                            <option value="2">All</option>
                                                            <option value="3">Owned</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    @endforeach




                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
    @include('hr.script')
@endsection
