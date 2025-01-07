@extends('layouts.dashboard.app')
@section('content')
<div class="page-body">
    <div class="col-xl-12">
        <div class="card height-equal">
            <div class="card-header">
                <h4>Add Course</h4>
                
            </div>
            <div class="card-body">
                <form class="" id="courseForms" method="POST" action="{{route('admin.course.store')}}" novalidate="">
                    @csrf
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label" for="validationCustom01">Name</label>
                            <input class="form-control" id="validationCustom01" type="text" placeholder="Course Name"
                                name='coursename' required="">
                            @if ($errors->has('coursename'))
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first('coursename') }}
                            </div>
                            @endif
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="validationCustom01">Fees(Including Gst)</label>
                            <input class="form-control" id="validationCustom01" type="number" placeholder="Course Fees"
                                name='fee' required="">
                            @if ($errors->has('fee'))
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first('fee') }}
                            </div>
                            @endif
                        </div>
                        <div class="col-6">
                            <label class="form-label" for="validationCustom01">Duration in Months</label>
                            <input class="form-control" id="validationCustom01" type="number" placeholder="Course Duration"
                                name='duration' required="">
                            @if ($errors->has('duration'))
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first('duration') }}
                            </div>
                            @endif
                        </div>

                    </div>

                    <div class="col-12 mt-5">
                        <button class="btn btn-primary" id="form-submit-btn" type="button">Submit form</button>
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
        
        // Correct the event listener to trigger on form submission
        $('#form-submit-btn').on('click', function(e) {
            e.preventDefault(); // Prevent default form submit
            
            var formData = new FormData($('#courseForms')[0]);
    
            // Make the AJAX request
            $.ajax({
                url: baseurl+"admin/newcourses/store", // Replace with your backend route
                
                // url : "{{config('util.api') }}admin/newcourses/store",

                type: 'POST',
                data: formData,
                processData: false, // Don't process the data (important for FormData)
                contentType: false, // Don't set content type (important for FormData)
                success: function(response) {
                    // Handle success response
                    if (response) {
                        // alert('general data added successfully!');
                    } else {
                        // alert('There was an error submitting the general data.');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.log('AJAX error:', error);
                    // alert('There was an error processing the form.');
                }
            });
            $('#courseForms').submit()
        });
    });
</script> 
    