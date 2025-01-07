@extends('layouts.dashboard.app')

@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Add Fee</h4>
                </div>
                <div class="card-body">
                    <form method="POST" id="feesForm" action="{{ route('admin.fee.store') }}" novalidate="">
                        @csrf

                        <!-- Title -->
                        <div class="col-5">
                            <label class="form-label" for="validationCustom01">Title</label>
                            <input class="form-control" id="validationCustom01" type="text" name="title">
                            @if ($errors->has('title'))
                                <div class="alert alert-danger mt-2">
                                    {{ $errors->first('title') }}
                                </div>
                            @endif
                        </div>

                        <!-- Dynamic Fields -->
                        <!-- Dynamic Fields -->
                        <div id="dynamic-fields">
                            <div class="row mb-2 field-row">
                                <div class="col-4">
                                    <label class="form-label" for="subtitle">Subtitle</label>
                                    <input class="form-control" type="text" name="subtitle[]"
                                        placeholder="Enter subtitle">
                                </div>
                                <div class="col-4">
                                    <label class="form-label" for="splitup">Splitup</label>
                                    <input class="form-control" type="number" step="0.01" name="splitup[]"
                                        placeholder="Enter percentage (e.g., 30)">
                                </div>
                                <div class="col-4">
                                    <label class="form-label" for="taxes">Taxes</label>
                                    <select class="form-select" name="taxes[0][]" multiple>
                                        <option selected disabled value="">Choose...</option>
                                        @foreach ($taxes as $tax)
                                            <option value="{{ $tax->id }}">{{ $tax->taxname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 text-end mt-2">
                                    <button type="button" class="btn btn-primary add-row">+</button>
                                </div>
                            </div>
                        </div>


                        <!-- Submit Button -->
                        <div class="col-12 mt-5">
                            <button class="btn btn-primary"  id="form-submit-btn" type="button">Submit form</button>
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
                Fee data added successfully! Redirecting to the view page...
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('feesForm');
         const successModal = new bootstrap.Modal(document.getElementById('successModal'), {});
        // Correct the event listener to trigger on form submission
        $('#form-submit-btn').on('click', function(e) {
            e.preventDefault(); // Prevent default form submit
            
            var formData = new FormData($('#feesForm')[0]);
    
            // Make the AJAX request
          $.ajax({
               url: baseurl+"admin/newfee/store", // Replace with your backend route
                type: 'POST',
                data: formData,
                processData: false, // Don't process the data
                contentType: false, // Don't set content type
                success: function (response) {
                    // Show success modal
                    successModal.show();

                    // Automatically redirect to the view page after 3 seconds
                    setTimeout(function () {
                        window.location.href = "{{ route('admin.fee.index') }}";
                    }, 4000); // Redirect after 3 seconds (3000 milliseconds)
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.log('AJAX error:', error);
                    alert('There was an error processing the form.');
                }
            });
            $('#feesForm').submit()
        });
    });
</script> 


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal Initialization
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));

        // Dynamic Fields Logic
        const dynamicFields = document.getElementById('dynamic-fields');
        dynamicFields.addEventListener('click', (event) => {
            if (event.target.classList.contains('add-row')) {
                const row = event.target.closest('.field-row');
                const newRow = row.cloneNode(true);

                // Clear input values
                newRow.querySelectorAll('input, select').forEach((input) => {
                    input.value = '';
                    if (input.tagName === 'SELECT') {
                        input.selectedIndex = 0;
                    }
                });

                // Update name attributes for taxes
                const rowIndex = dynamicFields.querySelectorAll('.field-row').length;
                newRow.querySelector('select[name^="taxes"]').name = `taxes[${rowIndex}][]`;

                // Add remove button
                const removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-danger remove-row';
                removeButton.textContent = '-';
                newRow.querySelector('.col-12').insertBefore(removeButton, newRow.querySelector('.add-row'));

                dynamicFields.appendChild(newRow);
            }

            if (event.target.classList.contains('remove-row')) {
                event.target.closest('.field-row').remove();
            }
        });

        // Form Submission Logic
        $('#form-submit-btn').on('click', function (e) {
            e.preventDefault(); // Prevent default form submission

            const formData = new FormData($('#feesForm')[0]);

            $.ajax({
                url: "{{ route('admin.fee.store') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    // Show success modal
                    successModal.show();

                    // Redirect after a few seconds
                    setTimeout(function () {
                        window.location.href = "{{ route('admin.fee.index') }}";
                    }, 3000);
                },
                error: function (xhr, status, error) {
                    console.error('AJAX error:', error);
                    alert('There was an error processing the form.');
                }
            });
        });
    });
</script>
@endpush

