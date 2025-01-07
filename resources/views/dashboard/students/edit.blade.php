@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Edit Student</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        {{ implode('', $errors->all('<div>:message</div>')) }}
                    @endif
                    <form method="POST" id="studentForms" action="{{ url('admin/students/update', $studentdata->id) }}"
                        enctype="multipart/form-data" novalidate="">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">

                            <!-- salutation -->
                            <div class="col-6">
                                <label class="form-label" for="validationDefault04">Salutation</label>
                                <select class="form-select" id="validationDefault04" name="salutation" required>
                                    <option selected disabled value="">Choose...</option>
                                    @foreach (config('global.Salutations') as $salutation)
                                        <option value="{{ $salutation }}"
                                            @if (old('salutation', $studentdata->salutation) == $salutation) selected @endif>
                                            {{ $salutation }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- name -->
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">Name<span style="color: red;">*</span></label>
                                <input class="form-control" id="validationCustom01" type="text"
                                    placeholder="Student Name" name="studentname"
                                    value="{{ old('studentname', $studentdata->studentname) }}" required>

                                @if ($errors->has('studentname'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('studentname') }}
                                    </div>
                                @endif
                            </div>

                            <!-- email -->

                            <div class="col-6">
                                <label class="form-label" for="exampleFormControlInput1">Email<span style="color: red;">*</span> </label>
                                <input class="form-control" id="exampleFormControlInput1" type="email"
                                    placeholder="enter your email" value="{{ old('email', $studentdata->email) }}"
                                    name='email' required="">
                                @if ($errors->has('email'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('email') }}>
                                    </div>
                                @endif

                            </div>
                            <!-- Course -->
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">Course<span style="color: red;">*</span></label>
                                <select class="form-select @error('course_id') is-invalid @enderror" id="validationCourse"
                                    name="course_id" required onchange="updateFee()">
                                    <option selected disabled value="">Choose...</option>
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->id }}" data-fee="{{ $course->fee }}"
                                            {{ (old('course_id') ?? $studentdata->course_id) == $course->id ? 'selected' : '' }}>
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

                            <!-- Fees -->
                             <div class="col-6">
                                <label class="form-label" for="validationCustom01">Fees<span style="color: red;">*</span></label>
                                <input class="form-control" id="" type="number" placeholder="Fees"
                                    value="{{ $studentdata->fees }}" name="fees" required>
                                @if ($errors->has('fees'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('fees') }}
                                    </div>
                                @endif
                            </div>


                            <div class="col-6">
                                <label class="form-label" for="validationCustomFees">Frequency<span style="color: red;">*</span></label>
                                <input class="form-control @error('frequency') is-invalid @enderror" id=""
                                    type="number" placeholder="Frequency" 
                                    value="{{$studentdata->frequency?$studentdata->frequency:4}}" name="frequency"
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
                                <input class="form-control" id="validationCustom01" type="number"
                                    placeholder=" enter your admission number"
                                    value="{{ old('admissionnumber', $studentdata->admissionnumber) }}"
                                    name='admissionnumber' required="">
                                @if ($errors->has('admissionnumber'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('admissionnumber') }}
                                    </div>
                                @endif
                            </div>
                            <!-- stedadmissionnumber -->
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01"> STED Admission Number</label>
                                <input class="form-control" id="validationCustom01" type="number"
                                    placeholder=" enter your sted admission number"
                                    value="{{ $studentdata->stedadmissionnumber }}" name='stedadmissionnumber'
                                    required="">
                                @if ($errors->has('stedadmissionnumber'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('stedadmissionnumber') }}
                                    </div>
                                @endif
                            </div>

                            <!-- gender -->
                            <div class="card-wrapper border rounded-3 checkbox-checked col-6">
                                <h6 class="sub-title col sm-3">Select your gender*</h6>
                                <div class="radio-form">
                                    <div class="form-check">
                                        <input class="form-check-input" id="flexRadioDefault1" type="radio" name="gender"
                                            value="male" {{ $studentdata->gender == 'male' ? 'checked' : '' }}
                                            required />
                                        <label class="form-check-label" for="flexRadioDefault1">Male</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" id="flexRadioDefault2" type="radio" name="gender"
                                            value="female" {{ $studentdata->gender == 'female' ? 'checked' : '' }}
                                            required />
                                        <label class="form-check-label" for="flexRadioDefault2">Female</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" id="flexRadioDefault3" type="radio"
                                            name="gender" value="other"
                                            {{ $studentdata->gender == 'other' ? 'checked' : '' }} required />
                                        <label class="form-check-label" for="flexRadioDefault3">Other</label>
                                    </div>
                                </div>
                            </div>

                            <!-- admission date -->
                            <div class="col-6">
                                <label class="col-sm-3">Admission Date<span style="color: red;">*</span></label>
                                <div class="col-sm-12">
                                    <input class="form-control digits" id="example-datetime-local-input"
                                        type="datetime-local" name="admissiondate"
                                        value="{{ \Carbon\Carbon::parse($studentdata->admissiondate)->format('Y-m-d\TH:i') }}" />
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-label" for="validationCustom01"> Mobile Number<span style="color: red;">*</span></label>
                                <input class="form-control @error('mobile') is-invalid @enderror" id="validationCustom01"
                                    value="{{ old('mobile', $studentdata->mobile) }}" type="number" name="mobile"
                                    placeholder="Enter your number" required>
                                @error('mobile')
                                    <div class="invalid-feedback" style="color: red;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- additionalcontact -->

                            <div class="col-6">
                                <label class="form-label" for="validationCustom01"> Additional Number</label>
                                <input class="form-control" id="validationCustom01" type="number"
                                    placeholder=" enter your  number" value="{{ $studentdata->additionalcontactno }}"
                                    name='additionalcontactno' required="">
                                @if ($errors->has('additionalcontactno'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('additionalcontactno') }}
                                    </div>
                                @endif
                            </div>
                            <!-- gst -->
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">GST Number<span style="color: red;">*</span></label>
                                <input class="form-control" id="validationCustom01" type="number"
                                    placeholder=" enter your gst number" value="{{ old('gstno', $studentdata->gstno) }}"
                                    name='gstno' required="">
                                @if ($errors->has('gstno'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('gstno') }}
                                    </div>
                                @endif
                            </div>
                            <!-- aadhar -->
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01"> Aadhar Number<span style="color: red;">*</span></label>
                                <input class="form-control" id="validationCustom01" type="number"
                                    placeholder=" enter your aadhar" value="{{ old('aadhar', $studentdata->aadhar) }}"
                                    name='aadhar' required="">
                                @if ($errors->has('aadhar'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('aadhar') }}
                                    </div>
                                @endif
                            </div>
                            <!-- description -->
                            <div class="col-6">
                                <label class="form-label" for="exampleFormControlTextarea1">Description</label>
                                <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="3">
                                 {{ old('description', $studentdata->description) }}
                                </textarea>
                            </div>

                            <!-- address -->
                            <div class="col-12">
                                <label class="form-label" for="exampleFormControlTextarea1">Address<span style="color: red;">*</span></label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="address" rows="3">{{ $studentdata->address }}</textarea>
                            </div>

                            <!-- File and Image Uploads in the Same Row -->
                            <div class="row">
                                <!-- File Upload -->
                                <div class="col-md-6">
                                    <label class="form-label" for="formFile">Upload a File</label>
                                    <div>
                                        <!-- Display existing file -->
                                        @if (!empty($studentdata->file))
                                            <p>Current File:
                                                <a href="{{ asset($studentdata->file) }}" target="_blank">View File</a>
                                            </p>
                                        @else
                                            <p>No file uploaded.</p>
                                        @endif
                                        <input type="file" name="file" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg"
                                            class="form-control">
                                        @if ($errors->has('file'))
                                            <div class="alert alert-danger mt-2">
                                                {{ $errors->first('file') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Image Upload -->
                                <div class="col-md-6">
                                    <label for="existingPhoto">Existing Photo</label>
                                    <div id="existingPhotoContainer">
                                        <!-- Display existing image -->
                                        @if (!empty($studentdata->image))
                                            <img id="existingPhoto" src="{{ asset($studentdata->image) }}"
                                                style="height: 90px; width: 120px;">
                                        @else
                                            <p id="noPhotoText">No photo uploaded.</p>
                                        @endif
                                    </div>

                                    <label for="newImage">Change Photo *</label>
                                    <div>
                                        <input type="file" name="image" accept="image/*" class="form-control"
                                            id="imageInput">
                                        <div id="previewContainer" style="margin-top: 10px;"></div>
                                        @if ($errors->has('image'))
                                            <div class="alert alert-danger mt-2">
                                                {{ $errors->first('image') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <button class="btn btn-primary" id="form-submit-btn" type="button">Submit form</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function updateFee() {
        // Get the selected course
        const courseSelect = document.getElementById('validationCourse');
        const selectedOption = courseSelect.options[courseSelect.selectedIndex];

        // Get the fee from the selected course's data-fee attribute
        const fee = selectedOption.getAttribute('data-fee');

        // Update the fee input field
        document.getElementById('feeInput').value = fee || '';
    }

    // Initialize fee input field with the currently selected course's fee (if applicable)
    document.addEventListener('DOMContentLoaded', () => {
        updateFee();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('studentForms');

        $('#form-submit-btn').on('click', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(form);
            const studentId = "{{ $studentdata->id }}"; // Laravel Blade to inject course ID
            const api8000Url =
                `/public/admin/students/update/${studentId}`; // Web app URL (8000)
            const api8080Url =
            baseurl+"admin/newstudents/update/"+studentId; // API URL (8080)

            // First, update the studentdata in the web database (8000)
            $.ajax({
                url: api8000Url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log("Updated in web app (8000):", response);

                    // If successful, now update the studentdata in the second database via the API (8080)
                    $.ajax({
                        url: api8080Url,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log("Updated in API (8080):", response);
                            // alert("studentdata updated !");
                            window.location.href =
                                `/public/admin/students`; // Redirect after success
                        },
                        error: function(xhr) {
                            console.error("Error updating in API (8080):", xhr);
                            // alert(
                            //     "studentdata updated in web database (8000) but failed in API (8080). Please check logs."
                            // );
                        }
                    });
                },
                error: function(xhr) {
                    console.error("Error updating in web app (8000):", xhr);
                    // alert(
                    //     "Failed to update studentdata in web app (8000). Please try again."
                    //     );
                }
            });
        });
    });
</script>
