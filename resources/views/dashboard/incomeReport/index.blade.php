@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4> Income Reports</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.incomeReport.index') }}" novalidate>
                        @csrf
                        <div class="row">
                               <div class="col-md-6">
                                <label class="form-label" for="center">Center</label>
                                <select class="form-select" name="center">
    <option selected disabled value="">...</option>
        <option selected  value="all">All</option>

    @foreach ($centerdetails as $center)
        <option value="{{ $center->id }}"
            {{ old('center') == $center->id ? 'selected' : '' }}>
            {{ $center->name }}
        </option>
    @endforeach
</select>

                            </div>
                        </div>
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
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </form>

@if (!empty($incomeDetails) && count($incomeDetails) > 0)
    <div class="card-header mb-5">
        <h4>Filtered Results</h4>
    </div>
    <table class="display" id="basic-1">
        <thead>
            <tr>
                <th>Head</th>
                <th>Center</th>
                <th>Date</th>
                <th>Name</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($incomeDetails as $income)
                <tr>
                    <td>{{ $income->incomeHead->head ?? 'N/A' }}</td>
                    <td>{{ $income->centers->name ?? 'N/A' }}</td>
                    <td>{{ $income->date ? \Carbon\Carbon::parse($income->date)->format('d-m-Y') : 'N/A' }}</td>
                    <td>{{ $income->name ?? 'N/A' }}</td>
                    <td>{{ $income->amount ?? 'N/A' }}</td>
                    <td>{{ $income->method ?? 'N/A' }}</td>
                    <td>
                        <ul class="action">
                            <li class="edit">
                                <a href="{{ url('/admin/incomedetails/edit', $income->id) }}"><i class="icon-pencil-alt"></i></a>
                            </li>
                            <li class="delete">
                                <a href="{{ url('/admin/incomedetails/destroy', $income->id) }}" onClick="return confirm('Are you sure?');">
                                    <i class="icon-trash"></i>
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p class="mt-5 text-center">No income details found for the selected filter.</p>
@endif

                </div>
            </div>
        </div>
    </div>
@endsection
