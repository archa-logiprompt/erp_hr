@extends('layouts.dashboard.app')
@section('content')

{{-- @dd((config('global.Salutations'))) --}}
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Employee List</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Data Tables</li>
                            <li class="breadcrumb-item active">Employee Table</li>
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


                                <a class="btn btn-primary btn-sm" type="button"  href="{{route('admin.employee.create')}}">Add</a>
                              </div>
                              <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Emp Id</th>
                                            <th>Phone No</th>

                                            <th>Email</th>
                                            <th>Department</th>
                                            <th>Designation</th>



                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $emp)
                                        @if ($emp['status'] == 1)
                                        <tr>
                                            <td>{{$emp['user']['name']}}</td>
                                            <td>{{$emp['empid']}}</td>
                                            <td>{{$emp['mobile']}}</td>
                                            <td>{{$emp['user']['email']}}</td>
                                            <td>{{$emp['department']['dep_name']}}</td>
                                            <td>{{$emp['designation']['name']}}</td>


                                            <td>
                                                <ul class="action">
                                                    <li class="edit"> <a href="{{url('/admin/employee/edit',$emp->id)}}"><i
                                                                class="icon-pencil-alt"></i></a></li>
                                                    <li class="delete"><a href="{{url('/admin/employee/destroy',$emp->id)}}"  onClick="return confirm('Are you sure?');"><i class="icon-trash"></i></a>
                                                    </li>

                                                </ul>
                                            </td>
                                            
                                        </tr>
                                        @endif
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


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Select all delete buttons
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                // Confirm delete action
                if (!confirm('Are you sure you want to delete this course?')) {
                    return;
                }

                // Get the course ID from the data attribute
                const courseId = this.getAttribute('data-id');

                // Define both delete URLs
                const deleteUrl8000 = `/public/admin/courses/destroy/${courseId}`; // Route for 8000
                const deleteUrl8080 = baseurl+"admin/newcourses/destroy/"+courseId; // API route for 8080

                // Send AJAX requests to both delete URLs
                Promise.all([
                    fetch(deleteUrl8000, { method: 'GET' }),
                    fetch(deleteUrl8080, { method: 'GET' })
                ])
                .then(responses => {
                    // Check if both requests were successful
                    const allSuccessful = responses.every(response => response.ok);

                    if (allSuccessful) {
                        alert('Course deleted successfully!');
                        location.reload(); // Reload the page to update the table
                    } else {
                        alert('Error deleting the course.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An unexpected error occurred while deleting the course.');
                });
            });
        });
    });
</script>
