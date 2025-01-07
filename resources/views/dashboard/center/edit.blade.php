@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Edit Center</h4>

                </div>
                <div class="card-body">
                    @if ($errors->any())
                        {{ implode('', $errors->all('<div>:message</div>')) }}
                    @endif
                    <form method="POST" id="centerForms" action="{{ url('admin/center/update', $centerdata->id) }}"
                        enctype="multipart/form-data" novalidate="">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <!-- name -->
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">Name*</label>
                                <input class="form-control" id="validationCustom01" type="text" placeholder="center Name"
                                    name="name" value="{{ old('name', $centerdata->name) }}" required>

                                @if ($errors->has('name'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>

                            <!-- email -->

                            <div class="col-6">
                                <label class="form-label" for="exampleFormControlInput1">Email* </label>
                                <input class="form-control" id="exampleFormControlInput1" type="email"
                                    placeholder="enter your email" value="{{ old('email', $centerdata->email) }}"
                                    name='email' required="">
                                @if ($errors->has('email'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('email') }}>
                                    </div>
                                @endif

                            </div>

                            <div class="col-6">
                                <label class="form-label" for="validationCustom01"> Mobile Number*</label>
                                <input class="form-control @error('mobile') is-invalid @enderror" id="validationCustom01"
                                    value="{{ old('mobile', $centerdata->mobile) }}" type="number" name="mobile"
                                    placeholder="Enter your number" required>
                                @error('mobile')
                                    <div class="invalid-feedback" style="color: red;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- address -->
                            <div class="col-12">
                                <label class="form-label" for="exampleFormControlTextarea1">Address*</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" name="address" rows="3">{{ $centerdata->address }}</textarea>
                            </div>
                            <!-- File and Image Uploads in the Same Row -->
                            <div class="row">
                                <!-- Image Upload -->
                                <div class="col-md-6">
                                    <label for="existingPhoto">Existing Photo</label>
                                    <div id="existingPhotoContainer">
                                        <!-- Display existing image -->
                                        @if (!empty($centerdata->image))
                                            <img id="existingPhoto" src="{{ asset($centerdata->image) }}"
                                                style="height: 90px; width: 120px;">
                                        @else
                                            <p id="noPhotoText">No photo uploaded.</p>
                                        @endif
                                    </div>

                                    <label for="newImage">Change Photo *</label>
                                    <div>
                                        <input type="file" name="image" accept="image/*" class="form-control"
                                            id="imageInput">
                                        <div id="previewContainer" style="margin-top: 10px;">
                                            @if ($errors->has('image'))
                                                <div class="alert alert-danger mt-2">
                                                    {{ $errors->first('image') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <button class="btn btn-primary" type="button" id="form-submit-btn">Submit form</button>
                                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('centerForms');

        $('#form-submit-btn').on('click', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(form);
            const centerId = "{{ $centerdata->id }}"; // Laravel Blade to inject center ID
            const api8000Url =
            `/public/admin/center/update/${centerId}`; // Web app URL (8000)
            const api8080Url =
            baseurl+"admin/newcenter/update/"+centerId; // API URL (8080)

            // First, update the center in the web database (8000)
            $.ajax({
                url: api8000Url,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log("Updated in web app (8000):", response);

                    // If successful, now update the center in the second database via the API (8080)
                    $.ajax({
                        url: api8080Url,
                        type: 'post',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log("Updated in API (8080):", response);
                            alert("center updated!");
                            window.location.href =
                                `/public/admin/center`; // Redirect after success
                        },
                        error: function(xhr) {
                            console.error("Error updating in API (8080):", xhr);
                            alert(
                                "center updated in web database (8000) but failed in API (8080). Please check logs.");
                        }
                    });
                },
                error: function(xhr) {
                    console.error("Error updating in web app (8000):", xhr);
                    alert("Failed to update center in web app (8000). Please try again.");
                }
            });
        });
    });
</script>
