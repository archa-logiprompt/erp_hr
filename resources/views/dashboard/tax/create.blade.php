@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Add TAX</h4>
                </div>
                <div class="card-body">
                    <form method="POST" id="taxForm" action="{{ route('admin.tax.store') }}" novalidate="">
                        @csrf

                        <!-- Tax Name -->
                        <div class="col-5">
                            <label class="form-label" for="validationCustom01">Tax Name</label>
                            <input class="form-control" id="validationCustom01" type="text" name="taxname">
                            @if ($errors->has('taxname'))
                                <div class="alert alert-danger mt-2">
                                    {{ $errors->first('taxname') }}
                                </div>
                            @endif
                        </div>
                        <!-- subtitle -->
                        <div id="dynamic-fields">
                            <div class="row mb-2">
                                <div class="col-5">
                                    <label class="form-label" for="subtitle">Subtitle</label>
                                    <input class="form-control" type="text" name="subtitle[]"
                                        placeholder="Enter subtitle">
                                </div>
                                <div class="col-5">
                                    <label class="form-label" for="percentage">Percentage</label>
                                    <input class="form-control" type="number" name="percentage[]"
                                        placeholder="Enter percentage">
                                </div>

                                <div class="col-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-primary add-row">+</button>
                                </div>

                            </div>
                        </div>


                        <!-- Total Percentage Field -->
                        <div class="col-5 mt-3">
                            <label class="form-label" for="total_percentage">Total Percentage</label>
                            <input class="form-control" type="text" id="total_percentage" name="total" readonly>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 mt-5">
                            <button class="btn btn-primary" type="button" id="form-submit-btn">Submit form</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    {{-- <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
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
    </div>--}}
@endsection 

    {{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('taxForm');
        const successModal = new bootstrap.Modal(document.getElementById('successModal'), {
            backdrop: 'static', // Prevent closing by clicking outside the modal
            keyboard: false // Disable keyboard interaction
        });
        // Correct the event listener to trigger on form submission
        $('#form-submit-btn').on('click', function(e) {
            e.preventDefault(); // Prevent default form submit

            var formData = new FormData($('#taxForm')[0]);

            // Make the AJAX request
            $.ajax({
                url: baseurl + "admin/newtax/store",
                type: 'POST',
                data: formData,
                processData: false, // Don't process the data
                contentType: false, // Don't set content type
                success: function(response) {
                    // Show success modal
                    successModal.show();

                    // Automatically redirect to the view page after 3 seconds
                    setTimeout(function() {
                        window.location.href = "{{ route('admin.gst.index') }}";
                    }, 3000); // Redirect after 3 seconds (3000 milliseconds)
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.log('AJAX error:', error);
                    // alert('There was an error processing the form.');
                }
            });
            $('#taxForm').submit()
        });
    });
</script> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('taxForm');

            // Correct the event listener to trigger on form submission
            $('#form-submit-btn').on('click', function(e) {
                e.preventDefault(); // Prevent default form submit

                var formData = new FormData($('#taxForm')[0]);

                // Make the AJAX request
                $.ajax({
                    url: baseurl + "admin/newtax/store", // Replace with your backend route

                    // url : "{{ config('util.api') }}admin/newproject/store",

                    type: 'POST',
                    data: formData,
                    processData: false, // Don't process the data (important for FormData)
                    contentType: false, // Don't set content type (important for FormData)
                    success: function(response) {
                        // Handle success response
                        if (response) {
                            // alert('gst data added successfully!');
                        } else {
                            // alert('There was an error submitting the gst.');
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                        console.log('AJAX error:', error);
                        // alert('There was an error processing the form.');
                    }
                });
                $('#taxForm').submit()
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Get the dynamic fields container
            const dynamicFields = document.getElementById('dynamic-fields');
            const totalPercentageInput = document.getElementById('total_percentage');

            // Function to calculate the total percentage
            function calculateTotalPercentage() {
                let total = 0;
                // Get all percentage input values
                const percentageInputs = document.querySelectorAll('input[name="percentage[]"]');
                percentageInputs.forEach(input => {
                    const value = parseFloat(input.value);
                    if (!isNaN(value)) {
                        total += value;
                    }
                });
                // Update the total percentage field
                totalPercentageInput.value = total.toFixed(2);
            }

            // Event delegation for dynamically added buttons
            document.body.addEventListener('click', (event) => {
                // Check if "+" button is clicked
                if (event.target && event.target.classList.contains('add-row')) {
                    // Create a new row for subtitle and percentage
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
                    // Append the new row to the dynamic fields container
                    dynamicFields.appendChild(newRow);
                }

                // Check if "-" button is clicked
                if (event.target && event.target.classList.contains('remove-row')) {
                    // Remove the corresponding row
                    event.target.closest('.row').remove();
                }

                // Recalculate the total percentage after adding/removing rows
                calculateTotalPercentage();
            });

            // Event delegation for percentage inputs to update total
            document.body.addEventListener('input', (event) => {
                if (event.target && event.target.name === 'percentage[]') {
                    calculateTotalPercentage();
                }
            });
        });
    </script>
