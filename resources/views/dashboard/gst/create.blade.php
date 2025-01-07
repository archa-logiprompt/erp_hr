@extends('layouts.dashboard.app')
@section('content')
<div class="page-body">
    <div class="col-xl-12">
        <div class="card height-equal">
            <div class="card-header">
                <h4>Add GST</h4>
            </div>
            <div class="card-body">
                <form class="" id="gstForm" method="POST" action="{{route('admin.gst.store')}}" novalidate="">
                    @csrf
                    <div class="col-6">
                        <label class="form-label" for="validationCustom01">Gst Value</label>
                        <input class="form-control" id="validationCustom01" type="number" name="gstvalue" required="">
                        @if ($errors->has('gstvalue'))
                        <div class="alert alert-danger mt-2">
                            {{ $errors->first('gstvalue') }}
                        </div>
                        @endif
                    </div>

                    <div class="col-12 mt-5">
                        <button class="btn btn-primary" type="button" id="form-submit-btn">Submit form</button>
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
                GST data added successfully! Redirecting to the view page...
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('gstForm');
        const successModal = new bootstrap.Modal(document.getElementById('successModal'), {
            backdrop: 'static', // Prevent closing by clicking outside the modal
            keyboard: false // Disable keyboard interaction
        });

        $('#form-submit-btn').on('click', function (e) {
            e.preventDefault(); // Prevent default form submission

            const formData = new FormData(form);

            // Make the AJAX request
            $.ajax({
                url: "{{ route('admin.gst.store') }}", // Replace with your backend route
                type: 'POST',
                data: formData,
                processData: false, // Don't process the data
                contentType: false, // Don't set content type
                success: function (response) {
                    // Show success modal
                    successModal.show();

                    // Automatically redirect to the view page after 3 seconds
                    setTimeout(function () {
                        window.location.href = "{{ route('admin.gst.index') }}";
                    }, 2000); // Redirect after 3 seconds (3000 milliseconds)
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.error('AJAX error:', error);
                    alert('There was an error processing the form. Please try again.');
                }
            });
        });
    });
</script>
