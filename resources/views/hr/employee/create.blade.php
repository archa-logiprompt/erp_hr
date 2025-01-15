@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4>Client Account Details</h4>
                </div>
                <div class="card-body">
                    <form id="clientForm" method="POST" action="{{ route('admin.client.store') }}" novalidate=""
                        enctype="multipart/form-data">

                        @csrf
                        <div class="row g-4">
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="salutation">Salutation</label>
                                <select class="form-select" name="salute">
                                    <option selected disabled value="">...</option>
                                    @foreach (config('global.Salutations') as $salutation)
                                        <option value="{{ $salutation }}">{{ $salutation }}</option>
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
                                <input class="form-control" name="name" type="text" placeholder="e.g. John"
                                    value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="clientEmail">Email </label>
                                <input class="form-control" name="email" type="email" placeholder="john@gmail.com"
                                    value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>

                            <!--<div class="col-md-4 position-relative">-->
                            <!--    <label class="form-label" for="clientPassword">Password </label>-->
                            <!--    <input class="form-control" name="password" type="password" value="{{ old('password') }}">-->
                            <!--    @if ($errors->has('password'))-->
                            <!--        <div class="alert alert-danger mt-2">-->
                            <!--            {{ $errors->first('password') }}-->
                            <!--        </div>-->
                            <!--    @endif-->
                            <!--</div>-->

                            {{-- Country, Mobile, and Gender --}}
                            {{-- <div class="col-md-3 position-relative">
                            <label class="form-label" for="clientCountry">Country</label>
                            <select class="form-select" id="clientCountry" >
                                <option selected disabled value="">...</option>
                                <option value="India">India</option>
                            </select>
                        </div> --}}
                            <div class="col-md-4 position-relative">
                                <label for="country" class="form-label">Select Country:</label>
                                <select class="form-select" name="country" id="country" onchange="updateDialCode()">
                                    @foreach ($countries as $country)
                                        <option value="{{ $country['code'] }}" data-dialcode="{{ $country['dialCode'] }}">
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
                                <label class="form-label" for="clientMobile">Mobile<span style="color: red;">*</span></label>
                                <div class="input-group has-validation">
                                    <span class="input-group-text" id="mobileDialCode" name="mobileDialCode">+93</span>
                                    <input class="form-control" name="mobile" type="number" placeholder="e.g. 1234567890"
                                        {{-- oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" --}} />

                                </div>

                                <input type="hidden" name="dialCode" id="dialCode" value="93">
                            </div>


                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="clientGender">Gender</label>
                                <select class="form-select" name="gender">
                                    <option selected disabled value="">...</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Others">Others</option>
                                </select>
                                @if ($errors->has('gender'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('gender') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="profilePic">Image</label>
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
                                <input class="form-control" name="companyName" type="text" placeholder="e.g. ABC Corp">

                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="officialWebsite">Official Website </label>
                                <input class="form-control" name="officialWebsite" type="url"
                                    placeholder="e.g. www.abccorp.com">
                                @if ($errors->has('officialWebsite'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('officialWebsite') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="gstNumber">GST/VAT Number <span style="color: red;">*</span></label>
                                <input class="form-control" name="gstNumber" type="text"
                                    placeholder="e.g. 22AAAAA0000A1Z5">
                                @if ($errors->has('gstNumber'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('gstNumber') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-3 position-relative">
                                <label class="form-label" for="officePhone">Office Number <span style="color: red;">*</span></label>
                                <input class="form-control" name="officePhone" type="text"
                                    placeholder="e.g. 080-12345678">
                                @if ($errors->has('officePhone'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('officePhone') }}
                                    </div>
                                @endif
                            </div>


                            <div class="col-md-3 position-relative">
                                <label class="form-label" for="city">City</label>
                                <input class="form-control" name="city" type="text">
                                @if ($errors->has('city'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('city') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-3 position-relative">
                                <label class="form-label" for="state">State</label>
                                <input class="form-control" name="state" type="text">
                                @if ($errors->has('state'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('state') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-3 position-relative">
                                <label class="form-label" for="postalCode">Postal Code</label>
                                <input class="form-control" name="postalCode" type="number">
                                @if ($errors->has('postalCode'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('postalCode') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="companyAddress">Company Address <span style="color: red;">*</span></label>
                                <textarea class="form-control" name="companyAddress" rows="3"></textarea>
                                @if ($errors->has('companyAddress'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('companyAddress') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="shippingAddress">Shipping Address</label>
                                <textarea class="form-control" name="shippingAdd" rows="3"></textarea>
                                @if ($errors->has('shippingAddress'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('shippingAddress') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-12">
                                <label for="editor">Additional Notes</label>
                                <div class="toolbar-box">
                                    {{-- 
                                    <div id="toolbar2"><span class="ql-formats">
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

                                        <textarea id="editor" name="note" class="form-control" rows="10"></textarea>
                                        @if ($errors->has('note'))
                                            <div class="alert alert-danger mt-2">
                                                {{ $errors->first('note') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 position-relative">
                                <label class="form-label" for="logo">Company Logo</label>
                                <input class="form-control" name="logo" type="file" accept="image/*">

                                @if ($errors->has('logo'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('logo') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-12">
                                <button class="btn btn-primary" id="form-submit-btn" type="submit">Submit Form</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

  <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('clientForm');
            
            // Correct the event listener to trigger on form submission
            $('#form-submit-btn').on('click', function(e) {
                // e.preventDefault(); // Prevent default form submit
                
                var formData = new FormData($('#clientForm')[0]);
    
                // Make the AJAX request
                $.ajax({
                    url: baseurl+"admin/newclient/store", // Replace with your backend route
                    type: 'POST',
                    data: formData,
                    processData: false, // Don't process the data (important for FormData)
                    contentType: false, // Don't set content type (important for FormData)
                    success: function(response) {
                        // Handle success response
                        if (response) {
                            alert('Client added successfully!');
                        } else {
                            alert('There was an error submitting the client data.');
                        }
                    },
                
                });
            });
        });
    </script>


    
    <script>
        function updateDialCode() {
            var countrySelect = document.getElementById("country");
            var dialCode = countrySelect.options[countrySelect.selectedIndex].getAttribute("data-dialcode");
            document.getElementById("dialCode").value = dialCode;
            document.getElementById("mobileDialCode").textContent = "+" + dialCode;
        }


        CKEDITOR.replace('editor', {
            toolbar: [{
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', 'Strike']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink']
                },
                {
                    name: 'insert',
                    items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar']
                },
                {
                    name: 'styles',
                    items: ['Styles', 'Format', 'FontSize']
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                }
            ],
            height: 300,
            placeholder: 'Enter your messages...',
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
