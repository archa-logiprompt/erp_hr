@extends('layouts.dashboard.app')
@section('content')

    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Role head</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Data Tables</li>
                            <li class="breadcrumb-item active">Role head Table</li>
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


                                <a class="btn btn-primary btn-sm" type="button"  href="{{route('admin.role.create')}}">Add</a>
                              </div>
                              <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
 
                                        @foreach ($roleData as $heads)
                                             
                                        
                                        <tr>
                                            <td>{{$heads->role}}</td>
                                            
                                            <td>
                                                <ul class="action">
                                                    <li class="edit"> <a href="{{url('/admin/role/edit',$heads->id)}}"><i
                                                                class="icon-pencil-alt"></i></a></li>
                                                    <li class="delete"><a href="{{url('/admin/role/destroy',$heads->id)}}"  onClick="return confirm('Are you sure?');"><i class="icon-trash"></i></a>
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