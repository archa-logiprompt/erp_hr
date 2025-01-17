@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Employee Details</h4>
                </div>
                <div class="card-body">
                    <form id="clientForm" method="POST" action="{{ url('admin/employee/update', $employees->id) }}" novalidate=""
                        enctype="multipart/form-data">

                        @csrf
                        <div class="row g-4">
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="empid">Employee Id<span style="color: red;">*</span></label>
                                <input class="form-control" name="empid" type="text" placeholder="e.g. LPT001"
                                value="{{ $employees->empid }}">
                                @if ($errors->has('empid'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('empid') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="clientName">Employee Name <span style="color: red;">*</span></label>
                                <input class="form-control" name="name" type="text" placeholder="e.g. John"
                                    value="{{ $employees['user']['name'] }}">
                                @if ($errors->has('name'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="clientEmail">Email </label>
                                <input class="form-control" name="email" type="email" placeholder="john@gmail.com"
                                    value="{{$employees['user']['email'] }}">
                                @if ($errors->has('email'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="clientEmail">Password</label>
                                <input class="form-control" name="password" type="password" placeholder="Enter new password">
                                @if ($errors->has('password'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                                <small class="text-muted">Leave this field empty if you do not want to change the password.</small>
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
                                    <option value="{{ $country['code'] }}" data-dialcode="{{ $country['dialCode'] }}" 
                                        @if ($country['code'] == $employees->country) selected @endif>
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
                                    <input class="form-control" name="mobile" type="number" placeholder="e.g. 1234567890" value="{{$employees->mobile}}"
                                        {{-- oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" --}} />

                                </div>
                                @if ($errors->has('mobile'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('mobile') }}
                                    </div>
                                @endif

                                <input type="hidden" name="dialCode" id="dialCode" value="93">
                            </div>

                            <div class="col-md-4 position-relative">
                            <label class="form-label" for="clientGender">Gender</label>
                            <select class="form-select" name="gender">
                                <option disabled value="" {{ !$employees->gender ? 'selected' : '' }}>...</option>
                                <option value="Male" {{ $employees->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $employees->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Others" {{ $employees->gender == 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                            @if ($errors->has('gender'))
                                <div class="alert alert-danger mt-2">
                                    {{ $errors->first('gender') }}
                                </div>
                            @endif
                        </div>


                        <div class="col-md-4 position-relative">
                            <label class="form-label" for="profilePic">Image</label>
                            
                            



                            <div>
                                        @if (!empty($employees->ProfilePicture))
                                            <p>Current File:
                                                <a href="{{ asset($employees->ProfilePicture) }}" target="_blank">View File</a>
                                            </p>
                                        @else
                                            <p>No file uploaded.</p>
                                        @endif
                                        <input type="file" name="ProfilePicture" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg"
                                            class="form-control">
                                        @if ($errors->has('ProfilePicture'))
                                            <div class="alert alert-danger mt-2">
                                                {{ $errors->first('ProfilePicture') }}
                                            </div>
                                        @endif
                            </div>
                        </div>

                        

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="clientMobile">Joining Date<span style="color: red;">*</span></label>
                                <div class="input-group has-validation">
                                    <input class="form-control" name="joining_date" type="date" placeholder="e.g. 04/12/2024" value="{{$employees->joining_date}}"
                                        {{-- oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" --}} />

                                </div>
                                @if ($errors->has('joining_date'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('joining_date') }}
                                    </div>
                                @endif
                                <!-- <input type="hidden" name="dialCode" id="dialCode" value="93"> -->
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="clientMobile"> Date of Birth<span style="color: red;">*</span></label>
                                <div class="input-group has-validation">
                                    <input class="form-control" name="dob" type="date" placeholder="e.g. 04/12/2024" value="{{$employees->dob}}"
                                        {{-- oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" --}} />
                                        @if ($errors->has('dob'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('dob') }}
                                    </div>
                                @endif
                                </div>

                            </div>
                            <!-- <div class="col-md-4 position-relative">
                                <label class="form-label" for="clientGender">Role</label>
                                <select class="form-select chosen-select" name="role[]" id="role" multiple>
                                    @foreach ($role as $roles)
                                        <option value="{{ $roles['id'] }}">
                                            {{ $roles['role'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('role'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('role') }}
                                    </div>
                                @endif
                            </div> -->



                            <div class="col-md-4 position-relative">
                            <label for="dep_name" class="form-label">Select Department:</label>
                            <select class="form-select" name="dep_name" id="dep_name">
                                @foreach ($department as $dep)
                                    <option value="{{ $dep['id'] }}"
                                        @if ($employees->dep_name == $dep['id']) 
                                            selected 
                                        @endif>
                                        {{ $dep['dep_name'] }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('dep_name'))
                                <div class="alert alert-danger mt-2">
                                    {{ $errors->first('dep_name') }}
                                </div>
                            @endif
                        </div>

                            <div class="col-md-4 position-relative">
                                <label for="name" class="form-label">Select Designation:</label>
                                <select class="form-select" name="designation_id" id="designation_id" >
                                    @foreach ($designation as $des)
                                        
                                        <option value="{{ $des['id'] }}"
                                        @if ($employees->designation_id == $des['id']) 
                                            selected 
                                        @endif>
                                        {{ $des['name']}}
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('designation_id'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('designation_id') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4 position-relative">
                                <label for="employee_type" class="form-label">Select Employee Type:<span style="color: red;">*</span></label>
                                <select class="form-select" name="employee_type" id="employee_type">
                                    <option value="1" @if ($employees->employee_type == 1) selected @endif>Regular</option>
                                    <option value="2" @if ($employees->employee_type == 2) selected @endif>Intern</option>
                                    <option value="3" @if ($employees->employee_type == 3) selected @endif>Temporary</option>
                                </select>
                                @if ($errors->has('employee_type'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('employee_type') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="clientMobile">Adhaar No<span style="color: red;">*</span></label>
                                <div class="input-group has-validation">
                                    <input class="form-control" name="adhaar" type="number" placeholder="e.g. 1234567890" value="{{$employees->adhaar}}"
                                        {{-- oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" --}} />

                                </div>
                                @if ($errors->has('adhaar'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('adhaar') }}
                                    </div>
                                @endif
                                <input type="hidden" name="dialCode" id="dialCode" value="93">
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
                                <h4>Other Details</h4>
                            </div>
                           
                            <div class="col-md-4 position-relative">
                                <label class="form-label">Login Allowed<span style="color: red;">*</span></label>
                                <div>
                                    <input type="radio" id="loginYes" name="loginYes" value="0" 
                                        @if ($employees->loginYes == 0) checked @endif required>
                                    <label for="loginYes">Yes</label>
                                </div>
                                <div>
                                    <input type="radio" id="loginNo" name="loginYes" value="1" 
                                        @if ($employees->loginYes == 1) checked @endif>
                                    <label for="loginNo">No</label>
                                </div>
                            </div>


                            <div class="col-md-4 position-relative">
                                <label class="form-label">Recieve Mail<span style="color: red;">*</span></label>
                                <div>
                                    <input type="radio" id="recievemailyes" name="recievemailyes" value="0" 
                                    @if ($employees->recievemailyes == 0) checked @endif  required>
                                    
                                    <label for="loginYes">Yes</label>
                                </div>
                                <div>
                                    <input type="radio" id="recievemailno" name="recievemailyes" value="1" 
                                    @if ($employees->recievemailyes == 1) checked @endif >
                                    <label for="loginNo">No</label>
                                </div>
                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label">Hourly Rate<span style="color: red;">*</span></label>
                                <div>
                                    <input type="radio" id="hourlyrateyes" name="hourlyrateyes" value="0"  
                                     @if ($employees->hourlyrateyes == 0) checked @endif  required>
                                    <label for="hourlyrateyes">Yes</label>
                                </div>
                                <div>
                                    <input type="radio" id="hourlyrateno" name="hourlyrateyes" value="1"   @if ($employees->hourlyrateyes== 1) checked @endif>
                                    <label for="hourlyrateno">No</label>
                                </div>
                            </div>

                       

                            <div class="card-header">
                                <h4>Bank Details</h4>
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="accountname">Account Holder Name </label>
                                <input class="form-control" name="acc_name" type="text" placeholder="e.g. Rohit" value="{{$employees->acc_name}}">

                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="account_no">Account Number </label>
                                <input class="form-control" name="account_no" type="text" placeholder="e.g. 789657123558" value="{{$employees->account_no}}">

                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="bank_name">Bank Name </label>
                                <input class="form-control" name="bank_name" type="text" placeholder="e.g. HDFC" value="{{$employees->bank_name}}">

                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="ifsc"> IFSC Code </label>
                                <input class="form-control" name="ifsc" type="text" placeholder="e.g. HDFC7415" value="{{$employees->ifsc}}">

                            </div>
                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="branch_name"> Branch Name </label>
                                <input class="form-control" name="branch_name" type="text" placeholder="e.g. Kazhakootam" value="{{$employees->branch_name}}">

                            </div>


                            <div class="card-header">
                                <h4>Documents Upload</h4>
                            </div>
                         
                            <div class="col-md-4 position-relative">
                            <label class="form-label" for="profilePic">PG Certificate</label>
                            <div>
                                        @if (!empty($employees->pg))
                                            <p>Current File:
                                                <a href="{{ asset($employees->pg) }}" target="_blank">View File</a>
                                            </p>
                                        @else
                                            <p>No file uploaded.</p>
                                        @endif
                                        <input type="file" name="pg" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg"
                                            class="form-control">
                                        @if ($errors->has('pg'))
                                            <div class="alert alert-danger mt-2">
                                                {{ $errors->first('pg') }}
                                            </div>
                                        @endif
                            </div>
                            </div>



                            
                              <div class="col-md-4 position-relative">
                                    <label class="form-label" for="profilePic">UG Certificate</label>
                                    <div>
                                        @if (!empty($employees->ug))
                                            <p>Current File:
                                                <a href="{{ asset($employees->ug) }}" target="_blank">View File</a>
                                            </p>
                                        @else
                                            <p>No file uploaded.</p>
                                        @endif
                                        <input type="file" name="ug" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg"
                                            class="form-control">
                                        @if ($errors->has('ug'))
                                            <div class="alert alert-danger mt-2">
                                                {{ $errors->first('ug') }}
                                            </div>
                                        @endif
                            </div>
                            </div>

                           
                            <div class="col-md-4 position-relative">
                                    <label class="form-label" for="profilePic">Twelth Certificate</label>
                                    <div>
                                        @if (!empty($employees->twelth))
                                            <p>Current File:
                                                <a href="{{ asset($employees->twelth) }}" target="_blank">View File</a>
                                            </p>
                                        @else
                                            <p>No file uploaded.</p>
                                        @endif
                                        <input type="file" name="twelth" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg"
                                            class="form-control">
                                        @if ($errors->has('twelth'))
                                            <div class="alert alert-danger mt-2">
                                                {{ $errors->first('twelth') }}
                                            </div>
                                        @endif
                            </div>
                            </div>


                            <div class="col-md-4 position-relative">
                                    <label class="form-label" for="profilePic">Twelth Certificate</label>
                                    <div>
                                        @if (!empty($employees->tenth))
                                            <p>Current File:
                                                <a href="{{ asset($employees->tenth) }}" target="_blank">View File</a>
                                            </p>
                                        @else
                                            <p>No file uploaded.</p>
                                        @endif
                                        <input type="file" name="tenth" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg"
                                            class="form-control">
                                        @if ($errors->has('tenth'))
                                            <div class="alert alert-danger mt-2">
                                                {{ $errors->first('tenth') }}
                                            </div>
                                        @endif
                            </div>
                            </div>
                          
                       

                            <div class="col-md-4 position-relative">
                                    <label class="form-label" for="profilePic">Copy of Adhaar</label>
                                    <div>
                                        @if (!empty($employees->copy_adhaar))
                                            <p>Current File:
                                                <a href="{{ asset($employees->copy_adhaar) }}" target="_blank">View File</a>
                                            </p>
                                        @else
                                            <p>No file uploaded.</p>
                                        @endif
                                        <input type="file" name="copy_adhaar" accept=".pdf,.doc,.docx,.png,.jpg,.jpeg"
                                            class="form-control">
                                        @if ($errors->has('copy_adhaar'))
                                            <div class="alert alert-danger mt-2">
                                                {{ $errors->first('copy_adhaar') }}
                                            </div>
                                        @endif
                            </div>
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
   

    <link href="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.min.css" rel="stylesheet" />
<script src="https://cdn.rawgit.com/harvesthq/chosen/gh-pages/chosen.jquery.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Chosen for the multi-select
        $('.chosen-select').chosen({
            placeholder_text_multiple: "Select roles", 
            no_results_text: "No roles found",      
            width: "100%"                           
        });
    });
</script>


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
