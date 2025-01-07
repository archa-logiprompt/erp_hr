@extends('layouts.dashboard.app')
@section('content')
<div class="page-body">
    <div class="col-xl-12">
        <div class="card height-equal">
            <div class="card-header">
                <h4>Project Details</h4>
            </div>
            <div class="card-body">
                <form class="" id="projectForm" method="POST" action="{{ route('admin.project.store') }}"
                    novalidate="">
                    @csrf
                    <div class="row g-3">
                        <!-- short code -->
                        <div class="col-6">
                            <label class="form-label" for="validationCustom01">Short Code</label>
                            <input class="form-control @error('shortcode') is-invalid @enderror" id="validationCustom01"
                                type="text" placeholder="Short code" name="shortcode" value="{{ old('shortcode') }}"
                                >
                            @error('shortcode')
                            <div class="invalid-feedback"style="color: red;">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <!-- projectname -->
                        <div class="col-6">
                            <label class="form-label" for="validationCustom01">Project Name<span style="color: red;">*</span></label>
                            <input class="form-control @error('projectname') is-invalid @enderror"
                                id="validationCustom01"
                                type="text"
                                placeholder="Project Name"
                                name="projectname"
                                value="{{ old('projectname') }}"
                                required>
                            @error('projectname')
                            <div class="invalid-feedback"style="color: red;">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>



                        <!-- Start Date -->
                        <div class="col-6">
                            <label class="col-sm-3">Start Date<span style="color: red;">*</span></label>
                            <div class="col-sm-12">
                                <input class="form-control @error('startdate') is-invalid @enderror"
                                    id="example-datetime-local-input" type="datetime-local" name="startdate"
                                    value="{{ old('startdate', now()->format('Y-m-d\TH:i')) }}"
                                    min="{{ now()->format('Y-m-d\TH:i') }}">
                                @error('startdate')
                                <div class="invalid-feedback"style="color: red;">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Deadline -->
                        <div class="col-6">
                            <label class="col-sm-3">Deadline<span style="color: red;">*</span></label>
                            <div class="col-sm-12">
                                <input class="form-control @error('deadline') is-invalid @enderror" id="deadline"
                                    type="datetime-local" name="deadline" value="{{ old('deadline') }}"
                                    min="{{ now()->format('Y-m-d\TH:i') }}">
                                @error('deadline')
                                <div class="invalid-feedback"style="color: red;">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <!-- category -->
                        <div class="col-6">
                            <label class="form-label" for="validationDefaultCategory">Project Category<span style="color: red;">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror"
                                id="validationDefaultCategory" name="category" required
                                onchange="clearValidationMessage(this)">
                                <option selected disabled value="">Choose...</option>
                                @foreach (config('global.Category') as $category)
                                <option value="{{ $category }}"
                                    {{ old('category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                                @endforeach
                            </select>
                            @error('category')
                            <div class="invalid-feedback"style="color: red;">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- department -->
                        <div class="col-6">
                            <label class="form-label" for="validationDefaultDepartment">Departments<span style="color: red;">*</span></label>
                            <select class="form-select @error('department') is-invalid @enderror"
                                id="validationDefaultDepartment" name="department" required
                                onchange="clearValidationMessage(this)">
                                <option selected disabled value="">Choose...</option>
                                @foreach (config('global.Departments') as $department)
                                <option value="{{ $department }}"
                                    {{ old('department') == $department ? 'selected' : '' }}>
                                    {{ $department }}
                                </option>
                                @endforeach
                            </select>
                            @error('department')
                            <div class="invalid-feedback"style="color: red;">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- client -->
                        <div class="col-6">
                            <label class="form-label" for="validationClient">Company Name<span style="color: red;">*</span></label>
                            <select class="form-select @error('client') is-invalid @enderror" id="validationClient"
                                name="client" required onchange="clearValidationMessage(this)">
                                <option selected disabled value="">Choose...</option>
                                <!-- <option value="1" {{ old('client') == 1 ? 'selected' : '' }}>Client 1</option>
                                                <option value="2" {{ old('client') == 2 ? 'selected' : '' }}>Client 2</option>
                                                <option value="3" {{ old('client') == 3 ? 'selected' : '' }}>Client 3</option>
                                                <option value="4" {{ old('client') == 4 ? 'selected' : '' }}>Client 4</option> -->
                                <!-- Uncomment when using dynamic data -->
                                <!-- @foreach ($clientdetail as $client)
    <option value="{{ $client->id }}" {{ old('client') == $client->id ? 'selected' : '' }}>
                                                        {{ $client->name }}
                                                    </option>
    @endforeach -->
                                @foreach ($clientdetail as $client)
                                <option value="{{ $client->id }}">{{ $client->companyName }}</option>
                                @endforeach
                            </select>
                            @error('client')
                            <div class="invalid-feedback"style="color: red;">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- projectfee -->
                        <div class="col-6">
                            <label class="form-label" for="validationCustom01">Project Fee With Gst<span style="color: red;">*</span></label>
                            <input class="form-control @error('projectname') is-invalid @enderror"
                                id="validationCustom01" type="number" placeholder="Amount" name="projectfee"
                                value="{{ old('projectfee') }}" required>
                            @error('projectfee')
                            <div class="invalid-feedback"style="color: red;">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>


                        <!-- Notes -->
                        <div class="col-6">
                            <label class="form-label" for="notesTextarea">Notes<span style="color: red;">*</span></label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notesTextarea" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                            <div class="invalid-feedback"style="color: red;">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- summary -->

                      <div class="col-12">
    <label class="form-label" for="summaryTextarea">Project Summary<span style="color: red;">*</span></label>
    <textarea class="form-control @error('summary') is-invalid @enderror" id="summaryTextarea" name="summary"
        rows="3">{{ old('summary') }}</textarea>
    @error('summary')
    <div class="invalid-feedback" >
        {{ $message }}
    </div>
    @enderror
</div>




                        <!-- <div class="col-12">
                                                                        <label for="editor">Notes</label>
                                                                        <div class="toolbar-box">

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
                                                                            </div>
                                                                            <div class="col-md-12 position-relative editor-container">

                                                                                <textarea id="editor" name="notes" class="form-control" rows="10"></textarea>
                                                                                @if ($errors->has('notes'))
    <div class="alert alert-danger mt-2">
                                                                                        {{ $errors->first('notes') }}
                                                                                    </div>
    @endif
                                                                            </div>
                                                                        </div>
                                                                    </div> -->
                        <div class="col-12 mt-5">
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
        const form = document.getElementById('projectForm');

        // Correct the event listener to trigger on form submission
        $('#form-submit-btn').on('click', function(e) {
            e.preventDefault(); // Prevent default form submit

            var formData = new FormData($('#projectForm')[0]);

            // Make the AJAX request
            $.ajax({
                url: baseurl + "admin/newproject/store", // Replace with your backend route

                // url : "{{ config('util.api') }}admin/newproject/store",

                type: 'POST',
                data: formData,
                processData: false, // Don't process the data (important for FormData)
                contentType: false, // Don't set content type (important for FormData)
                success: function(response) {
                    // Handle success response
                    if (response) {
                        alert('gst data added successfully!');
                    } else {
                        alert('There was an error submitting the gst.');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.log('AJAX error:', error);
                    alert('There was an error processing the form.');
                }
            });
            $('#projectForm').submit()
        });
    });
</script>