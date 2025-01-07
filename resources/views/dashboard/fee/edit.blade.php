@extends('layouts.dashboard.app')

@section('content')
<div class="page-body">
    <div class="col-xl-12">
        <div class="card height-equal">
            <div class="card-header">
                <h4>Edit Fee</h4>
            </div>
            <div class="card-body">
                <form method="POST" id="feesForms" action="{{ url('admin/fee/update', $feedata->id) }}" novalidate="">
                    @csrf
                    @method('PUT') <!-- Add PUT method for updating -->
                    
                    <!-- Title -->
                    <div class="col-5">
                        <label class="form-label" for="validationCustom01">Title</label>
                        <input class="form-control" id="validationCustom01" type="text" name="title" value="{{ old('title', $feedata->title) }}">
                        @if ($errors->has('title'))
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first('title') }}
                            </div>
                        @endif
                    </div>

                    <!-- Dynamic Fields -->
                    <div id="dynamic-fields">
                        @foreach($feedata->subtitle as $index => $subtitle)
                            <div class="row mb-2 field-row">
                                <div class="col-4">
                                    <label class="form-label" for="subtitle">Subtitle</label>
                                    <input class="form-control" type="text" name="subtitle[]" value="{{ $subtitle }}" placeholder="Enter subtitle">
                                </div>
                                <div class="col-4">
                                    <label class="form-label" for="splitup">Splitup</label>
                                    <input class="form-control" type="number" step="0.01" name="splitup[]" value="{{ $feedata->splitup[$index] }}" placeholder="Enter percentage (e.g., 30)">
                                </div>
                                <div class="col-4">
                                    <label class="form-label" for="taxes">Taxes</label>
                                    <select class="form-select @error('taxes') is-invalid @enderror" name="taxes[{{ $index }}][]" multiple>
                                        <option selected disabled value="">Choose...</option>
                                        @foreach($taxes as $tax)
                                            <option value="{{ $tax->id }}" 
                                                @if(is_array($feedata->taxes[$index]) && in_array($tax->id, $feedata->taxes[$index])) selected @endif>
                                                {{ $tax->taxname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    </div> 

                    <div class="col-12 mt-5">
                        <button class="btn btn-primary" type="button" id="form-submit-btn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Success or Error Messages -->
<div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="responseModalLabel">Response</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-message">
                <!-- Success/Error message will be injected here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('feesForms');

    $('#form-submit-btn').on('click', function(e) {
        e.preventDefault();

        // Get form data
        const formData = new FormData(form);
        const feeId = "{{ $feedata->id }}"; // Laravel Blade to inject fee ID
        const api8000Url = `/public/admin/fee/update/${feeId}`; // Web app URL (8000)
        const api8080Url = baseurl + "admin/newfee/update/" + feeId; // API URL (8080)

        // First, update the fee in the web database (8000)
        $.ajax({
            url: api8000Url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log("Updated in web app (8000):", response);

                // If successful, now update the fee in the second database via the API (8080)
                $.ajax({
                    url: api8080Url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log("Updated in API (8080):", response);
                        $('#modal-message').text("Fee updated successfully!");
                        $('#responseModal').modal('show'); // Show success modal
                        window.location.href = `/public/admin/fee`; // Redirect after success
                    },
                    error: function(xhr) {
                        console.error("Error updating in API (8080):", xhr);
                        $('#modal-message').text("Fee updated in web database (8000) but failed in API (8080). Please check logs.");
                        $('#responseModal').modal('show'); // Show error modal
                    }
                });
            },
            error: function(xhr) {
                console.error("Error updating in web app (8000):", xhr);
                $('#modal-message').text("Failed to update fee in web app (8000). Please try again.");
                $('#responseModal').modal('show'); // Show error modal
            }
        });
    });
});
</script>

@endsection
