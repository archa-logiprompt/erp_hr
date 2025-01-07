@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>Edit Fee Details</h4>
                </div>
                <div class="card-body">
                    <form method="POST" id="studentinvoiceForm"
                        action="{{ url('admin/studentinvoice/update', $studentinvoicedata->id) }}" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                             <!-- Center Field -->
                             <div class="col-6 mb-3">
    <label class="form-label" for="center">Center</label>
    <select class="form-select" name="center">
        <option selected disabled value="">...</option>
        @foreach ($centerdetails as $center)
            <option value="{{ $center->id }}" 
                {{ old('center', $studentinvoicedata->centers->id ?? null) == $center->id ? 'selected' : '' }}>
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
                            <div class="col-6">
                                <label class="form-label" for="studentSelect">Search Student<span style="color: red;">*</span></label>
                                <select class="form-select @error('student_id') is-invalid @enderror" id="studentSelect"
                                    name="student_id" required>
                                    <option selected disabled value="">Choose...</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}" data-admission="{{ $student->admissionnumber }}"
                                            data-course="{{ $student->course->coursename ?? '' }}"
                                            data-fees="{{ $student->fees }}"
                                            {{ $studentinvoicedata->student_id == $student->id ? 'selected' : '' }}>
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
                                <input class="form-control " id="admissionNo" type="text" name="admissionno"
                                    placeholder="Admission number"
                                    value="{{ $studentinvoicedata->student->admissionnumber ?? '' }}" readonly>
                            </div>

                            <!-- Course -->
                            <div class="col-6">
                                <label class="form-label" for="courseName">Course<span style="color: red;">*</span></label>
                                <input class="form-control" id="courseName" type="text" name="course"
                                    placeholder="Course Name"
                                    value="{{ $studentinvoicedata->student->course->coursename ?? '' }}" readonly>
                            </div>


                            <!-- Fees -->
                            <div class="col-6">
                                <label class="form-label" for="courseFees">Fees</label>
                                <input class="form-control" id="courseFees" type="text" name="fees"
                                    placeholder="Course Fees" value="{{ $studentinvoicedata->student->fees ?? '' }}"
                                    readonly>
                            </div>
                            
                            <!-- Balance Amount Field -->
                                      <div class="col-6">
                                        <label class="form-label" for="courseFees">Balance</label>

                                            <input type="number" 
       class="form-control"
       id="balanceamount"
       name="balanceamount"
       value="{{ old('balanceamount', $studentinvoicedata->balanceamount) }}" readonly>

                                           </div>
                            <div class="card-header">
                                <h4>Edit Invoice Details</h4>
                            </div>

                            <!-- Invoice Details -->
                            <div class="col-md-6">
                                <label class="form-label" for="invoiceNumber">Invoice Number <span style="color: red;">*</span></label>
                                <input class="form-control @error('invoiceno') is-invalid @enderror" id="invoiceNumber"
                                    type="text" name="invoiceno" value="{{ $studentinvoicedata->invoiceno }}" required
                                    readonly>
                                @error('invoiceno')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Transaction Method -->
                            <div class="col-6">
                                <label class="form-label" for="transactionmethod">Transaction Method<span style="color: red;">*</span></label>
                                <select class="form-select @error('transactionmethod') is-invalid @enderror"
                                    name="transactionmethod" required>
                                    <option selected disabled value="">Choose...</option>
                                    @foreach (config('global.TransactonMethod') as $method)
                                        <option value="{{ $method }}"
                                            {{ old('transactionmethod', $studentinvoicedata->transactionmethod) == $method ? 'selected' : '' }}>
                                            {{ $method }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('transactionmethod')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label class="col-sm-3">Invoice Date<span style="color: red;">*</span></label>
                                <div class="col-sm-12">
                                    <input class="form-control @error('invoicedate') is-invalid @enderror"
                                        id="example-datetime-local-input" type="datetime-local" name="invoicedate"
                                        value="{{ old('invoicedate', $studentinvoicedata->invoicedate ? \Carbon\Carbon::parse($studentinvoicedata->invoicedate)->format('Y-m-d\TH:i') : '') }}"
                                        max="{{ now()->format('Y-m-d\TH:i') }}">
                                    @error('invoicedate')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Bank Account -->
                            <div class="col-6">
                                <label class="form-label" for="bankaccount">Bank Account</label>
                                <select class="form-select @error('bankaccount') is-invalid @enderror" id="bankaccount"
                                    name="bankaccount" required>
                                    <option selected disabled value="">Choose...</option>
                                    <option value="Sbi"
                                        {{ old('bankaccount', $studentinvoicedata->bankaccount) == 'Sbi' ? 'selected' : '' }}>
                                        Sbi</option>
                                    <!-- Add more options here as needed -->
                                </select>
                                @error('bankaccount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Generated By -->
                            <div class="col-6">
                                <label class="form-label" for="generatedby">Generated By</label>
                                <select class="form-select @error('generatedby') is-invalid @enderror" id="generatedby"
                                    name="generatedby" required>
                                    <option selected disabled value="">Choose...</option>
                                    <option value="Logiprompt"
                                        {{ old('generatedby', $studentinvoicedata->generatedby) == 'Logiprompt' ? 'selected' : '' }}>
                                        Logiprompt</option>
                                    <!-- Add more options here as needed -->
                                </select>
                                @error('generatedby')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <!-- Transaction ID -->
                            <div class="col-6">
                                <label class="form-label" for="transactionid">Transaction ID</label>
                                <input class="form-control @error('transactionid') is-invalid @enderror" id="transactionid"
                                    type="text" placeholder="Enter transaction ID" name="transactionid"
                                    value="{{ old('transactionid', $studentinvoicedata->transactionid) }}" required>

                                @error('transactionid')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- feemaster -->
                            <div class="col-6">
                                <label class="form-label" for="feeselect">FeeMaster<span style="color: red;">*</span></label>
                                <select class="form-select @error('feeselect') is-invalid @enderror" name="feeselect[]"
                                    id="feeselect" multiple required>
                                    <option disabled value="">Choose...</option>
                                    @foreach ($feeTitles as $id => $title)
                                        <option value="{{ $id }}"
                                            @if (in_array($id, $selectedFees)) selected @endif>
                                            {{ $title }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('feeselect')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>



                            <div class="col-md-12">
                                <h4 class="mb-4">Description</h4>
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
                                                    id="description" name="description"
                                                    value="{{ old('description', $studentinvoicedata->description) }}"
                                                    placeholder="Internship Payment" required>
                                            </td>
                                        </tr>

                                        <!-- Unit Price Field -->
                                        <tr>
                                            <td><label for="unitprice" class="form-label">Unit Price</label></td>
                                            <td>
                                                <input type="number"
                                                    class="form-control @error('unitprice') is-invalid @enderror"
                                                    id="unitprice_student" name="unitprice"
                                                    value="{{ old('unitprice', $studentinvoicedata->unitprice) }}"
                                                    placeholder="5000" required>

                                                @error('unitprice')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>

                                        <!-- GST Field -->
                                        <tr>
                                            <td><label for="gst" class="form-label">Total Tax</label></td>
                                            <td>
                                                <input type="number"
                                                    class="form-control @error('gst') is-invalid @enderror"
                                                    id="totaltax" name="gst"
                                                    value="{{ old('gst', $invoice->gst ?? 0) }}" readonly>
                                                @error('gst')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <!-- splitup -->
                                        <tr hidden>
                                            <td  >
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
                                                    id="amount" name="amount" value="0" readonly>
                                            </td>
                                        </tr>

                                        <!-- Total Amount Field -->
                                        <tr>
                                            <td><label for="total_amount" class="form-label">Total Amount</label></td>
                                            <td>
                                                <input type="number"
                                                    class="form-control @error('total_amount') is-invalid @enderror"
                                                    id="total_amount" name="total_amount" value="0" readonly>
                                            </td>
                                        </tr>

                                        
                                    </tbody>
                                </table>
                            </div>


                            <!-- Notes -->
                            <div class="col-6">
                                <label class="form-label" for="notes">Notes</label>
                                <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $studentinvoicedata->notes) }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <!-- Submit Button -->
                            <div class="col-12">
                                <button class="btn btn-primary" type="submit">Update Invoice</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
    // Event listener for fee selection
    document.getElementById('feeselect').addEventListener('change', function() {
        let feeId = this.value;

        // Fetch the fee details via AJAX for the selected FeeMaster
        fetch(`/public/admin/studentinvoice/fetch-fee-details/${feeId}`)
            .then(response => response.json())
            .then(data => {
                if (data && data.splitup && data.splitup.length > 0) {
                    let splitup = data.splitup; // Example: [30, 70]
                    let unitprice = parseFloat(document.getElementById('unitprice').value) || 0;
                    let splitupResults = '';

                    splitup.forEach((percentage) => {
                        let amount = (percentage / 100) * unitprice;
                        splitupResults += `<p>${percentage}% of Unit Price = ${amount.toFixed(2)}</p>`;
                    });

                    document.getElementById('splitupResults').innerHTML = splitupResults;
                }
            })
            .catch(error => console.error('Error fetching fee details:', error));
    });

    // Event listener for unit price change
    
    //   document.getElementById('unitprice_student').addEventListener('change', function() {
    //         let unitprice = parseFloat(this.value) || 0;
    //         let balanceAmount = parseFloat(document.getElementById('balanceamount').value) || 0;

    //         if (unitprice > balanceAmount) {
    //             // Create a popup element
    //             let popup = document.createElement('div');
    //             popup.id = 'errorPopup';
    //             popup.style.position = 'fixed';
    //             popup.style.top = '20px';
    //             popup.style.left = '50%';
    //             popup.style.transform = 'translateX(-50%)';
    //             popup.style.padding = '10px';
    //             popup.style.backgroundColor = 'red';
    //             popup.style.color = 'white';
    //             popup.style.borderRadius = '5px';
    //             popup.style.zIndex = '9999';
    //             popup.textContent = 'Unit price cannot be greater than the balance amount!';

    //             // Append the popup to the body
    //             document.body.appendChild(popup);

    //             // Remove the popup after 1 second
    //             setTimeout(function() {
    //                 popup.remove();
    //             }, 1000);

    //             // Clear the invalid unit price field
    //             this.value = ''; // Reset the input to avoid invalid state
    //             return; // Prevent further calculations or form submission
    //         }

    //         // Proceed with the rest of your logic if the validation passes
    //         let feeId = document.getElementById('feeselect').value;
    //         if (feeId && unitprice > 0) {
    //             // Fetch the fee details if unit price changes
    //             fetch(`/admin/studentinvoice/fetch-fee-details/${feeId}`)
    //                 .then(response => response.json())
    //                 .then(data => {
    //                     var taxsplit = JSON.parse(data.taxes);
    //                     if (data && data.splitup && data.splitup.length > 0) {
    //                         let splitup = data.splitup; // [30, 70]

    //                         let splitupResults = '';
    //                         let gstAmounts = [];

    //                         splitup.forEach((percentage, index) => {
    //                             fetch(`/admin/studentinvoice/getFeePercentage/` + taxsplit[index])
    //                                 .then(response => response.json())
    //                                 .then(data => {
    //                                     let totalgstpercentage = data.percentage;
    //                                     let amount = (percentage / 100) * unitprice;

    //                                     splitupResults +=
    //                                         `<p>${percentage}% of Unit Price = ${amount.toFixed(2)}</p>`;
    //                                     let gstamount = amount * (totalgstpercentage / (100 +
    //                                         totalgstpercentage));

    //                                     gstAmounts.push(gstamount.toFixed(2));

    //                                     // Update tax values
    //                                     var previoustax = document.getElementById('totaltax').value;
    //                                     var test = parseFloat(gstamount) + parseFloat(previoustax);
    //                                     document.getElementById('gstAmt').value = gstAmounts.join(
    //                                         ", ");
    //                                     document.getElementById('totaltax').value = test.toFixed(2);

    //                                     var paidamount = unitprice - test.toFixed(2);
    //                                     document.getElementById('amount').value = paidamount
    //                                         .toFixed(2);
    //                                     document.getElementById('total_amount').value = unitprice
    //                                         .toFixed(2);
    //                                 });
    //                         });

    //                         document.getElementById('splitupResults').innerHTML = splitupResults;
    //                     }
    //                 })
    //                 .catch(error => console.error('Error fetching fee details:', error));
    //         }
    //     });
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
             location.reload(); 
        }, 1000);

        // Clear the invalid unit price field
        this.value = ''; 
        return; 
    }
        if (feeId && unitprice > 0) {
            // Fetch the fee details again when the unit price changes
            fetch(`/public/admin/studentinvoice/fetch-fee-details/${feeId}`)
                .then(response => response.json())
                .then(data => {
                    let taxsplit = JSON.parse(data.taxes || "[]"); // Parse taxes
                    if (data && data.splitup && data.splitup.length > 0) {
                        let splitup = data.splitup; // Example: [30, 70]
                        let splitupResults = '';
                        let gstAmounts = [];

                        splitup.forEach((percentage, index) => {
                            fetch(`/public/admin/studentinvoice/getFeePercentage/` + taxsplit[index])
                                .then(response => response.json())
                                .then(taxData => {
                                    let totalgstpercentage = taxData.percentage;
                                    let amount = (percentage / 100) * unitprice;

                                    splitupResults += `<p>${percentage}% of Unit Price = ${amount.toFixed(2)}</p>`;
                                    let gstamount = amount * (totalgstpercentage / (100 + totalgstpercentage));

                                    gstAmounts.push(gstamount.toFixed(2));

                                    document.getElementById('gstAmt').value = gstAmounts.join(", ");
                                    let totaltax = gstAmounts.reduce((sum, gst) => sum + parseFloat(gst), 0);

                                    document.getElementById('totaltax').value = totaltax.toFixed(2);
                                    document.getElementById('amount').value = (unitprice - totaltax).toFixed(2);
                                    document.getElementById('total_amount').value = unitprice.toFixed(2);

                                    // Update balance amount
                                    const courseFee = parseFloat(document.getElementById('courseFee').value) || 0;
                                    const balanceAmount = courseFee - unitprice;
                                    document.getElementById('balanceamount').value = balanceAmount.toFixed(2);
                                });
                        });

                        document.getElementById('splitupResults').innerHTML = splitupResults;
                    }
                })
                .catch(error => console.error('Error fetching fee details:', error));
        }
    });

    // Function to set balance amount when unit price changes
    const setBalanceAmount = () => {
        const courseFee = parseFloat(document.getElementById('courseFee').value) || 0; // Course fee input
        const unitPrice = parseFloat(document.getElementById('unitprice_student').value) || 0; // Unit price input
        const balanceAmount = courseFee - unitPrice;

        document.getElementById('balanceamount').value = balanceAmount.toFixed(2); // Update field value
    };

    // Attach event listener for unit price input change
    document.getElementById('unitprice_student').addEventListener('change', setBalanceAmount);

</script>

@endsection


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('studentinvoiceForm');
        const formSubmitBtn = document.getElementById('form-submit-btn');
        const transactionMethodSelect = document.getElementById('transactionmethod');

        // Bind the click event to form-submit-btn
        formSubmitBtn.addEventListener('click', function(e) {
            e.preventDefault(); // Prevent the default form submission

            const formData = new FormData(form);
            const invoiceId =
                "{{ $studentinvoicedata->id }}"; // Laravel Blade to inject studentinvoice ID
            const api8000Url =
                `/public/admin/studentinvoice/update/${invoiceId}`; // Web app URL
            const api8080Url =
                baseurl + "admin/studencashtinvoice/update/" + invoiceId; // API URL

            // Check if the selected transaction method is not "Cash"
            if (transactionMethodSelect.value !== 'Cash') {
                // First, update the invoice in the web database (8000)
                $.ajax({
                    url: api8000Url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log("Updated in web app (8000):", response);

                        // If successful, now update the invoice in the second database via the API (8080)
                        $.ajax({
                            url: api8080Url,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(response) {
                                console.log("Updated in API (8080):", response);
                                alert("Invoice updated successfully!");
                                window.location.href =
                                    `/public/admin/studentinvoice`; // Redirect after success
                            },
                            error: function(xhr) {
                                console.error("Error updating in API (8080):",
                                    xhr);
                                alert(
                                    "Invoice updated in web database (8000), but failed in API (8080). Please check logs."
                                );
                            }
                        });
                    },
                    error: function(xhr) {
                        console.error("Error updating in web app (8000):", xhr);
                        alert(
                            "Failed to update invoice in web app (8000). Please try again."
                        );
                    }
                });
            } else {
                // If the transaction method is "Cash", you can directly handle this case or show a message
                alert("Transaction method 'Cash' is not supported for updates.");
            }
        });
    });
</script>
