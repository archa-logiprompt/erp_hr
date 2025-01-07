@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>View Center</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Data Tables</li>
                            <li class="breadcrumb-item active">Course table </li>
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
                                        href="{{ route('admin.center.create') }}">Add</a>
                                </div>
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($centerdetails as $center)
                                            <tr>
                                                <td>{{ $center->name }}</td>
                                                <td>{{ $center->address }}</td>
                                                <td>{{ $center->mobile }}</td>
                                                <td>{{ $center->email }}</td>
                                                <td><img src="{{ asset($center->image) }}" alt="Center Image"
                                                        width="50"></td>
                                                <td>
                                                    <ul class="action">
                                                        <li class="edit">
                                                            <a href="{{ url('/admin/center/edit', $center->id) }}">
                                                                <i class="icon-pencil-alt"></i>
                                                            </a>
                                                        </li>
                                                        {{-- <li class="delete">
                                                            <a href="{{ url('/admin/center/destroy', $center->id) }}">
                                                                <i class="icon-trash"></i>
                                                            </a>
                                                        </li> --}}

                                                        <li class="delete">
                                                            <a href="#" class="delete-btn"
                                                                data-id="{{ $center->id }}">
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
                if (!confirm('Are you sure you want to delete this center?')) {
                    return;
                }

                // Get the center ID from the data attribute
                const centerId = this.getAttribute('data-id');

                // Define both delete URLs
                const deleteUrl8000 = `/public/admin/center/destroy/${centerId}`; // Route for 8000
                const deleteUrl8080 =
                baseurl+"admin/newcenter/destroy/"+centerId; // API route for 8080

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
                            alert('center deleted successfully!');
                            location.reload(); // Reload the page to update the table
                        } else {
                            alert('Error deleting the center.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An unexpected error occurred while deleting the center.');
                    });
            });
        });
    });
</script>
