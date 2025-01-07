@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Add Center</h4>

                </div>
                <div class="card-body">
                    <form method="POST" id="centerForms" action="{{ route('admin.center.store') }}" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">


                            <!-- name -->
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">Name*</label>
                                <input class="form-control @error('name') is-invalid @enderror" id="validationCustom01"
                                    type="text" name="name" value="{{ old('name') }}" placeholder="Center Name"
                                    required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- email -->

                            <div class="col-6">
                                <label class="form-label" for="exampleFormControlTextarea1"> Address*</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="exampleFormControlTextarea1" name="address"
                                    rows="3" required>{{ old('address') }}</textarea>
                                @if ($errors->has('address'))
                                    <div class="invalid-feedback" style="color: red;">
                                        {{ $errors->first('address') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-6">
                                <label class="form-label" for="validationCustom01"> Mobile Number*</label>
                                <input class="form-control @error('mobile') is-invalid @enderror" id="validationCustom01"
                                    value="{{ old('mobile') }}" type="number" name="mobile"
                                    placeholder="Enter your number" required>
                                @error('mobile')
                                    <div class="invalid-feedback" style="color: red;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label class="form-label" for="exampleFormControlInput1">Email*</label>
                                <input class="form-control @error('email') is-invalid @enderror"
                                    id="exampleFormControlInput1" type="email" placeholder="Enter your email"
                                    name="email" value="{{ old('email') }}" required="">

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row mt-3">
                                <!-- Image Upload -->
                                <div class="col-6">
                                    <label class="form-label" for="formFile">Upload Image*</label>
                                    <input type="file" name="image" accept="image/*"
                                        class="@error('image') is-invalid @enderror" required>
                                    @error('image')
                                        <div class="invalid-feedback" style="color: red;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <button class="btn btn-primary" type="button" id="form-submit-btn">Submit form</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", () => {
        // For input fields
        const formFields = document.querySelectorAll('.form-control');
        formFields.forEach(field => {
            field.addEventListener('input', () => {
                if (field.value.trim() !== "") {
                    const errorFeedback = field.parentElement.querySelector(
                        '.invalid-feedback');
                    if (errorFeedback) {
                        errorFeedback.style.display = 'none';
                    }
                    field.classList.remove('is-invalid');
                }
            });
        });

        // For select dropdowns
        const selectBoxes = document.querySelectorAll('select');
        selectBoxes.forEach(select => {
            select.addEventListener('change', () => {
                if (select.value) {
                    select.classList.remove('is-invalid');
                    const errorFeedback = select.parentElement.querySelector(
                        '.invalid-feedback');
                    if (errorFeedback) {
                        errorFeedback.style.display = 'none';
                    }

                    // Dynamically update the fees field
                    const selectedOption = select.options[select.selectedIndex];
                    const fee = selectedOption.getAttribute('data-fee');
                    const feesField = document.getElementById('validationCustomFees');

                    if (feesField) {
                        feesField.value = fee || '';
                        // Remove validation error from fees when updated
                        feesField.classList.remove('is-invalid');
                        const feesError = feesField.parentElement.querySelector(
                            '.invalid-feedback');
                        if (feesError) {
                            feesError.style.display = 'none';
                        }
                    }
                }
            });
        });
    });
</script>


<script>
    
 
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('centerForms');
        
        // Correct the event listener to trigger on form submission
        $('#form-submit-btn').on('click', function(e) {
            e.preventDefault(); // Prevent default form submit
            
            var formData = new FormData($('#centerForms')[0]);
            
            // Make the AJAX request
            $.ajax({
                // url: "http://127.0.0.1:8080/api/admin/newcenter/store", // Replace with your backend route
                
                url : baseurl+"admin/newcenter/store",

                type: 'POST',
                data: formData,
                processData: false, // Don't process the data (important for FormData)
                contentType: false, // Don't set content type (important for FormData)
                success: function(response) {
                    // Handle success response
                    if (response) {
                        alert('general data added successfully!');
                    } else {
                        alert('There was an error submitting the general data.');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.log('AJAX error:', error);
                    alert('There was an error processing the form.');
                }
            });
            $('#centerForms').submit()
        });
    });
</script> 
