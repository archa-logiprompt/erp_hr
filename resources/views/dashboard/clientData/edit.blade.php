@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4>Client Account Details</h4>
                </div>
                <div class="card-body">
                    <form class="" id="clientForms" method="POST"
                        action="{{ url('admin/client/update', $clientdata->id) }}" novalidate=""
                        enctype="multipart/form-data">

                        @csrf
                        <div class="row g-4">

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="salutation">Salutation</label>
                                <select class="form-select" name="salute" >

                                    <option disabled value="">Please select...</option>

                                    <!-- Populate options dynamically -->
                                    @foreach (config('global.Salutations') as $salutation)
                                        <option value="{{ $salutation }}"
                                            {{ isset($clientdata->salutation) && $clientdata->salutation === $salutation ? 'selected' : '' }}>
                                            {{ $salutation }}
                                        </option>
                                    @endforeach
                                </select>

                                @if ($errors->has('salutation'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('salutation') }}
                                    </div>
                                @endif

                            </div>



                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="clientName">Client Name <span style="color: red;">*</span></label>
                                <input class="form-control" name="name" type="text" value="{{ $clientdata->name }}"
                                    placeholder="e.g. John" >
                                @if ($errors->has('name'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="clientEmail">Email</label>
                                <input class="form-control" name="email" type="email"
                                    value="{{ $clientdata->user->email }}" placeholder="john@gmail.com" >
                                @if ($errors->has('email'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>

<!--                           <div class="col-md-4 position-relative">-->
<!--    <label class="form-label" for="clientPassword">Password*</label>-->
<!--    <div class="input-group">-->
<!--        <input -->
<!--            id="clientPassword" -->
<!--            class="form-control" -->
<!--            name="password" -->
<!--            type="password" -->
<!--            value="{{ $clientdata->user->password }}"-->
<!--        >-->
<!--        <button -->
<!--            type="button" -->
<!--            class="btn btn-outline-primary" -->
<!--            id="togglePassword"-->
<!--        >-->
<!--            Show-->
<!--        </button>-->
<!--    </div>-->
<!--    @if ($errors->has('password'))-->
<!--        <div class="alert alert-danger mt-2">-->
<!--            {{ $errors->first('password') }}-->
<!--        </div>-->
<!--    @endif-->
<!--</div>-->

                            <div class="col-md-4 position-relative">
                                <label for="country" class="form-label">Select Country:</label>
                                <select class="form-select" name="country" id="country" onchange="updateDialCode()"
                                    >
                                    <option disabled value="">Please select a country...</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country['code'] }}" data-dialcode="{{ $country['dialCode'] }}"
                                            {{ isset($clientdata->country) && $clientdata->country === $country['code'] ? 'selected' : '' }}>
                                            {{ $country['name'] }} ({{ $country['flag'] }})
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('country'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('country') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="clientMobile">Mobile</label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text" id="mobileDialCode">
                                        +{{ isset($clientdata->mobileDialCode) ? $clientdata->mobileDialCode : '93' }}
                                    </span>
                                    <input class="form-control" name="mobile" type="number"
                                        value="{{ isset($clientdata->mobile) ? $clientdata->mobile : '' }}"
                                        placeholder="e.g. 1234567890" >
                                    <div class="invalid-tooltip">Please enter a valid mobile number.</div>
                                </div>
                                <input type="hidden" name="dialCode" id="dialCode"
                                    value="{{ isset($clientdata->mobileDialCode) ? $clientdata->mobileDialCode : '93' }}">
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="clientGender">Gender</label>
                                <select class="form-select" name="gender" >
                                    <option disabled value="">Please select...</option>

                                    <option value="Male"
                                        {{ isset($clientdata->gender) && $clientdata->gender === 'Male' ? 'selected' : '' }}>
                                        Male</option>
                                    <option value="Female"
                                        {{ isset($clientdata->gender) && $clientdata->gender === 'Female' ? 'selected' : '' }}>
                                        Female</option>
                                    <option value="Others"
                                        {{ isset($clientdata->gender) && $clientdata->gender === 'Others' ? 'selected' : '' }}>
                                        Others</option>
                                </select>

                                @if ($errors->has('gender'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('gender') }}
                                    </div>
                                @endif

                            </div>


                            <div class="col-md-4 position-relative">
                                <label for="">Existing Profile picture</label>
                                <div>
                                    <img src="{{ asset($clientdata->ProfilePicture) }}"
                                        style="height: 90px; width: 120px;">
                                </div>
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="profilePic">Change profile picture</label>
                                <input class="form-control" name="ProfilePicture" type="file" accept="image/*">
                                @if ($errors->has('ProfilePicture'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('ProfilePicture') }}
                                    </div>
                                @endif
                            </div>



                            {{-- File Upload --}}
                            {{-- <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Single File Upload</h4>
                                    <p>Use the <code>.dropzone</code> class to create upload files. <a href="https://www.dropzone.dev/" target="_blank">Dropzone Documentation</a></p>
                                </div>
                                <div class="card-body">
                                    <form class="dropzone" id="singleFileUpload" action="/upload.php">
                                        <div class="dz-message needsclick">
                                            <i class="icon-cloud-up"></i>
                                            <h6 class="f-w-600">Drop files here or click to upload.</h6>
                                            <span class="note needsclick">(This is just a demo dropzone. Files are <strong>not</strong> actually uploaded.)</span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> --}}

                            <div class="card-header">
                                <h4>Company Details</h4>
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="companyName">Company Name<span style="color: red;">*</span> </label>
                                <input class="form-control" name="companyName" type="text"
                                    placeholder="e.g. ABC Corp" value="{{ $clientdata->companyName }}" >
                                @if ($errors->has('companyName'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('companyName') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="officialWebsite">Official Website </label>
                                <input class="form-control" name="officialWebsite" type="url"
                                    value="{{ $clientdata->officialWebsite }}" placeholder="e.g. www.abccorp.com"
                                    >
                          
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="gstNumber">GST/VAT Number<span style="color: red;">*</span> </label>
                                <input class="form-control" name="gstNumber" type="text"
                                    placeholder="e.g. 22AAAAA0000A1Z5" value="{{ $clientdata->gstNumber }}" >
                               
                            </div>

                            <div class="col-md-3 position-relative">
                                <label class="form-label" for="officePhone">Office Number </label>
                                <input class="form-control" name="officePhone" type="text"
                                    value="{{ $clientdata->officePhone }}" placeholder="e.g. 080-12345678" >
                                
                            </div>


                            <div class="col-md-3 position-relative">
                                <label class="form-label" for="city">City</label>
                                <input class="form-control" name="city" type="text"
                                    value="{{ $clientdata->city }}" >
                             
                            </div>

                            <div class="col-md-3 position-relative">
                                <label class="form-label" for="state">State</label>
                                <input class="form-control" name="state" type="text"
                                    value="{{ $clientdata->state }}" >
                               
                            </div>

                            <div class="col-md-3 position-relative">
                                <label class="form-label" for="postalCode">Postal Code</label>
                                <input class="form-control" name="postalCode" type="number"
                                    value="{{ $clientdata->postalCode }}" >
                                
                            </div>

                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="companyAddress">Company Address</label>
                                <textarea class="form-control" name="companyAddress" rows="3" >{{ $clientdata->companyAddress }}</textarea>
                               
                            </div>

                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="shippingAddress">Shipping Address</label>
                                <textarea class="form-control" name="shippingAdd" rows="3" >{{ $clientdata->shippingAddress }}</textarea>
                                
                            </div>


                            <div class="col-12">
                                <label for="editor">Additional Notes</label>
                                <div class="toolbar-box">

                                    {{-- <div id="toolbar2"><span class="ql-formats">
                                            <select class="ql-size"></select></span><span class="ql-formats">
                                            <button class="ql-bold">Bold </button>
                                            <button class="ql-italic">Italic </button>
                                            <button class="ql-underline">underline</button>
                                            <button class="ql-strike">Strike </button></span><span class="ql-formats">
                                            <button class="ql-list" value="ordered">List </button>
                                            <button class="ql-list" value="bullet"> </button>
                                            <button class="ql-indent" value="-1"> </button>
                                            <button class="ql-indent" value="+1"></button></span><span
                                            class="ql-formats">
                                            <button class="ql-link"></button>
                                            <button class="ql-image"></button>
                                            <button class="ql-video"></button></span>
                                    </div> --}}
                                    <div class="col-md-12 position-relative editor-container">

                                        <textarea id="editor" name="note" class="form-control" rows="10">{{ $clientdata->note }}</textarea>
                                        @if ($errors->has('note'))
                                            <div class="alert alert-danger mt-2">
                                                {{ $errors->first('note') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="">Existing Logo</label>
                                <div>
                                    <img src="{{ asset($clientdata->logo) }}" style="height: 90px; width: 120px;">
                                </div>
                            </div>
                            <div class="col-md-12 position-relative">
                                <label class="form-label" for="logo">Change Logo</label>
                                <div>
                                    <input class="form-control" type="file" name="logo" accept="image/*">
                                </div>
                            </div>



                            <div class="col-12">
                                <button class="btn btn-primary" type="button" id="form-submit-btn">Submit Form</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        function updateDialCode() {

            const countryDropdown = document.getElementById('country');
            const selectedOption = countryDropdown.options[countryDropdown.selectedIndex];
            const dialCode = selectedOption.getAttribute('data-dialcode');
            document.getElementById('mobileDialCode').textContent = `+${dialCode}`;
            document.getElementById('dialCode').value = dialCode;
        }

        ClassicEditor.create(document.querySelector('editor'))
            .catch(error => {
                console.error(error);
            });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('clientForms');

        $('#form-submit-btn').on('click', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(form);
            const clientId = "{{ $clientdata->id }}"; // Laravel Blade to inject course ID
            const api8000Url =
            `/public/admin/client/update/${clientId}`; // Web app URL (8000)
            const api8080Url =
            baseurl+"admin/newclient/update/"+clientId; // API URL (8080)

            // First, update the client in the web database (8000)
            $.ajax({
                url: api8000Url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log("Updated in web app (8000):", response);

                    // If successful, now update the client in the second database via the API (8080)
                    $.ajax({
                        url: api8080Url,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log("Updated in API (8080):", response);
                            alert("client details updated!");
                            window.location.href =
                                `/public/admin/client`; // Redirect after success
                        },
                        error: function(xhr) {
                            console.error("Error updating in API (8080):", xhr);
                            alert(
                                "client updated in web database (8000) but failed in API (8080). Please check logs.");
                        }
                    });
                },
                error: function(xhr) {
                    console.error("Error updating in web app (8000):", xhr);
                    alert("Failed to update client in web app (8000). Please try again.");
                }
            });
        });
    });
</script>
<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('clientPassword');
        const passwordFieldType = passwordField.getAttribute('type');
        
        // Toggle between password and text input types
        if (passwordFieldType === 'password') {
            passwordField.setAttribute('type', 'text');
            this.textContent = 'Hide'; // Change button text
        } else {
            passwordField.setAttribute('type', 'password');
            this.textContent = 'Show'; // Change button text back
        }
    });
</script>
@endsection
