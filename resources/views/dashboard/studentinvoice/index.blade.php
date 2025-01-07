@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>View Fee Details</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg>
                                </a>
                            </li>
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
                <!-- Zero Configuration Starts-->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <div class="common-flex justify-content-end mb-5">
                                    <a class="btn btn-primary btn-sm" href="{{ route('admin.studentinvoice.create') }}">Add</a>
                                </div>
                                  <div class="dt-ext table-responsive custom-scrollbar">
                                <table class="table table-bordered" id="export-button">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Unitprice</th>
                                            <th>Gst</th>
                                            <th>Amount</th>
                                            <th>Total Amount</th>
                                            <th>pdf</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalAmount = 0; // Initialize total amount
                                        @endphp
                                        @foreach ($studentinvoicedetails as $studentinvoice)
                                            @php
                                                $totalAmount += $studentinvoice->amount; // Add each amount to totalAmount
                                            @endphp
                                            <tr>
                                                <!-- Use the 'student' relationship to access studentname -->
                                                <td>{{ $studentinvoice->student->studentname ?? 'N/A' }}</td>
                                                <td>{{ $studentinvoice->unitprice }}</td>
                                                <td>{{ $studentinvoice->gst }}</td>
                                                <td>{{ $studentinvoice->amount }}</td>
                                                <td>{{ $studentinvoice->total_amount }}</td>
                                                <td>
                                                    <a href="{{ route('admin.studentinvoice.view', $studentinvoice->id) }}">
                                                        <i class="fa fa-arrow-down"></i>
                                                    </a>
                                                </td>

                                                <td>
                                                    <ul class="action">
                                                        <li class="edit">
                                                            <a href="{{ url('/admin/studentinvoice/edit', $studentinvoice->id) }}">
                                                                <i class="icon-pencil-alt"></i>
                                                            </a>
                                                        </li>
                                                        <!--<li class="delete">-->
                                                        <!--    <a href="#" class="delete-btn" data-id="{{ $studentinvoice->id }}">-->
                                                        <!--        <i class="icon-trash"></i>-->
                                                        <!--    </a>-->
                                                        <!--</li>-->
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
    <th class="text-right" style="color: red;">Total:</th>
    <th class="text-right" style="color: red;"></th> <!-- Display sum of unitprice -->
    <th class="text-right" style="color: red;"></th>
    <th style="color: red;">{{ number_format($totalAmount, 2) }}</th>
    <th class="text-right" style="color: red;">{{ number_format($totalUnitPrice, 2) }}</th>
    <th></th>
    <th></th>
    <th></th>
</tr>

                                    </tbody>
                                   
                                </table>
                            </div>
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
                if (!confirm('Are you sure you want to delete this studentinvoice?')) {
                    return;
                }

                // Get the student ID from the data attribute
                const studentinvoiceId = this.getAttribute('data-id');

                // Define both delete URLs
                const deleteUrl8000 =
                    `/public/admin/studentinvoice/destroy/${studentinvoiceId}`; // Route for 8000
                const deleteUrl8080 =
                    baseurl + "admin/studencashtinvoice/destroy/" + studentinvoiceId; // API route for 8080

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
                            alert('studentinvoice deleted successfully!');
                            location.reload(); // Reload the page to update the table
                        } else {
                            alert('Error deleting the studentinvoice.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(
                            'An unexpected error occurred while deleting the studentinvoice.');
                    });
            });
        });
    });
</script>
