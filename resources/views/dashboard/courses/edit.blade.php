@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Edit Course</h4>
                </div>
                <div class="card-body">
                    <form id="courseForms" method="POST" action="{{ route('admin.course.update', $coursedata->id) }}"
                        novalidate="">
                        @csrf

                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">Name</label>
                                <input class="form-control" id="validationCustom01" type="text" placeholder="Course Name"
                                    name="coursename" value="{{ $coursedata->coursename }}" required="">
                                @if ($errors->has('coursename'))
                                    <div class="alert alert-danger mt-2">{{ $errors->first('coursename') }}</div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">Fees(Including Gst)</label>
                                <input class="form-control" id="validationCustom01" type="number" placeholder="Course Fees"
                                    name="fee" value="{{ $coursedata->fee }}" required="">
                                @if ($errors->has('fee'))
                                    <div class="alert alert-danger mt-2">{{ $errors->first('fee') }}</div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">Duration in Months</label>
                                <input class="form-control" id="validationCustom01" type="number"
                                    placeholder="Course Duration" name="duration" value="{{ $coursedata->duration }}"
                                    required="">
                                @if ($errors->has('duration'))
                                    <div class="alert alert-danger mt-2">{{ $errors->first('duration') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-12 mt-5">
                            <button class="btn btn-primary" id="form-submit-btn" type="button">Update Course</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('courseForms');

        $('#form-submit-btn').on('click', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(form);
            const courseId = "{{ $coursedata->id }}"; // Laravel Blade to inject course ID
            const api8000Url =
            `/public/admin/courses/update/${courseId}`; // Web app URL (8000)
            const api8080Url =
            baseurl + "admin/newcourses/update/" + courseId; // API URL (8080)

            // First, update the course in the web database (8000)
            $.ajax({
                url: api8000Url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log("Updated in web app (8000):", response);

                    // If successful, now update the course in the second database via the API (8080)
                    $.ajax({
                        url: api8080Url,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log("Updated in API (8080):", response);
                            alert("Course updated!");
                            window.location.href =
                                `/public/admin/courses`; // Redirect after success
                        },
                        error: function(xhr) {
                            console.error("Error updating in API (8080):", xhr);
                            alert(
                                "Course updated in web database (8000) but failed in API (8080). Please check logs.");
                        }
                    });
                },
                error: function(xhr) {
                    console.error("Error updating in web app (8000):", xhr);
                    alert("Failed to update course in web app (8000). Please try again.");
                }
            });
        });
    });
</script>
