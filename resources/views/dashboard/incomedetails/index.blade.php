@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Income Details</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Data Tables</li>
                            <li class="breadcrumb-item active">Income Details Table</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <!-- Zero Configuration Starts -->
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive custom-scrollbar">
                                <div class="common-flex justify-content-end mb-5">
                                    <a class="btn btn-primary btn-sm" type="button"
                                        href="{{ route('admin.incomedetails.create') }}">Add</a>
                                </div>
                                <div class="dt-ext table-responsive custom-scrollbar">
                                    <table class="table table-bordered" id="export-button">
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
                                            @php
                                                $totalIncome = 0; // Initialize total income
                                            @endphp
                                            @foreach ($incomeData as $income)
                                                @php
                                                    $totalIncome += $income->amount; // Accumulate the total amount
                                                @endphp
                                                <tr>
                                                    <td>{{ $income->incomeHead->head ?? 'N/A' }}</td>
                                                    <td>{{ $income->centers->name ?? 'N/A' }}</td>
                                                    <td>{{ $income->date ? \Carbon\Carbon::parse($income->date)->format('d-m-Y') : 'N/A' }}</td>
                                                    <td>{{ $income->name ?? 'N/A' }}</td>
                                                    <td>{{ number_format($income->amount, 2) ?? 'N/A' }}</td>
                                                    <td>{{ $income->method ?? 'N/A' }}</td>
                                                    <td>
                                                        <ul class="action">
                                                            <li class="edit">
                                                                <a href="{{ url('/admin/incomedetails/edit', $income->id) }}">
                                                                    <i class="icon-pencil-alt"></i>
                                                                </a>
                                                            </li>
                                                            <li class="delete">
                                                                <a href="{{ url('/admin/incomedetails/destroy', $income->id) }}"
                                                                    onClick="return confirm('Are you sure?');">
                                                                    <i class="icon-trash"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" class="text-right" style="color: red;">Total Income:</th>
                                             
                                                <th style="color: red;">{{ number_format($totalIncome, 2) }}</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Zero Configuration Ends -->
            </div>
        </div>
        <!-- Container-fluid Ends -->
    </div>
@endsection
