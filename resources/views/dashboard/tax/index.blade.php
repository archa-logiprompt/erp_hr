@extends('layouts.dashboard.app')

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Tax</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Data Tables</li>
                            <li class="breadcrumb-item active">Tax Table</li>
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
                                        href="{{ route('admin.tax.create') }}">Add</a>
                                </div>
                                <table class="display" id="basic-1">
                                    <thead>
                                        <tr>
                                            <th>TaxName</th>
                                            <th>SubTitle</th>
                                            <th>Percentage</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($taxdetails as $tax)
                                            <tr>
                                                <td>{{ $tax->taxname }}</td>
                                                <td>
                                                    <ul class="custom-list">
                                                        @foreach ($tax->subtitle as $subtitle)
                                                            <li>{{ $subtitle }}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul class="custom-list">
                                                        @foreach ($tax->percentage as $percentage)
                                                            <li>{{ $percentage }}%</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>
                                                    <ul class="action">
                                                        <li class="edit">
                                                            <a href="{{ url('/admin/tax/edit', $tax->id) }}"><i
                                                                    class="icon-pencil-alt"></i></a>
                                                        </li>
                                                        {{-- <li class="delete">
                                                            <a href="{{ url('/admin/tax/destroy', $tax->id) }}" onClick="return confirm('Are you sure?');">
                                                                <i class="icon-trash"></i>
                                                            </a>
                                                        </li> --}}

                                                        <li class="delete">
                                                            <a href="#" class="delete-btn"
                                                                data-id="{{ $tax->id }}">
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
            /* This will add bullet points */
            margin-left: 20px;
            /* Optional: Adjust indentation */
        }
    </style>
@endpush


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all delete buttons
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                // Confirm delete action
                if (!confirm('Are you sure you want to delete this tax?')) {
                    return;
                }

                // Get the tax ID from the data attribute
                const taxId = this.getAttribute('data-id');

                // Define both delete URLs
                const deleteUrl8000 = `/public/admin/tax/destroy/${taxId}`; // Route for 8000
                const deleteUrl8080 =
                baseurl+"admin/newtax/destroy/"+taxId; // API route for 8080

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
                            alert('tax deleted successfully!');
                            location.reload(); // Reload the page to update the table
                        } else {
                            alert('Error deleting the tax.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An unexpected error occurred while deleting the tax.');
                    });
            });
        });
    });
</script>
