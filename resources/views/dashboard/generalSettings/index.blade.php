@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>General Settings</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Data Tables</li>
                            <li class="breadcrumb-item active">General settings Table</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar">
                                <div class="common-flex justify-content-end mb-5">
                                    @if ($generalData->isEmpty())
                                        <a class="btn btn-primary btn-sm" type="button"
                                            href="{{ route('admin.generalsettings.create') }}">Add</a>
                                    @endif
                                </div>
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Prefix</th>
                                            <th>Starting No.</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($generalData as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->prefix }}</td>
                                                <td>{{ $data->startingNo }}</td>
                                                <td>
                                                    <ul class="action">
                                                        <li class="edit"> <a
                                                                href="{{ url('/admin/generalsettings/edit', $data->id) }}"><i
                                                                    class="icon-pencil-alt"></i></a></li>
                                                        {{-- <li class="delete"><a
                                                                href="{{ url('/admin/generalsettings/destroy', $data->id) }}"
                                                                onClick="return confirm('Are you sure?');"><i
                                                                    class="icon-trash"></i></a>
                                                        </li> --}}

                                                        <li class="delete">
                                                            <a href="#" class="delete-btn" data-id="{{ $data->id }}">
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

    </div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Select all delete buttons
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();

                // Confirm delete action
                if (!confirm('Are you sure you want to delete this General settings?')) {
                    return;
                }

                // Get the General settings ID from the data attribute
                const settingsId = this.getAttribute('data-id');

                // Define both delete URLs
                const deleteUrl8000 = `/public/admin/generalsettings/destroy/${settingsId}`; // Route for 8000
                const deleteUrl8080 = baseurl+"admin/newgeneralsettings/destroy/"+settingsId; // API route for 8080

                // Send AJAX requests to both delete URLs
                Promise.all([
                    fetch(deleteUrl8000, { method: 'GET' }),
                    fetch(deleteUrl8080, { method: 'GET' })
                ])
                .then(responses => {
                    // Check if both requests were successful
                    const allSuccessful = responses.every(response => response.ok);

                    if (allSuccessful) {
                        alert('General settings deleted successfully!');
                        location.reload(); // Reload the page to update the table
                    } else {
                        alert('Error deleting the General settings.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An unexpected error occurred while deleting the General settings.');
                });
            });
        });
    });
</script>