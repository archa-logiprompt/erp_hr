@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Edit TAX</h4>
                </div>
                <div class="card-body">
                    <form method="POST" id="taxForms" action="{{ url('admin/tax/update', $taxdata->id) }}" novalidate="">
                        @csrf
                        @method('PUT') <!-- Add PUT method for updating -->

                        <!-- Tax Name -->
                        <div class="col-6">
                            <label class="form-label" for="taxname">Tax Name</label>
                            <input class="form-control" id="taxname" type="text" name="taxname"
                                value="{{ old('taxname', $taxdata->taxname) }}">
                            @if ($errors->has('taxname'))
                                <div class="alert alert-danger mt-2">
                                    {{ $errors->first('taxname') }}
                                </div>
                            @endif
                        </div>

                        <!-- Subtitle and Percentage fields (Dynamic) -->
                        <div id="dynamic-fields">
                            @foreach ($taxdata->subtitle as $index => $subtitle)
                                <div class="row mb-2">
                                    <div class="col-5">
                                        <label class="form-label" for="subtitle">Subtitle</label>
                                        <input class="form-control" type="text" name="subtitle[]"
                                            value="{{ $subtitle }}" placeholder="Enter subtitle">
                                    </div>
                                    <div class="col-5">
                                        <label class="form-label" for="percentage">Percentage</label>
                                        <input class="form-control percentage-input" type="text" name="percentage[]"
                                            value="{{ $taxdata->percentage[$index] ?? '' }}" placeholder="Enter percentage">
                                    </div>
                                    <div class="col-2 d-flex align-items-end">
                                        <button type="button" class="btn btn-danger remove-row">-</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Add Row Button -->
                        <div class="col-12 d-flex align-items-end">
                            <button type="button" class="btn btn-primary add-row">+</button>
                        </div>

                        <!-- Total Percentage Field -->
                        <div class="col-12 mt-3">
                            <label class="form-label" for="total_percentage">Total Percentage</label>
                            <input class="form-control" type="text" id="total_percentage" readonly
                                value="{{ is_array($taxdata->percentage) ? collect($taxdata->percentage)->sum() : 0 }}">
                        </div>

                        <div class="col-12 mt-5">
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
                   Tax updated successfully! Redirecting to the view page...
                </div>
            </div>
        </div>
    </div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dynamicFields = document.getElementById('dynamic-fields');
        const totalPercentageField = document.getElementById('total_percentage');

        // Function to calculate the total percentage
        function calculateTotalPercentage() {
            let total = 0;
            // Get all the percentage inputs and sum their values
            const percentageInputs = document.querySelectorAll('.percentage-input');
            percentageInputs.forEach(function(input) {
                total += parseFloat(input.value) || 0; // Add the percentage value or 0 if not a valid number
            });
            // Update the total percentage field
            totalPercentageField.value = total;
        }

        // Event listener for adding rows
        document.querySelector('.add-row').addEventListener('click', function() {
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'mb-2');
            newRow.innerHTML = `
                    <div class="col-5">
                        <input class="form-control" type="text" name="subtitle[]" placeholder="Enter subtitle">
                    </div>
                    <div class="col-5">
                        <input class="form-control percentage-input" type="text" name="percentage[]" placeholder="Enter percentage">
                    </div>
                    <div class="col-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-row">-</button>
                    </div>
                `;
            dynamicFields.appendChild(newRow);

            // Recalculate total percentage whenever a new row is added
            calculateTotalPercentage();
        });

        // Event listener for removing rows
        dynamicFields.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('remove-row')) {
                event.target.closest('.row').remove();
                // Recalculate total percentage after removing a row
                calculateTotalPercentage();
            }
        });

        // Event listener for percentage input change
        dynamicFields.addEventListener('input', function(event) {
            if (event.target && event.target.classList.contains('percentage-input')) {
                // Recalculate total percentage when percentage input changes
                calculateTotalPercentage();
            }
        });

        // Initial calculation of total percentage when the page loads
        calculateTotalPercentage();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('taxForms');
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));

        $('#form-submit-btn').on('click', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(form);
            const taxId = "{{ $taxdata->id }}"; // Laravel Blade to inject tax ID
           const api8000Url = `/public/admin/tax/update/${taxId}`;  // Use the correct update route

            const api8080Url = baseurl + "admin/newtax/update/" + taxId; // API URL (8080)

            // First, update the tax in the web database (8000)
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
                    type: 'PUT',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log("Updated in API (8080):", response);
                        $('#modal-message').text("Tax updated successfully!");
                        $('#responseModal').modal('show'); // Show success modal
                        window.location.href = `/public/admin/tax`; // Redirect after success
                    },
                    error: function(xhr) {
                        console.error("Error updating in API (8080):", xhr);
                        $('#modal-message').text("Tax updated in web database (8000) but failed in API (8080). Please check logs.");
                        $('#responseModal').modal('show'); // Show error modal
                    }
                });
            },
                error: function(xhr) {
                    console.error("Error updating in web app (8000):", xhr);
                    alert("Failed to update tax in web app (8000). Please try again.");
                }
            });
        });
    });
</script>
