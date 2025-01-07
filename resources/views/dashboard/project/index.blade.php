@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>View ProjectDetails</h4>
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
                                        href="{{ route('admin.project.create') }}">Add</a>
                                </div>
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            {{-- <th>ShortCode</th> --}}
                                            <th>Category</th>
                                            <th>Department</th>
                                            <th>Client</th>
                                            {{-- <th>Summary</th> --}}
                                            <th>Startdate</th>
                                            <th>Deadline</th>

                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($projectdetails as $project)
                                            <tr>
                                                <td>{{ $project->projectname }}</td>
                                                {{-- <td>{{ $project->shortcode }}</td> --}}
                                                <td>{{ $project->category }}</td>
                                                <td>{{ $project->department }}</td>
                                                <td>{{ $project->clientDetails->companyName ?? 'No Client Assigned' }}</td>
                                                {{-- <td>{{ $project->summary }}</td> --}}
                                                <td>{{ $project->startdate }}</td>
                                                <td>{{ $project->deadline }}</td>

                                                <td>
                                                    <ul class="action">
                                                        <li class="edit"> <a
                                                                href="{{ url('/admin/project/edit', $project->id) }}"><i
                                                                    class="icon-pencil-alt"></i></a></li>
                                                        {{-- <li class="delete"><a href="{{url('/admin/project/destroy',$project->id)}}"><i class="icon-trash"></i></a>
                                                    </li> --}}
                                                    
                                                     <li class="delete">
                                                        <a href="#" class="delete-btn" data-id="{{ $project->id }}">
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
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            if (!confirm('Are you sure you want to delete this project?')) {
                return;
            }

            const projectId = this.getAttribute('data-id');
            const baseurl = "{{ url('/') }}/"; // Update this if needed
            const deleteUrl8000 = `/public/admin/project/destroy/${projectId}`;
            const deleteUrl8080 = `${baseurl}admin/project/destroy/${projectId}`;

            console.log('Delete URL 8000:', deleteUrl8000);
            console.log('Delete URL 8080:', deleteUrl8080);

            Promise.all([
                fetch(deleteUrl8000, { method: 'GET' }),
                fetch(deleteUrl8080, { method: 'GET' })
            ])
            .then(responses => {
                const allSuccessful = responses.every(response => response.ok);

                if (allSuccessful) {
                    alert('Project deleted successfully!');
                    location.reload();
                } else {
                    alert('Error deleting the project.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred while deleting the project.');
            });
        });
    });
});

</script>
