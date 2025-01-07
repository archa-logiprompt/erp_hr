@extends('layouts.dashboard.app')

@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4> GST Report</h4>
                </div>
                <div class="card-body">
                    <form class="" method="POST" action="{{ route('admin.gstreport.store') }}" novalidate="">
                        @csrf
                        <div class="col-6">
                            <label class="form-label" for="validationCustom01">Category</label>
                            <select class="form-select @error('gstreport') is-invalid @enderror"
                                id="validationDefaultDepartment" name="gstreport" required
                                onchange="clearValidationMessage(this)">
                                <option selected disabled value="">Choose...</option>
                                @foreach (config('global.GstReport') as $gstreport)
                                    <option value="{{ $gstreport }}"
                                        {{ old('gstreport') == $gstreport ? 'selected' : '' }}>
                                        {{ $gstreport }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gstreport')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row mt-3">
                            <!-- From Date -->
                            <div class="col-md-6">
                                <label for="from-date" class="form-label">From Date*</label>
                                <input class="form-control" id="from-date" type="date" name="fromDate"
                                    value="{{ request('fromDate', now()->startOfMonth()->format('Y-m-d')) }}">
                            </div>

                            <!-- To Date -->
                            <div class="col-md-6">
                                <label for="to-date" class="form-label">To Date*</label>
                                <input class="form-control" id="to-date" type="date" name="toDate"
                                    value="{{ request('toDate', now()->endOfMonth()->format('Y-m-d')) }}">
                            </div>
                        </div>

                        <div class="col-12 mt-5">
                            <button class="btn btn-primary" type="submit">Submit form</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Display invoices table if there are any invoices --}}
        @if (isset($invoices) && $invoices->isNotEmpty())
            <div class="col-xl-12 mt-4">
                <div class="card height-equal">
                    <div class="card-header">
                        <h4>GST Report Invoices</h4>
                    </div>
                    <div class="card-body">
                      <table class="table table-bordered" id="export-button">
    <thead>
        <tr>
            <th>#</th>
            <th>Invoice No</th>
            <th>Invoice Date</th>
            <th>Company/Student Name</th> <!-- New column -->
            <th>Total Amount</th>
            <th>GST</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($invoices as $invoice)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                @if(isset($invoice->student)) <!-- Check if it's a StudentInvoice -->
                    {{ $invoice->invoiceno }}
                @elseif(isset($invoice->client)) <!-- Check if it's a ClientInvoice -->
                    {{ $invoice->invoiceno }}
                @endif
            </td>
            <td>{{ $invoice->invoicedate ?? $invoice->invoiceDate }}</td>
            <td>{{ $invoice->companyOrStudentName }}</td> <!-- Display the Company/Student Name -->
            <td class="total-amount">{{ number_format($invoice->total_amount ?? $invoice->total ?? 0, 2) }}</td>
            <td class="gst">{{ number_format($invoice->gst ?? $invoice->gstamount ?? 0, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" style="text-align: left; font-weight: bold; color: red;">
                Total
            </td>
            <td id="totalAmountSum" style="color: red;"></td>
            <td id="gstSum" style="color: red;"></td>
        </tr>
    </tfoot>
</table>




                    @else
                        <p class="text-center">No invoices found for the selected category.</p>
        @endif
    </div>
    </div>
    </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        let totalAmountSum = 0;
        let gstSum = 0;

        // Loop through each table row in the tbody and calculate totals for Total Amount and GST
        document.querySelectorAll('tbody tr').forEach(function(row) {
            let totalAmount = parseFloat(row.querySelector('.total-amount').textContent.replace(/,/g, '')) || 0;
            let gstAmount = parseFloat(row.querySelector('.gst').textContent.replace(/,/g, '')) || 0;

            totalAmountSum += totalAmount;
            gstSum += gstAmount;
        });

        // Set the total amounts in the footer
        document.getElementById('totalAmountSum').textContent = totalAmountSum.toFixed(2);
        document.getElementById('gstSum').textContent = gstSum.toFixed(2);
        
        // Export logic (assuming you're using something like TableExport.js or a similar export library)
        document.getElementById('export-button').addEventListener('click', function() {
            let table = document.getElementById('export-button').closest('table'); // Get the table
            let rows = table.rows;
            
            // Adjust the last row (totals) for export
            let lastRow = rows[rows.length - 1];
            lastRow.cells[4].textContent = totalAmountSum.toFixed(2); // Total Amount
            lastRow.cells[5].textContent = gstSum.toFixed(2); // GST Sum

            // Now export the table with the totals included
            // Implement your export functionality (e.g., TableExport.js, etc.)
        });
    });
</script>

@endsection
