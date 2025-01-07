@extends('layouts.dashboard.app')
@section('content')
<div class="page-body">
    <div class="col-xl-12">
        <div class="card height-equal">
            <div class="card-header">
                <h4>Edit Project Details</h4>
            </div>
            <div class="card-body">
                <form method="POST" id="projectForms" action="{{ url('admin/project/update', $projectdata->id) }}" novalidate>
                    @csrf
                    <div class="row g-3">
                        <!-- Short Code -->
                        <div class="col-6">
                            <label class="form-label" for="shortcode">Short Code</label>
                            <input class="form-control @error('shortcode') is-invalid @enderror" id="shortcode"
                                type="text" name="shortcode" placeholder="Short code"
                                value="{{ old('shortcode', $projectdata->shortcode) }}" required>
                            @error('shortcode')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Project Name -->
                        <div class="col-6">
                            <label class="form-label" for="projectname">Project Name<span style="color: red;">*</span></label>
                            <input class="form-control @error('projectname') is-invalid @enderror" id="projectname"
                                type="text" name="projectname" placeholder="Project Name"
                                value="{{ old('projectname', $projectdata->projectname) }}" required>
                            @error('projectname')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Start Date -->
                        <div class="col-6">
                            <label class="form-label" for="startdate">Start Date<span style="color: red;">*</span></label>
                            <input class="form-control @error('startdate') is-invalid @enderror" id="startdate"
                                type="datetime-local" name="startdate"
                                value="{{ old('startdate', \Carbon\Carbon::parse($projectdata->startdate)->format('Y-m-d\TH:i')) }}"
                                min="{{ now()->format('Y-m-d\TH:i') }}" required>
                            @error('startdate')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deadline -->
                        <div class="col-6">
                            <label class="form-label" for="deadline">Deadline<span style="color: red;">*</span></label>
                            <input class="form-control @error('deadline') is-invalid @enderror" id="deadline"
                                type="datetime-local" name="deadline"
                                value="{{ old('deadline', \Carbon\Carbon::parse($projectdata->deadline)->format('Y-m-d\TH:i')) }}"
                                min="{{ now()->format('Y-m-d\TH:i') }}" required>
                            @error('deadline')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Project Category -->
                        <div class="col-6">
                            <label class="form-label" for="category">Project Category<span style="color: red;">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category"
                                name="category" required>
                                <option disabled value="">Choose...</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category }}"
                                    {{ old('category', $projectdata->category) === $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                                @endforeach
                            </select>
                            @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Departments -->
                        <div class="col-6">
                            <label class="form-label" for="department">Departments<span style="color: red;">*</span></label>
                            <select class="form-select @error('department') is-invalid @enderror" id="department"
                                name="department" required>
                                <option disabled value="">Choose...</option>
                                @foreach ($departments as $department)
                                <option value="{{ $department }}"
                                    {{ old('department', $projectdata->department) === $department ? 'selected' : '' }}>
                                    {{ $department }}
                                </option>
                                @endforeach
                            </select>
                            @error('department')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Client -->
                        <div class="col-6">
                            <label class="form-label" for="validationClient">Client Name<span style="color: red;">*</span></label>
                            <select class="form-select" id="validationClient" name="client" required>
                                <option disabled value="">Choose...</option>
                                @foreach ($clients as $client)
                                <option value="{{ $client->id }}"
                                 {{ old('client', $projectdata->client) == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>

                                @endforeach
                            </select>
                            @if ($errors->has('client'))
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first('client') }}
                            </div>
                            @endif
                        </div>

                        <!-- projectfee -->
                        <div class="col-6">
                            <label class="form-label" for="validationCustom01">Project Fee With Gst<span style="color: red;">*</span></label>
                            <input class="form-control @error('projectname') is-invalid @enderror"
                                id="validationCustom01" type="number" placeholder="Amount" name="projectfee"
                                value="{{ old('projectfee', $projectdata->projectfee) }}" required>

                            @error('projectfee')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <!-- Project Summary -->
                        <div class="col-6">
                            <label class="form-label" for="summary">Project Summary<span style="color: red;">*</span></label>
                            <textarea class="form-control @error('summary') is-invalid @enderror" id="summary" name="summary" rows="3"
                                required>{{ old('summary', $projectdata->summary) }}</textarea>
                            @error('summary')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="col-6">
                            <label class="form-label" for="notes">Notes<span style="color: red;">*</span></label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $projectdata->notes) }}</textarea>
                            @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 mt-5">
                            <button class="btn btn-primary" type="button" id="form-submit-btn">Submit Form</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('projectForms');

        $('#form-submit-btn').on('click', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(form);
            const projectId = "{{ $projectdata->id }}"; // Laravel Blade to inject course ID
            const api8000Url = `/public/admin/project/update/${projectId}`;

            const api8080Url =
                baseurl + "admin/newproject/update/" + projectId; // API URL (8080)

            // First, update the project in the web database (8000)
            $.ajax({
                url: api8000Url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log("Updated in web app (8000):", response);

                    // If successful, now update the project in the second database via the API (8080)
                    $.ajax({
                        url: api8080Url,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log("Updated in API (8080):", response);
                            alert("project updated !");
                            window.location.href =
                                `/public/admin/project`; // Redirect after success
                        },
                        error: function(xhr) {
                            console.error("Error updating in API (8080):", xhr);
                            alert(
                                "project updated in web database (8000) but failed in API (8080). Please check logs.");
                        }
                    });
                },
                error: function(xhr) {
                    console.error("Error updating in web app (8000):", xhr);
                    alert("Failed to update project in web app (8000). Please try again.");
                }
            });
        });
    });
</script>