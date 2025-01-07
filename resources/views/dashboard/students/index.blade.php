@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>View Student</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Data Tables</li>
                            <li class="breadcrumb-item active">Basic DataTables</li>
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
                                        href="{{ route('admin.student.create') }}">Add</a>
                                </div>
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Fees</th>
                                            <th>Image</th>
                                            <th>Course</th>
                                            <th>Mobile</th>
                                            <th>Email</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($studentdetails as $student)
                                            <tr>
                                                <td>{{ $student->studentname }}</td>
                                                <td>{{ $student->fees }}</td>
                                                <td><img src="{{ asset($student->image) }}" alt="Student Image"
                                                        width="50"></td>
                                                <td>{{ $student->course->coursename ?? 'N/A' }}</td>
                                                <!-- Display course name -->
                                                <td>{{ $student->mobile }}</td>
                                                <td>{{ $student->email }}</td>
                                                <td>
                                                    <ul class="action">
                                                        <li class="edit">
                                                            <a href="{{ url('/admin/students/edit', $student->id) }}">
                                                                <i class="icon-pencil-alt"></i>
                                                            </a>
                                                        </li>
                                                        {{-- <li class="delete">
                                                            <a href="{{ url('/admin/students/destroy', $student->id) }}">
                                                                <i class="icon-trash"></i>
                                                            </a>
                                                        </li> --}}

                                                        <li class="delete">
                                                            <a href="#" class="delete-btn"
                                                                data-id="{{ $student->id }}">
                                                                <i class="icon-trash"></i>
                                                            </a>
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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all delete buttons
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                // Confirm delete action
                if (!confirm('Are you sure you want to delete this student?')) {
                    return;
                }

                // Get the student ID from the data attribute
                const studentId = this.getAttribute('data-id');

                // Define both delete URLs
                const deleteUrl8000 = `/public/admin/students/destroy/${studentId}`; // Route for 8000
                const deleteUrl8080 =
                baseurl+"admin/newstudents/destroy/"+studentId; // API route for 8080

                // Send AJAX requests to both delete URLs
                Promise.all([
                        fetch(deleteUrl8000, {
                            method: 'GET'
                        }),
                        fetch(deleteUrl8080, {
                            method: 'GET'
                        })
                    ])
                    .then(responses => {
                        // Check if both requests were successful
                        const allSuccessful = responses.every(response => response.ok);

                        if (allSuccessful) {
                            alert('student deleted successfully!');
                            location.reload(); // Reload the page to update the table
                        } else {
                            alert('Error deleting the student.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An unexpected error occurred while deleting the student.');
                    });
            });
        });
    });
</script>
