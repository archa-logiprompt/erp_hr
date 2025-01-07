@php
use Carbon\Carbon;

// Filtering the last 30 days
$last30Days = Carbon::now()->subDays(30);
$clientinvoiceDetails = $clientinvoiceDetails->where('invoiceDate', '>=', $last30Days);
$totalAmount = $clientinvoiceDetails->sum('total');
@endphp

@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h4>Client Invoice List (Last 30 Days)</h4>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Data Tables</li>
                            <li class="breadcrumb-item active">Client Invoice Table</li>
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
                            <div class="dt-ext table-responsive custom-scrollbar">
                                <div class="common-flex justify-content-end mb-5">
                                    <a class="btn btn-primary btn-sm" type="button"
                                        href="{{ route('admin.clientinvoice.create') }}">Add</a>
                                </div>
                                <table class="table table-bordered" id="export-button">
                                    <thead>
                                        <tr>
                                            <th>Invoice Number</th>
                                            <th>Date</th>
                                            <th>Client</th>
                                            <th>Total Amount</th>
                                            <th>Download Invoice</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($clientinvoiceDetails as $invoiceData)
                                            <tr>
                                                <td>{{ $invoiceData->prefix . $invoiceData->invoiceNumber }}</td>
                                                <td>{{ \Carbon\Carbon::parse($invoiceData->invoiceDate)->format('d/m/Y') }}</td>
                                                <td>{{ $invoiceData->client->companyName ?? 'N/A' }}</td>
                                                <td>{{ number_format($invoiceData->total, 2) }}</td>
                                                <td>
                                                    <a class="btn-md"
                                                        href="{{ url('/admin/invoicePdf/' . $invoiceData->id) }}">
                                                        <i class="fa fa-download" aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <ul class="action">
                                                        <li class="edit"><a
                                                                href="{{ url('/admin/clientinvoice/edit', $invoiceData->invoiceNumber) }}"><i
                                                                    class="icon-pencil-alt"></i></a></li>
                                                        <!--<li class="delete">-->
                                                        <!--    <a href="#" class="delete-btn" data-id="{{ $invoiceData->id }}">-->
                                                        <!--        <i class="icon-trash"></i>-->
                                                        <!--    </a>-->
                                                        <!--</li>-->
                                                    </ul>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th class="text-right" style="color: red;">Total:</th>
                                            <th class="text-right" style="color: red;"></th>
                                            <th class="text-right" style="color: red;"></th>
                                            <th style="color: red;">{{ number_format($totalAmount, 2) }}</th>
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
        <!-- Container-fluid Ends-->
    </div>
@endsection
