@extends('layouts.dashboard.app')

@section('content')
 
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Expense Update</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.expense.update', $expensedata->id) }}" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <!-- Head Field -->
                            <div class="col-6 position-relative">
                                <label class="form-label" for="head">Head</label>
                                <select class="form-select" name="head" required>
                                    <option selected disabled value="">...</option>
                                    @foreach ($headdetails as $data)
                                        <option value="{{ $data->id }}" {{ $expensedata->head == $data->id ? 'selected' : '' }}>
                                            {{ $data->head }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('head'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('head') }}
                                    </div>
                                @endif
                            </div>
                             <!-- Center Field -->
<!-- Center Field -->
<div class="col-6 mb-3">
                                <label class="form-label" for="center">Center</label>
                                <select class="form-select" name="center">
                                    <option selected disabled value="">...</option>
                                    @foreach ($centerdetails as $center)
                                        <option value="{{ $center->id }}" {{ old('center', $expensedata->center) == $center->id ? 'selected' : '' }}>
                                            {{ $center->name }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                @if ($errors->has('center'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('center') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Date Field -->
                            <div class="col-6 mb-3">
                                <label class="form-label" for="date">Date</label>
                                <input class="form-control" id="date" type="date" name="date" value="{{ old('date', $expensedata->date) }}" required>
                                @if ($errors->has('date'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('date') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Name Field -->
                            <div class="col-6">
                                <label class="form-label" for="name">Name</label>
                                <input class="form-control" id="name" type="text" name="name" value="{{ old('name', $expensedata->name) }}" required>
                                @if ($errors->has('name'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Amount Field -->
                            <div class="col-6 mb-3">
                                <label class="form-label" for="amount">Amount</label>
                                <input class="form-control" id="amount" type="number" name="amount" value="{{ old('amount', $expensedata->amount) }}" required>
                                @if ($errors->has('amount'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('amount') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Description -->
                            <div class="col-6">
                                <label class="form-label" for="description">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="3">{{ old('description', $expensedata->description) }}</textarea>
                            </div>

                            <!-- Document -->
                            <div class="col-md-6">
                                <label class="form-label" for="document">Upload a File*</label>
                                <div>
                                    @if (!empty($expensedata->document))
                                        <p>Current File: <a href="{{ asset($expensedata->document) }}" target="_blank">View File</a></p>
                                    @else
                                        <p>No document uploaded.</p>
                                    @endif
                                    <input type="file" name="document" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg" class="form-control">
                                    @if ($errors->has('document'))
                                        <div class="alert alert-danger mt-2">
                                            {{ $errors->first('document') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-12 mt-5">
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
