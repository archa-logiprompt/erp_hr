@extends('layouts.dashboard.app')
@section('content')
<div class="page-body">
    <div class="col-xl-12">
        <div class="card height-equal">
            <div class="card-header">
                <h4>Add Designation</h4>
                
            </div>
            <div class="card-body">
                <form class="" id="designationform" method="POST" action="{{route('admin.designation.store')}}" novalidate="">
                @csrf
                        <div class="col-6">
                            <label class="form-label" for="validationCustom01">Name</label><small
                                class="text-danger">*</small>
                            <input class="form-control" id="validationCustom01" type="text" name='name'
                                required="">
                            @if ($errors->has('name'))
                                <span class="text-danger">
                                    {{ $errors->first('name') }}
                                </span>
                            @endif
                        </div>

                        <div class="col-12 mt-5">
                            <button class="btn btn-primary" type="submit">Submit form</button>
                        </div>

                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('designationform');
        
        // Correct the event listener to trigger on form submission
        $('#form-submit-btn').on('click', function(e) {
            e.preventDefault(); // Prevent default form submit
            
            var formData = new FormData($('#designationform')[0]);
    
            // Make the AJAX request
            $.ajax({
                url: baseurl+"admin/designation/store", // Replace with your backend route
                
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
            $('#designationform').submit()
        });
    });
</script> 
    