@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Add Fee Details</h4>
                </div>
                <div class="card-body">

                    <form class="" id="invoiceForm" method="POST" action="{{ route('admin.studentinvoice.store') }}"
                        novalidate="">
                        @csrf
                        <div class="row g-3">
                             <!-- Center Field -->
                             <div class="col-6 position-relative">
                                <label class="form-label" for="center">Center</label>
                                <select class="form-select" name="center">
                                    <option selected disabled value="">...</option>
                                    @foreach ($centerdetails as $center)
                                        <option value="{{ $center->id }}"
                                            {{ old('center', 'default_value') == $center->id || $center->name == 'Logiprompt ProAcademy' ? 'selected' : '' }}>
                                            {{ $center->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('center'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('center') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Search Student -->
                            <!--<div class="col-6">-->
                            <!--    <label class="form-label" for="studentSelect">Search Student<span style="color: red;">*</span></label>-->
                            <!--    <select class="form-select @error('student_id') is-invalid @enderror" id="studentSelect"-->
                            <!--        name="student_id" required>-->
                            <!--        <option selected disabled value="">Choose...</option>-->
                            <!--        @foreach ($students as $student)-->
                            <!--            <option value="{{ $student->id }}" data-admission="{{ $student->admissionnumber }}"-->
                            <!--                data-course="{{ $student->course->coursename ?? '' }}"-->
                            <!--                data-balancefee="{{ $student->balancefee ?? '' }}"-->
                            <!--                data-fees="{{ $student->course->fee ?? 0 }}"-->
                            <!--                {{ old('student_id') == $student->id ? 'selected' : '' }}>-->
                            <!--                {{ $student->studentname }}-->
                            <!--            </option>-->
                            <!--        @endforeach-->
                            <!--    </select>-->

                            <!--    @error('student_id')-->
                            <!--        <div class="invalid-feedback">-->
                            <!--            {{ $message }}-->
                            <!--        </div>-->
                            <!--    @enderror-->
                            <!--</div>-->
                            
                            <div class="col-6">
    <label class="form-label" for="studentSelect">Search Student<span style="color: red;">*</span></label>
   <select class="form-select" id="studentSelect" name="student_id" required>
   
    @foreach ($students as $student)
        <option value="{{ $student->id }}" 
            data-admission="{{ $student->admissionnumber }}"
            data-course="{{ $student->course->coursename ?? '' }}"
            data-balancefee="{{ $student->balancefee ?? '' }}"
            data-fees="{{ $student->course->fee ?? 0 }}"
            {{ old('student_id') == $student->id ? 'selected' : '' }}>
            {{ $student->studentname }}
        </option>
    @endforeach
</select>



    @error('student_id')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
                            <!-- Admission Number -->
                            <div class="col-6">
                                <label class="form-label" for="admissionNo">Admission Number<span style="color: red;">*</span></label>
                                <input class="form-control" id="admissionNo" type="text" name="admissionno"
                                    placeholder="Admission number" value="{{ old('admissionno') }}" readonly>

                            </div>

                            <!-- Course -->
                            <div class="col-6">
                                <label class="form-label" for="courseName">Course<span style="color: red;">*</span></label>
                                <input class="form-control" id="courseName" type="text" name="course_id"
                                    placeholder="Course Name" value="{{ old('course_id') }}" readonly>
                            </div>

                            <!-- Fees -->
                            <div class="col-6">
                                <label class="form-label" for="courseFees">Fees<span style="color: red;">*</span></label>
                                <input class="form-control" id="courseFees" type="text" name="fees"
                                    placeholder="Course Fees" value="{{ old('fees') }}" readonly>
                            </div>
                            <!-- balanceamount -->
                            <tr>
                                <td><label for="balanceamount" class="form-label">Balance Amount</label></td>
                                <td>
                                    <input type="number" class="form-control @error('balanceamount') is-invalid @enderror"
                                        id="balanceamount" name="balanceamount" value="{{ old('balanceamount') }}"
                                        value="0" readonly>
                                </td>
                            </tr>

                            <div class="col-md-4 position-relative" hidden>
                                <input class="form-control" id="nameInput" name="name" type="text" placeholder="">
                            </div>
                            <!-- Head Field -->
                            <div class="col-6 position-relative " hidden>
                                <select class="form-select" id="headSelect" name="head">
                                    <option selected disabled value="">...</option>
                                    @foreach ($incomeheadData as $data)
                                        <option value="{{ $data->id }}"
                                            {{ old('head') == $data->id ? 'selected' : ($data->head == 'Student fee' ? 'selected' : '') }}>
                                            {{ $data->head }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <!-- Center Field -->
                            <div class="col-6 position-relative" hidden>
                                <select class="form-select" name="center">
                                    <option selected disabled value="">...</option>
                                    @foreach ($centerdetails as $center)
                                        <option value="{{ $center->id }}"
                                            {{ old('center') == $center->id ? 'selected' : ($center->name == 'Logiprompt Accademy' ? 'selected' : '') }}>
                                            {{ $center->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <!-- second form -->
                            <div class="card-header">
                                <h4> Invoice Details</h4>
                                <!--  -->
                            </div>
                            <!-- invoice number -->
                            <div class="col-md-6 position-relative">
                                <label class="form-label" for="invoiceNumber">Invoice Number <span style="color: red;">*</span></label>
                                <div class="input-group has-validation">
                                    <!-- Prefilled Invoice Number -->
                                    <span class="input-group-text" id="invoicePrefix">{{ $generalData->prefix }}</span>
                                    <!-- User Input -->
                                    <input class="form-control @error('invoiceno') is-invalid @enderror" name="invoiceno"
                                        value="{{ $nextInvoiceNumber }}" type="text" id="invoiceNumber"
                                        value="{{ old('invoiceno', 'LOGI123' . $nextInvoiceNumber) }}"
                                        placeholder="Enter invoice number" readonly required>
                                    <input type="hidden" name="invoicePrefix" id="invoicePrefixHidden"
                                        value="{{ $generalData->prefix }}">
                                </div>

                                <!-- Validation Error Message -->
                                @error('invoiceno')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <!-- invoice date -->
                            <div class="col-6">
                                <label class="col-sm-3">Invoice Date<span style="color: red;">*</span></label>
                                <div class="col-sm-12">
                                    <input class="form-control @error('invoicedate') is-invalid @enderror"
                                        id="example-datetime-local-input" type="datetime-local" name="invoicedate"
                                        value="{{ old('invoicedate', now()->format('Y-m-d\TH:i')) }}"
                                        max="{{ now()->format('Y-m-d\TH:i') }}">
                                    @error('invoicedate')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>



                            <!-- transactionmethod -->

                            <div class="col-6">
                                <label class="form-label" for="validationDefaultDepartment">Transacton Method<span style="color: red;">*</span></label>
                                <select class="form-select @error('transactionmethod') is-invalid @enderror"
                                    id="transactionMethod" name="transactionmethod" required
                                    onchange="clearValidationMessage(this)">
                                    <option selected disabled value="">Choose...</option>
                                    @foreach (config('global.TransactonMethod') as $transactionmethod)
                                        <option value="{{ $transactionmethod }}"
                                            {{ old('transactionmethod') == $transactionmethod ? 'selected' : '' }}>
                                            {{ $transactionmethod }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('transactionmethod')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <!-- bank account -->
                            <div class="col-6">
                                <label class="form-label" for="validationDefaultDepartment">Bank Account</label>
                                <select class="form-select @error('bankaccount') is-invalid @enderror"
                                    id="validationDefaultDepartment" name="bankaccount" required
                                    onchange="clearValidationMessage(this)">
                                    <option selected  value="">Choose...</option>
                                    <option value="Sbi" {{ old('bankaccount') == 'Sbi' ? 'selected' : '' }}>Sbi
                                    </option>
                                </select>
                                @error('bankaccount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- generated by -->
                            <div class="col-6">
                                <label class="form-label" for="validationDefaultDepartment">Generated By</label>
                                <select class="form-select @error('generatedby') is-invalid @enderror"
                                    id="validationDefaultDepartment" name="generatedby" required
                                    onchange="clearValidationMessage(this)">
                                    <option selected disabled value="">Choose...</option>
                                    <option value="Logiprompt" {{ old('generatedby') == 'Logiprompt' ? 'selected' : '' }}>
                                        Logiprompt</option>
                                </select>
                                @error('generatedby')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- transaction id -->
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">Transaction Id</label>
                                <input class="form-control @error('transactionid') is-invalid @enderror"
                                    id="validationCustom01" type="text" placeholder="Enter your admission number"
                                    name="transactionid" value="{{ old('transactionid') }}" required>
                                @error('transactionid')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- FeeMaster Dropdown -->
                            <div class="col-6">
                                <label class="form-label" for="feeselect">FeeMaster<span style="color: red;">*</span></label>
                                <select class="form-select @error('feeselect') is-invalid @enderror" name="feeselect[]"
                                    id="feeselect" multiple required>
                                    <option selected disabled value="">Choose...</option>
                                    @foreach ($feeTitles as $id => $title)
                                        <option value="{{ $id }}">{{ $title }}</option>
                                    @endforeach
                                </select>

                                @error('feeselect')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- Add a container to display fee details -->
                            <div id="feeDetailsContainer"></div>



                            <!-- Invoice Table Section -->
                            <div class="col-md-12">
                                <!-- Title: Description -->
                                <h4 class="mb-4">Description<span style="color: red;">*</span></h4>

                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Field</th>
                                            <th>Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Description Field -->
                                        <tr>
                                            <td><label for="description" class="form-label">Description</label></td>
                                            <td>
                                                <input type="text"
                                                    class="form-control @error('description') is-invalid @enderror"
                                                    id="description" name="description" value="Internship"
                                                    placeholder="Internship Payment" required readonly>
                                            </td>
                                        </tr>

                                        <!-- Unit Price Input -->
                                        <tr>
                                            <td>
                                                <label for="unitprice" class="form-label">Unit Price</label>
                                            </td>
                                            <td>
                                                <input type="number"
                                                    class="form-control @error('unitprice') is-invalid @enderror"
                                                    id="unitprice_student" name="unitprice"
                                                    value="{{ old('unitprice') }}" placeholder="5000" required>
                                                @error('unitprice')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                        </tr>

                                        <!-- Tax Field -->
                                        <tr>
                                            <td><label for="gst" class="form-label">Total Tax</label></td>
                                            <td>
                                                <input type="number"
                                                    class="form-control @error('gst') is-invalid @enderror"
                                                    id="totaltax" name="gst" value="{{ $totalTaxSum ?? 0 }}"
                                                    readonly>
                                            </td>
                                        </tr>
                                        <!-- Splitup Field -->
                                        <tr hidden>
                                            <td>
                                                <input type="hidden"
                                                    class="form-control @error('splitup') is-invalid @enderror"
                                                    id="splitup" name="splitup" value="0" readonly>

                                                <input type="text"
                                                    class="form-control @error('gstAmt') is-invalid @enderror"
                                                    id="gstAmt" name="gstAmt" value="0" readonly>

                                            </td>
                                        </tr>

                                        <!-- Amount Field -->
                                        <tr>
                                            <td><label for="amount" class="form-label">Amount</label></td>
                                            <td>
                                                <input type="number"
                                                    class="form-control @error('amount') is-invalid @enderror"
                                                    id="amount" value="{{ old('amount') }}" name="amount"
                                                    value="0">
                                            </td>
                                        </tr>

                                        <!-- Total Amount Field -->
                                        <tr>
                                            <td><label for="total_amount" class="form-label">Total Amount</label></td>
                                            <td>
                                                <input type="number"
                                                    class="form-control @error('total_amount') is-invalid @enderror"
                                                    id="total_amount" name="total_amount"
                                                    value="{{ old('total_amount') }}" value="0">
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                            <!-- Notes -->
                            <div class="col-6">
                                <label class="form-label" for="notesTextarea">Notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notesTextarea" name="notes"
                                    rows="3">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 mt-5">
                                <button class="btn btn-primary" type="button" id="form-submit-btn">Submit Form</button>
                            </div>
                            <div id="taxDetailsContainer"></div>
                            <div id="splitupResults"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- storing the data using api --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const transactionMethodSelect = document.getElementById('transactionMethod');
            transactionMethodSelect.addEventListener('change', function() {

                const form = document.getElementById('invoiceForm');
                $('#form-submit-btn').on('click', function(e) {
                    e.preventDefault()
                    var formData = new FormData($('#invoiceForm')[0]);

                    //   let formdata =  $('#invoiceForm').serialize() 

                    if (transactionMethod.value !== 'Cash') {
                        $.ajax({
                            url: baseurl +
                                "admin/studencashtinvoice/store", // Replace with your backend route
                            type: 'POST',
                            data: formData,
                            processData: false, // Don't process the data (important for FormData)
                            contentType: false, // Don't set content type (important for FormData)
                            success: function(response) {
                                // Handle success response
                                if (response.success) {
                                    alert('Invoice submitted successfully!');
                                } else {
                                    alert('There was an error submitting the invoice.');
                                }
                            },
                            error: function(xhr, status, error) {
                                // Handle error response
                                console.log('AJAX error:', error);
                                alert('There was an error processing the form.');
                            }
                        });
                    }
                    $('#invoiceForm').submit()

                })
            });
        });
    </script>


    <script>
        document.getElementById('feeselect').addEventListener('change', function() {
            let feeId = this.value;

            // Fetch the fee details via AJAX for the selected FeeMaster
            fetch(`/public/admin/studentinvoice/fetch-fee-details/${feeId}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.splitup && data.splitup.length > 0) {
                        let splitup = data.splitup; // [30, 70]
                        let unitprice = parseFloat(document.getElementById('unitprice').value) || 0;
                        let splitupResults = '';

                        splitup.forEach((percentage, index) => {
                            let amount = (percentage / 100) * unitprice;
                            splitupResults +=
                                `<p>${percentage}% of Unit Price = ${amount.toFixed(2)}</p>`;
                        });

                        document.getElementById('splitupResults').innerHTML = splitupResults;
                    }
                })
                .catch(error => console.error('Error fetching fee details:', error));
        });

        document.getElementById('unitprice_student').addEventListener('change', function() {

            let feeId = document.getElementById('feeselect').value;
            let unitprice = parseFloat(this.value) || 0;
             let balanceAmount = parseFloat(document.getElementById('balanceamount').value) || 0;

            if (unitprice > balanceAmount) {
                // Create a popup element
                let popup = document.createElement('div');
                popup.id = 'errorPopup';
                popup.style.position = 'fixed';
                popup.style.top = '20px';
                popup.style.left = '50%';
                popup.style.transform = 'translateX(-50%)';
                popup.style.padding = '10px';
                popup.style.backgroundColor = 'red';
                popup.style.color = 'white';
                popup.style.borderRadius = '5px';
                popup.style.zIndex = '9999';
                popup.textContent = 'Unit price cannot be greater than the balance amount!';

                // Append the popup to the body
                document.body.appendChild(popup);

                // Remove the popup after 1 second
                setTimeout(function() {
                    popup.remove();
                }, 1000);

                // Clear the invalid unit price field
                this.value = ''; // Reset the input to avoid invalid state
                return; // Prevent further calculations or form submission
            }
            console.log(unitprice, 'unitprice')
            if (feeId && unitprice > 0) {

                // Fetch the fee details if unit price changes
                fetch(`/public/admin/studentinvoice/fetch-fee-details/${feeId}`)
                    .then(response => response.json())
                    .then(data => {
                        var taxsplit = JSON.parse(data.taxes)
                        if (data && data.splitup && data.splitup.length > 0) {
                            let splitup = data.splitup; // [30, 70]

                            let splitupResults = '';
                            let splitupExisting = '';


                            let gstAmounts = [];


                            splitup.forEach((percentage, index) => {


                                fetch(`/public/admin/studentinvoice/getFeePercentage/` + taxsplit[index])
                                    .then(response => response.json())
                                    .then(data => {

                                        let totalgstpercentage = data.percentage;
                                        let amount = (percentage / 100) * unitprice;

                                        splitupExisting = String((document.getElementById('splitup')
                                            .value))

                                        document.getElementById('splitup').value = splitupExisting +
                                            ', ' + amount;
                                        var splituparray = (document.getElementById('splitup')
                                            .value);

                                        splitupResults +=
                                            `<p>${percentage}% of Unit Price = ${amount.toFixed(2)}</p>`;
                                        let gstamount = amount * (totalgstpercentage / (100 +
                                            totalgstpercentage));

                                        gstAmounts.push(gstamount.toFixed(2));

                                        console.log('70,30', gstAmounts)
                                        var previoustax = document.getElementById('totaltax').value;
                                        var test = parseFloat(gstamount) + parseFloat(previoustax);
                                        // console.log(gstamount.toFixed(2));
                                        document.getElementById('gstAmt').value = gstAmounts.join(
                                            ", ");
                                        document.getElementById('totaltax').value = test.toFixed(2);
                                        var paidamount = unitprice - test.toFixed(2)
                                        document.getElementById('amount').value = paidamount
                                            .toFixed(2);
                                        document.getElementById('total_amount').value = unitprice
                                            .toFixed(2);
                                        const balanceAmountInput = document.getElementById(
                                            'balanceamount');

                                        const setCourseFee = () => {
                                            const selectedStudent = studentSelect.options[
                                                studentSelect.selectedIndex
                                            ]; // Get the selected student option
                                            if (selectedStudent) {
                                                const courseFee = parseFloat(selectedStudent
                                                        .getAttribute('data-fees')) ||
                                                    0; // Get course fee for the selected student

                                                // Calculate balance amount (course fee - unit price)
                                                const unitPrice = parseFloat(unitPriceInput
                                                    .value) || 0;
                                                const balanceAmount = courseFee - unitPrice;

                                                // Update the balance amount input with the calculated balance
                                                balanceAmountInput.value = balanceAmount
                                                    .toFixed(2);
                                            }

                                        };
                                    })
                            });
                            document.getElementById('splitupResults').innerHTML = splitupResults;
                        }
                    })
                    .catch(error => console.error('Error fetching fee details:', error));
            }
        });
        
        //   document.getElementById('unitprice_student').addEventListener('change', function() {
        //     let unitprice = parseFloat(this.value) || 0;
        //     let balanceAmount = parseFloat(document.getElementById('balanceamount').value) || 0;

        //     if (unitprice > balanceAmount) {
        //         // Create a popup element
        //         let popup = document.createElement('div');
        //         popup.id = 'errorPopup';
        //         popup.style.position = 'fixed';
        //         popup.style.top = '20px';
        //         popup.style.left = '50%';
        //         popup.style.transform = 'translateX(-50%)';
        //         popup.style.padding = '10px';
        //         popup.style.backgroundColor = 'red';
        //         popup.style.color = 'white';
        //         popup.style.borderRadius = '5px';
        //         popup.style.zIndex = '9999';
        //         popup.textContent = 'Unit price cannot be greater than the balance amount!';

        //         // Append the popup to the body
        //         document.body.appendChild(popup);

        //         // Remove the popup after 1 second
        //         setTimeout(function() {
        //             popup.remove();
        //         }, 1000);

        //         // Clear the invalid unit price field
        //         this.value = ''; // Reset the input to avoid invalid state
        //         return; // Prevent further calculations or form submission
        //     }

        //     // Proceed with the rest of your logic if the validation passes
        //     let feeId = document.getElementById('feeselect').value;
        //     if (feeId && unitprice > 0) {
        //         // Fetch the fee details if unit price changes
        //         fetch(`/admin/studentinvoice/fetch-fee-details/${feeId}`)
        //             .then(response => response.json())
        //             .then(data => {
        //                 var taxsplit = JSON.parse(data.taxes);
        //                 if (data && data.splitup && data.splitup.length > 0) {
        //                     let splitup = data.splitup; // [30, 70]

        //                     let splitupResults = '';
        //                     let gstAmounts = [];

        //                     splitup.forEach((percentage, index) => {
        //                         fetch(`/admin/studentinvoice/getFeePercentage/` + taxsplit[index])
        //                             .then(response => response.json())
        //                             .then(data => {
        //                                 let totalgstpercentage = data.percentage;
        //                                 let amount = (percentage / 100) * unitprice;

        //                                 splitupResults +=
        //                                     `<p>${percentage}% of Unit Price = ${amount.toFixed(2)}</p>`;
        //                                 let gstamount = amount * (totalgstpercentage / (100 +
        //                                     totalgstpercentage));

        //                                 gstAmounts.push(gstamount.toFixed(2));

        //                                 // Update tax values
        //                                 var previoustax = document.getElementById('totaltax').value;
        //                                 var test = parseFloat(gstamount) + parseFloat(previoustax);
        //                                 document.getElementById('gstAmt').value = gstAmounts.join(
        //                                     ", ");
        //                                 document.getElementById('totaltax').value = test.toFixed(2);

        //                                 var paidamount = unitprice - test.toFixed(2);
        //                                 document.getElementById('amount').value = paidamount
        //                                     .toFixed(2);
        //                                 document.getElementById('total_amount').value = unitprice
        //                                     .toFixed(2);
        //                             });
        //                     });

        //                     document.getElementById('splitupResults').innerHTML = splitupResults;
        //                 }
        //             })
        //             .catch(error => console.error('Error fetching fee details:', error));
        //     }
        // });
    </script>

    {{-- storing the name of student in income --}}

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const studentSelect = document.getElementById('studentSelect');
            const nameInput = document.getElementById('nameInput');

            studentSelect.addEventListener('change', () => {
                // Get the selected option
                const selectedOption = studentSelect.options[studentSelect.selectedIndex];

                // Get the 'studentname' from the selected option
                const studentName = selectedOption.textContent;

                // Set the value of the Name input field
                nameInput.value = studentName || ''; // Fallback to empty string if no name is found
            });

            // Trigger change on page load to set the value in case there's a pre-selected student
            const preselectedStudent = studentSelect.querySelector('option[selected]');
            if (preselectedStudent) {
                nameInput.value = preselectedStudent
                .textContent; // Pre-fill the name input with the pre-selected student's name
            }
        });
    </script>
    
    <script>
    $(document).ready(function() {
        $('#studentSelect').select2({
            placeholder: "Search for a student...",
            allowClear: true,
            width: '100%'  // Ensure the dropdown fits the container properly
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const studentSelect = new Choices('#studentSelect', {
            searchEnabled: true,        // Enable the search feature
            itemSelectText: '',         // Removes "Press Enter to Select" text
            placeholderValue: 'Choose...', // Placeholder text
            shouldSort: false           // Prevent sorting (keep original order)
        });
    });
</script>


@endsection
<!-- splitup -->
