@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>General settings form</h4>
                </div>
                <div class="card-body">
                    <form id="generalForm" method="POST" action="{{ route('admin.generalsettings.store') }}" novalidate="">
                        @csrf
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">Prefix *</label>
                                <input class="form-control" id="validationCustom01" type="text" placeholder=""
                                    name="prefix" required="">
                                @if ($errors->has('prefix'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('prefix') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">Starting number</label>
                                <input class="form-control" id="validationCustom01" type="text" placeholder=""
                                    name="startingNo">
                                @if ($errors->has('startingNo'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('startingNo') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 mt-5">
                            <button class="btn btn-primary" id="form-submit-btn" type="submit">Submit form</button>
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
                    General data added successfully! Redirecting to the view page...
                </div>
            </div>
        </div>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const successModal = new bootstrap.Modal(document.getElementById('successModal'), {});

        $('#form-submit-btn').on('click', function (e) {
            e.preventDefault(); // Prevent default form submission

            const formData = new FormData($('#generalForm')[0]);

            // Make the AJAX request
            $.ajax({
                url: "{{ route('admin.generalsettings.store') }}", // Replace with your backend route
                type: 'POST',
                data: formData,
                processData: false, // Don't process the data
                contentType: false, // Don't set content type
                success: function (response) {
                    // Show success modal
                    successModal.show();

                    // Automatically redirect to the view page after 3 seconds
                    setTimeout(function () {
                        window.location.href = "{{ route('admin.generalsettings.index') }}";
                    }, 2000); // Redirect after 3 seconds (3000 milliseconds)
                },
                error: function (xhr, status, error) {
                    // Handle error response
                    console.log('AJAX error:', error);
                    alert('There was an error processing the form.');
                }
            });
        });
    });
</script>

@endsection
