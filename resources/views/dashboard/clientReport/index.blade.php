@extends('layouts.dashboard.app')
@section('content')
<div class="page-body">
    <div class="col-xl-12">
        <div class="card height-equal">
            <div class="card-header">
                <h4>Client Invoice Reports</h4>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.clientReport.index') }}" novalidate>
                    @csrf
                    <div class="row">
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
                
                    <!-- Submit Button -->
                    <div class="col-12 mt-5">
                        <button class="btn btn-primary" type="submit">Filter</button>
                    </div>
                </form>
          

            @if (!empty($clientinvoiceDetails) && count($clientinvoiceDetails) > 0)
            <div class="card-header mb-5">
                <h4>Filtered Results</h4>
            </div>
            <table class="display" id="basic-1">
                <thead>
                    <tr>
                        <th>Invoice number</th>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Total amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientinvoiceDetails as $invoiceData)
                        <tr>
                            <td>{{ $invoiceData->invoiceNumber }}</td>
                            <td>{{ \Carbon\Carbon::parse($invoiceData->invoiceDate)->format('d/m/Y') }}</td>
                            <td>{{ $invoiceData->client->name ?? 'N/A' }}</td>
                            <td>{{ $invoiceData->total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="mt-5 text-center"></p>
            @endif
        </div>
        </div>
    </div>
</div>
@endsection
