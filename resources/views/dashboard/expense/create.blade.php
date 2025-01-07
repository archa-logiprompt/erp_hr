@extends('layouts.dashboard.app')

@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Expense Details</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.expense.store') }}" novalidate
                    enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <!-- Head Field -->
                            <div class="col-6 position-relative">
                                <label class="form-label" for="head">Head</label>
                                <select class="form-select" name="head">
    <option selected disabled value="">Select Expense Head</option>
    @foreach ($headdetails as $data)
        <option value="{{ $data->id }}" {{ old('head') == $data->id ? 'selected' : '' }}>
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
                                <label class="form-label" for="center">Center</label>
                                <select class="form-select" name="center">
    <option selected disabled value="">Select Center</option>
    @foreach ($centerdetails as $center)
        <option value="{{ $center->id }}" {{ old('center') == $center->id ? 'selected' : '' }}>
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
                                <label class="form-label" for="date">Date</label>
                                <input class="form-control" id="date" type="date" name="date" value="{{ old('date') }}" required>
                                @if ($errors->has('date'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('date') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Name Field -->
                            <div class="col-6">
                                <label class="form-label" for="name">Name</label>
                                <input class="form-control" id="name" type="text" name="name" value="{{ old('name') }}" required>
                                @if ($errors->has('name'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Amount Field -->
                            <div class="col-6">
                                <label class="form-label" for="amount">Amount</label>
                                <input class="form-control" id="amount" type="number" name="amount" value="{{ old('amount') }}" required>
                                @if ($errors->has('amount'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('amount') }}
                                    </div>
                                @endif
                            </div>
                           

                           <!-- document -->
                           <div class="col-6">
                                    <label class="form-label" for="formFile">Upload Documents</label>
                                    <input type="file" name="document" accept="application/pdf,image/*"
                                        class="@error('document') is-invalid @enderror" required>
                                    @error('document')
                                        <div class="invalid-feedback" style="color: red;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- description -->
                                <div class="col-6">
                                <label class="form-label" for="exampleFormControlTextarea1">Description</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="description" rows="3">{{ old('description') }}</textarea>
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
