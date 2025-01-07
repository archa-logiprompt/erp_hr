@extends('layouts.dashboard.app')

@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Income Details</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.incomedetails.store') }}" novalidate>
                        @csrf
                        <div class="row">

                            <!-- Head Field -->
                            <div class="col-6 position-relative">
                                <label class="form-label" for="head">Head<span style="color: red;">*</span></label>
                                <select class="form-select" name="head">
                                    <option selected disabled value="">...</option>
                                    @foreach ($incomeheadData as $data)
                                        <option value="{{ $data->id }}"
                                            {{ old('head') == $data->id ? 'selected' : '' }}>
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
                            <div class="col-6 position-relative">
                                <label class="form-label" for="center">Center<span style="color: red;">*</span></label>
                                <select class="form-select" name="center">
                                    <option selected disabled value="">...</option>
                                    @foreach ($centerdetails as $center)
                                        <option value="{{ $center->id }}"
                                            {{ old('center') == $center->id ? 'selected' : '' }}>
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
                            <div class="col-6">
                                <label class="form-label" for="date">Date<span style="color: red;">*</span></label>
                                <input class="form-control" id="date" type="date" name="date" value="{{ old('date') }}" required>
                                @if ($errors->has('date'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('date') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Name Field -->
                            <div class="col-6">
                                <label class="form-label" for="name">Name<span style="color: red;">*</span></label>
                                <input class="form-control" id="name" type="text" name="name" value="{{ old('name') }}" required>
                                @if ($errors->has('name'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Amount Field -->
                            <div class="col-6">
                                <label class="form-label" for="amount">Amount<span style="color: red;">*</span></label>
                                <input class="form-control" id="amount" type="number" name="amount" value="{{ old('amount') }}" required>
                                @if ($errors->has('amount'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('amount') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Method Field (Radio buttons) -->
                            <div class="col-6 mt-3">
                                <label class="form-label">Method<span style="color: red;">*</span></label>
                                <div class="d-flex align-items-center gap-3">
                                    @foreach (config('global.TransactonMethod') as $transactionmethod)
                                        <div>
                                            <input type="radio" id="{{ strtolower($transactionmethod) }}" name="method" value="{{ $transactionmethod }}"
                                                {{ old('method') == $transactionmethod ? 'checked' : '' }} required>
                                            <label for="{{ strtolower($transactionmethod) }}" class="form-label">{{ $transactionmethod }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            
                                @if ($errors->has('method'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('method') }}
                                    </div>
                                @endif
                            </div>
                            

                            <!-- Submit Button -->
                            <div class="col-12 mt-5">
                                <button class="btn btn-primary" type="submit">Submit Form</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
