@extends('layouts.dashboard.app')

@section('content')
<div class="page-body">
    <div class="col-xl-12">
        <div class="card height-equal">
            <div class="card-header">
                <h4>Balance Report</h4>
            </div>
            <div class="card-body">
                <!-- Form for selecting a student -->
                <form method="POST" action="{{ route('admin.balance.store') }}" novalidate>
                    @csrf
                    <div class="col-6">
                        <label class="form-label" for="studentSelect">Search Student*</label>
                        <select name="student_id" id="studentSelect" class="form-control" required>
                            <option value="" disabled selected>Select a student</option>
                            @foreach ($students as $student)
                                <option value="{{ $student->id }}" 
                                    {{ isset($selectedStudent) && $selectedStudent->id == $student->id ? 'selected' : '' }}>
                                    {{ $student->studentname }}
                                </option>
                            @endforeach
                        </select>
                        @error('student_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col-12 mt-5">
                        <button class="btn btn-primary" type="submit">Submit form</button>
                    </div>
                </form>

                <!-- Display Balance Information -->
               
                    
                @isset($selectedStudent)
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <label><strong>Total Course Fee:</strong></label>
                            <input type="text" class="form-control" value="{{ $courseFee !== null ? number_format($courseFee, 2) : 'N/A' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label><strong>Balance:</strong></label>
                            <input type="text" class="form-control" value="{{ $latestBalance !== null ? number_format($latestBalance, 2) : 'No balance available' }}" readonly>
                        </div>
                    </div>

                    <!-- Payment History Table -->
                    <!-- Payment History Table -->
<div class="table-responsive mt-5">
    <h4>Payment History</h4>
    <hr>
    <div class="dt-ext table-responsive custom-scrollbar">
        
                                <table class="table table-bordered" id="export-button">
                                    
        <thead>
            <tr>
                
                <th>SlNo.</th>
                <th>Invoice Date</th>
                <th>Invoice No</th>
                <th>Amount</th>
                <th>Download PDF</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalAmount = 0; // Initialize total amount
            @endphp
            @foreach ($previousInvoices as $index => $invoice)
                @php
                    $totalAmount += $invoice->unitprice; // Add each amount to the total
                @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $invoice->invoicedate ? $invoice->invoicedate->format('d/m/Y') : 'N/A' }}</td>
                    <td>{{ $invoice->prefix . $invoice->invoiceno }}</td>
                    <td>{{ number_format($invoice->unitprice, 2) }}</td>
                    <td>
                        <a href="{{ route('admin.balance.view', $invoice->id) }}" title="Download PDF">
                            <i class="fa fa-download"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            <tr>
               <th  class="text-right" style="color: red;">Total:</th>
     <th class="text-right" style="color: red;"></th> <!-- Display sum of unitprice -->
    <th class="text-right" style="color: red;"></th>
      <th style="color: red;">{{ number_format($totalAmount, 2) }}</th>
      <th  class="text-right" style="color: red;"></th>
    
    <th></th>
    <th></th>
   
 
   
    
</tr>
        </tbody>
        <tfoot>
           

        </tfoot>
    </table>
</div>

                @endisset
               
                
                
                
            </div>
        </div>
    </div>
</div>
@endsection
