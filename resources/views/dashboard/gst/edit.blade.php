@extends('layouts.dashboard.app')
@section('content')
 
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Gst update</h4>
                  
                </div>
                <div class="card-body">
                    <form class="" id="gstForms" method="POST" action="{{url('admin/gst/update',$gstdata->id)}}" novalidate="">
                        @csrf
                        <div class="row g-3">
                            
                            <div class="col-6 mb-3">
                                <label class="form-label" for="validationCustom01">Gst Value</label>
                                <input class="form-control" id="validationCustom01" type="number" value="{{$gstdata->gstvalue}}" 
                                    name='gstvalue' required="">

                                    @if ($errors->has('gstvalue'))
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first('gstvalue') }}
                            </div>
                            @endif
                            </div>
                           
                            
                        </div>

                        <div class="col-12">
                            <button class="btn btn-primary" type="button" id="form-submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
     <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                </div>
                <div class="modal-body">
                    gst updated successfully! Redirecting to the view page...
                </div>
            </div>        
        </div>
    </div>
@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('gstForms');
 const successModal = new bootstrap.Modal(document.getElementById('successModal'), {});
        $('#form-submit-btn').on('click', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(form);
            const gstId = "{{ $gstdata->id }}"; // Laravel Blade to inject course ID
            const api8000Url =
            `/public/admin/gst/update/${gstId}`; // Web app URL (8000)
            const api8080Url =
            baseurl+"admin/newgst/update/"+gstId; // API URL (8080)

            // First, update the gst in the web database (8000)
            $.ajax({
                url: api8000Url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log("Updated in web app (8000):", response);

                    // If successful, now update the gst in the second database via the API (8080)
                    $.ajax({
                            url: api8080Url,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                console.log("Updated in API (8080):", response);

                                // Show success modal
                                successModal.show();

                                // Automatically redirect to the view page after 3 seconds
                                setTimeout(function () {
                                    window.location.href = "/public/admin/gst"; // Redirect after success
                                }, 2000); // Redirect after 3 seconds (3000 milliseconds)
                            },
                        error: function(xhr) {
                            console.error("Error updating in API (8080):", xhr);
                            alert(
                                "gst updated in web database (8000) but failed in API (8080). Please check logs.");
                        }
                    });
                },
                error: function(xhr) {
                    console.error("Error updating in web app (8000):", xhr);
                    alert("Failed to update gst in web app (8000). Please try again.");
                }
            });
        });
    });
</script>