@extends('layouts.dashboard.app')

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Fee</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Data Tables</li>
                            <li class="breadcrumb-item active">fee Table</li>
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
                                        href="{{ route('admin.fee.create') }}">Add</a>
                                </div>
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>SubTitle</th>
                                            <th>Splitup</th>
                                            <th>Taxes</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($feedetails as $fee)
                                            <tr>
                                                <td>{{ $fee->title }}</td>
                                                <td>
                                                    @if (is_array($fee->subtitle))
                                                        <ul class="custom-list">
                                                            @foreach ($fee->subtitle as $subtitle)
                                                                <li>{{ $subtitle }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span>No subtitles available</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (is_array($fee->splitup) && count($fee->splitup) > 0)
                                                        <ul class="custom-list">
                                                            @foreach ($fee->splitup as $splitup)
                                                                <li>{{ $splitup }}%</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span>No splitups available</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    @if (!empty($fee->taxes))
                                                        <ul class="custom-list">
                                                            @foreach ($fee->taxes as $taxname)
                                                                <li>{{ $taxname }}</li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <span>No taxes available</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <ul class="action">
                                                        <li class="edit">
                                                            <a href="{{ url('/admin/fee/edit', $fee->id) }}"><i
                                                                    class="icon-pencil-alt"></i></a>
                                                        </li>
                                                        <li class="delete">
                                                            <!-- Form for deletion -->
                                                            <form id="delete-form-{{ $fee->id }}"
                                                                action="{{ route('admin.fee.destroy', $fee->id) }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>

                                                            <!-- Delete Button -->
                                                            <a href="#" class="delete-btn"
                                                                data-id="{{ $fee->id }}">
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

@push('styles')
    <style>
        .custom-list {
            list-style-type: disc;
            margin-left: 20px;
        }

        .action {
            display: flex;
            gap: 5px;
        }
    </style>
@endpush


<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Select all delete buttons
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            // Confirm delete action
            if (!confirm('Are you sure you want to delete this fee?')) {
                return;
            }

            // Get the fee ID from the data attribute
            const feeId = this.getAttribute('data-id');

            // Define both delete URLs
            const deleteUrl8000 = `/public/admin/fee/destroy/${feeId}`; // Route for 8000
            const deleteUrl8080 = baseurl+"admin/newfee/destroy/"+feeId; // API route for 8080

            // Get CSRF token from the meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Send AJAX requests to both delete URLs with CSRF token
            Promise.all([
                fetch(deleteUrl8000, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,  // Include CSRF token in header
                    },
                }),
                fetch(deleteUrl8080, {
                    method: 'DELETE',
                }),
            ])
            .then(responses => {
                responses.forEach(response => {
                    console.log('Response Status:', response.status);
                    response.json().then(body => {
                        console.log('Response Body:', body);
                    });
                });

                // Check if both requests were successful
                const allSuccessful = responses.every(response => response.ok);

                if (allSuccessful) {
                    alert('Fee deleted successfully!');
                    location.reload(); // Reload the page to update the table
                } else {
                    alert('Error deleting the fee.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An unexpected error occurred while deleting the fee.');
            });
        });
    });
});

</script>
