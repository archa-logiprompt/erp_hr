@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Add Student</h4>

                </div>
                <div class="card-body">
                    <form method="POST" id="studentForm" action="{{ route('admin.student.store') }}" novalidate
                        enctype="multipart/form-data">
                        @csrf
                          
                        <div class="row g-3">
                            <!-- Salutation -->
                            <div class="col-6">
                                <label class="form-label" for="validationDefault04">Salutation</label>
                                <select class="form-select @error('salutation') is-invalid @enderror"
                                    id="validationDefault04" name="salutation" required>
                                    <option selected disabled value="">Choose...</option>
                                    @foreach (config('global.Salutations') as $salutation)
                                        <option value="{{ $salutation }}"
                                            {{ old('salutation') == $salutation ? 'selected' : '' }}>
                                            {{ $salutation }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('salutation')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- name -->
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">Name<span style="color: red;">*</span></label>
                                <input class="form-control @error('studentname') is-invalid @enderror"
                                    id="validationCustom01" type="text" name="studentname"
                                    value="{{ old('studentname') }}" placeholder="Student Name" required>
                                @error('studentname')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- email -->
                            <div class="col-6">
                                <label class="form-label" for="exampleFormControlInput1">Email<span style="color: red;">*</span></label>
                                <input class="form-control @error('email') is-invalid @enderror"
                                    id="exampleFormControlInput1" type="email" placeholder="Enter your email"
                                    name="email" value="{{ old('email') }}" required="">

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- course -->
                            <div class="col-6">
                                <label class="form-label" for="exampleFormControlInput1">Course<span style="color: red;">*</span></label>
                                <select class="form-select @error('course_id') is-invalid @enderror" id="validationCourse"
                                    name="course_id" required>
                                    <option selected disabled value="">Choose...</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}" data-fee="{{ $course->fee }}"
                                            {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->coursename }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Fees Field -->
                           <div class="col-6">
                                <label class="form-label" for="validationCustomFees">Fees<span style="color: red;">*</span></label>
                                <input class="form-control @error('fees') is-invalid @enderror" id="validationCustomFees"
                                    type="number" placeholder="Fees"
                                    value="{{ old('fees', $selectedCourse ? $selectedCourse->fee : '') }}" name="fees"
                                    required>
                                @error('fees')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label class="form-label" for="validationCustomFees">Frequency<span style="color: red;">*</span></label>
                                <input class="form-control @error('frequency') is-invalid @enderror" id="validationCustomFees"
                                    type="number" placeholder="Frequency" 
                                    value="{{ old('frequency')?old('frequency'):4 }}" name="frequency"
                                    required>
                                @error('frequency')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- admissionnumber -->
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">Admission Number<span style="color: red;">*</span></label>
                                <input class="form-control @error('admissionnumber') is-invalid @enderror"
                                    id="validationCustom01" type="number" placeholder="Enter your admission number"
                                    value="{{ old('admissionnumber') }}" name="admissionnumber" required>
                                @error('admissionnumber')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- stedadmissionnumber -->
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">STED Admission Number</label>
                                <input class="form-control @error('stedadmissionnumber') is-invalid @enderror"
                                    id="validationCustom01" type="number" placeholder="Enter your STED admission number"
                                    value="{{ old('stedadmissionnumber') }}" name="stedadmissionnumber" required>
                                @error('stedadmissionnumber')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <!-- Gender -->
                            <div class="card-wrapper border rounded-3 checkbox-checked col-6">
                                <h6 class="sub-title col sm-3">Select your gender<span style="color: red;">*</span></h6>
                                <div class="radio-form @error('flexRadioDefault') is-invalid @enderror">
                                    <div class="form-check">
                                        <input class="form-check-input" id="flexRadioDefault1" type="radio"
                                            name="flexRadioDefault" value="male"
                                            {{ old('flexRadioDefault') == 'male' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="flexRadioDefault1">Male</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" id="flexRadioDefault2" type="radio"
                                            name="flexRadioDefault" value="female"
                                            {{ old('flexRadioDefault') == 'female' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="flexRadioDefault2">Female</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" id="flexRadioDefault3" type="radio"
                                            name="flexRadioDefault" value="other"
                                            {{ old('flexRadioDefault') == 'other' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="flexRadioDefault3">Other</label>
                                    </div>

                                    @error('flexRadioDefault')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Admission Date -->
                            <div class="col-6">
                                <label class="col-sm-3">Admission Date<span style="color: red;">*</span></label>
                                <div class="col-sm-12">
                                    <input class="form-control digits @error('admissiondate') is-invalid @enderror"
                                        id="example-datetime-local-input" type="datetime-local" name="admissiondate"
                                        value="{{ old('admissiondate', isset($studentdata->admissiondate) ? \Carbon\Carbon::parse($studentdata->admissiondate)->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
                                        max="{{ now()->format('Y-m-d\TH:i') }}" required />
                                    @error('admissiondate')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Mobile Number -->
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01"> Mobile Number<span style="color: red;">*</span></label>
                                <input class="form-control @error('mobile') is-invalid @enderror" id="validationCustom01"
                                    value="{{ old('mobile') }}" type="number" name="mobile"
                                    placeholder="Enter your number" required>
                                @error('mobile')
                                    <div class="invalid-feedback" style="color: red;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Additional Contact Number -->
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01"> Additional Number</label>
                                <input class="form-control @error('additionalcontactno') is-invalid @enderror"
                                    value="{{ old('additionalcontactno') }}" id="validationCustom01" type="number"
                                    name="additionalcontactno" placeholder="Enter your additional number" required>
                                @error('additionalcontactno')
                                    <div class="invalid-feedback" style="color: red;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- GST Number -->
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01"> GST Number </label>
                                <input class="form-control @error('gstno') is-invalid @enderror" id="validationCustom01"
                                    value="{{ old('gstno') }}" type="text" name="gstno"
                                    placeholder="Enter your GST number">
                                @error('gstno')
                                    <div class="invalid-feedback" style="color: red;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Aadhar Number -->
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01"> Aadhar Number<span style="color: red;">*</span></label>
                                <input class="form-control @error('aadhar') is-invalid @enderror" id="validationCustom01"
                                    type="number" value="{{ old('aadhar') }}" name="aadhar"
                                    placeholder="Enter your Aadhar number" required>
                                @error('aadhar')
                                    <div class="invalid-feedback" style="color: red;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-6">
                                <label class="form-label" for="exampleFormControlTextarea1">Description</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="description" rows="3">{{ old('description') }}</textarea>
                            </div>


                            <!-- Address -->
                            <div class="col-6">
                                <label class="form-label" for="exampleFormControlTextarea1"> Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="exampleFormControlTextarea1"
                                    name="address" rows="3">{{ old('address') }}</textarea>
                                @if ($errors->has('address'))
                                    <div class="invalid-feedback" style="color: red;">


                                        {{ $errors->first('address') }}
                                    </div>
                                @endif
                            </div>


                            <div class="row mt-2">
                                <!-- File Upload -->
                                <div class="col-6">
                                    <label class="form-label" for="formFile">Upload Documents</label>
                                    <input type="file" name="file" accept="application/pdf,image/*"
                                        class="@error('file') is-invalid @enderror" required>
                                    @error('file')
                                        <div class="invalid-feedback" style="color: red;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Image Upload -->
                                <div class="col-6">
                                    <label class="form-label" for="formFile">Upload Image</label>
                                    <input type="file" name="image" accept="image/*"
                                        class="@error('image') is-invalid @enderror" required>
                                    @error('image')
                                        <div class="invalid-feedback" style="color: red;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <button class="btn btn-primary" id="form-submit-btn" type="submit">Submit
                                    form</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<script>
    document.addEventListener("DOMContentLoaded", () => {
        // For input fields
        const formFields = document.querySelectorAll('.form-control');
        formFields.forEach(field => {
            field.addEventListener('input', () => {
                if (field.value.trim() !== "") {
                    const errorFeedback = field.parentElement.querySelector(
                        '.invalid-feedback');
                    if (errorFeedback) {
                        errorFeedback.style.display = 'none';
                    }
                    field.classList.remove('is-invalid');
                }
            });
        });

        // For select dropdowns
        const selectBoxes = document.querySelectorAll('select');
        selectBoxes.forEach(select => {
            select.addEventListener('change', () => {
                if (select.value) {
                    select.classList.remove('is-invalid');
                    const errorFeedback = select.parentElement.querySelector(
                        '.invalid-feedback');
                    if (errorFeedback) {
                        errorFeedback.style.display = 'none';
                    }

                    // Dynamically update the fees field
                    const selectedOption = select.options[select.selectedIndex];
                    const fee = selectedOption.getAttribute('data-fee');
                    const feesField = document.getElementById('validationCustomFees');

                    if (feesField) {
                        feesField.value = fee || '';
                        // Remove validation error from fees when updated
                        feesField.classList.remove('is-invalid');
                        const feesError = feesField.parentElement.querySelector(
                            '.invalid-feedback');
                        if (feesError) {
                            feesError.style.display = 'none';
                        }
                    }
                }
            });
        });
    });
</script>



<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Correct the event listener to trigger on form submission
        $('#form-submit-btn').on('click', function(e) {
            e.preventDefault(); // Prevent default form submit
            const form = document.getElementById('studentForm');
            const formData = new FormData(form);
            // Make the AJAX request
            $.ajax({
                url: baseurl+"admin/newstudents/store", // Replace with your backend route

                // url : "{{ config('util.api') }}admin/newstudents/store",

                type: 'POST',
                data: formData,
                processData: false, // Don't process the data (important for FormData)
                contentType: false, // Don't set content type (important for FormData)
                success: function(response) {
                    // Handle success response
                    if (response) {
                        alert('student data added successfully!');
                    } else {
                        alert('There was an error submitting the student.');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.log('AJAX error:', error);
                    alert('There was an error processing the form.');
                }
            });
            $('#studentForm').submit()
        });
    });
</script>
@endsection