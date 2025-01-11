@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Permission head</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Data Tables</li>
                            <li class="breadcrumb-item active">Permission head Table</li>
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
                                    <a class="btn btn-primary btn-sm" type="button"
                                        href="{{ route('admin.permission.create-group') }}">+ Permission Group</a>
                                    <a class="btn btn-primary btn-sm" type="button"
                                        href="{{ route('admin.permission.create') }}">+ Permission </a>

                                </div>
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>Permission Group</th>
                                            <th>Permissions</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($permissionData as $heads)
                                            <tr>
                                                <td>{{ $heads->permission_group }}</td>
                                                <td class="row mx-2">
                                                    @foreach ($heads['permission'] as $permission)
                                                        <div class="col-3 bg-dark-subtle p-2 rounded m-1">
                                                            {{ $permission->permission }}
                                                            <a href="{{ url('/admin/permission/edit', $permission->id) }}"><i
                                                                    class="icon-pencil-alt"></i></a>
                                                            <a href="{{ url('/admin/permission/destroy', $permission->id) }}"
                                                                class="text-danger"><i class="icon-trash"></i></a>
                                                        </div>
                                                    @endforeach

                                                </td>
                                                <td>
                                                    <ul class="action">
                                                        <li class="edit"> <a
                                                                href="{{ url('/admin/permission/edit-group', $heads->id) }}"><i
                                                                    class="icon-pencil-alt"></i></a></li>
                                                        <li class="delete"><a
                                                                href="{{ url('/admin/permission/destroy-group', $heads->id) }}"
                                                                onClick="return confirm('Are you sure?');"><i
                                                                    class="icon-trash"></i></a>
                                                        </li>

                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>


                                </table>


                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        <!-- Container-fluid Ends-->
    </div>
@endsection
