@extends('layouts.dashboard.app')
@section('content')
<div class="page-body">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4>Client Invoice Details</h4>
            </div>
            <div class="card-body">
                 @if ($errors->any())
                        {{ implode('', $errors->all('<div>:message</div>')) }}
                @endif 

                <form id="invoiceForm" method="POST" action="{{ route('admin.clientinvoice.store') }}"
                    enctype="multipart/form-data">

                    @csrf
                    <div class="row g-4">
                        <!-- Center Field -->
                        <div class="col-6 position-relative">
                            <label class="form-label" for="center">Center<span style="color: red;">*</span></label>
                            <select class="form-select" name="center">
                                <option disabled value="">...</option>
                                @foreach ($centerdetails as $center)
                                <option value="{{ $center->id }}"
                                    {{ old('center', 'default_value') == $center->id || $center->name == 'Logiprompt Technosolutions' ? 'selected' : '' }}>
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


                        <!-- Invoice Number Field -->
                        <div class="col-md-6 position-relative">
                            <label class="form-label" for="invoiceNumber">Invoice Number *</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text" id="invoicePrefix">{{ $generalData->prefix }}</span>
                                <input class="form-control" name="invoiceNumber" type="text" value="{{ $nextInvoiceNumber }}">
                            </div>
                            <!-- Hidden field for prefix -->
                            <input type="hidden" name="invoicePrefix" id="invoicePrefixHidden" value="{{ $generalData->prefix }}">
                        </div>

                        <div class="col-6">
                            <label class="col-sm-3">Invoice Date*</label>
                            <div class="col-sm-12">
                                <input class="form-control @error('invoiceDate') is-invalid @enderror"
                                    id="example-datetime-local-input" type="date" name="invoiceDate"
                                    value="{{ old('invoiceDate', now()->format('Y-m-d')) }}"
                                    max="{{ now()->format('Y-m-d') }}">
                                @error('invoiceDate')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Client Selection Dropdown -->
                        <div class="col-6">
                            <label class="form-label" for="clientSelect">Client <span style="color: red;">*</span></label>
                            <select class="form-select" id="clientSelect" name="client">
                                <option selected value="">Choose Client...</option>
                                @foreach ($clientDetails as $client)
                                <option value="{{ $client->id }}" data-name="{{ $client->companyName }}"
                                    data-projects='@json($client->projects->toArray())'
                                    {{ old('client') == $client->id ? 'selected' : '' }}>
                                    {{ $client->companyName }}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has('client'))
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first('client') }}
                            </div>
                            @endif
                        </div>


                        <!-- Project Selection Dropdown -->
                        <div class="col-6">
                            <label class="form-label" for="projectSelect">Project <span style="color: red;">*</span></label>
                            <select class="form-select" id="projectSelect" name="project">
                                <option selected value="">Choose Project...</option>
                            </select>
                              @if ($errors->has('project'))
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first('project') }}
                            </div>
                            @endif
                        </div>


                        <div class="col-md-4 position-relative" hidden>
                            <input class="form-control" id="nameInput" name="name" type="text" placeholder="">
                        </div>
                        <!-- Head Field -->
                        <div class="col-6 position-relative " hidden>
                            <select class="form-select" id="headSelect" name="head">
                                <option selected disabled value="">...</option>
                                @foreach ($incomeheadData as $data)
                                <option value="{{ $data->id }}"
                                    {{ old('head') == $data->id ? 'selected' : ($data->head == 'Client project' ? 'selected' : '') }}>
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
                                    {{ old('center') == $center->id ? 'selected' : ($center->name == 'Logiprompt techno solutions' ? 'selected' : '') }}>
                                    {{ $center->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Transaction Method Field -->

                        <div class="col-md-4 position-relative">
                            <label class="form-label" for="transactionMethod">Transaction Method <span style="color: red;">*</span></label>
                            <select class="form-select" name="transactionMethod" id="transactionMethod">
                                <option selected value="">...</option>
                                @foreach (config('global.TransactonMethod') as $method)
                                <option value="{{ $method }}"
                                    {{ old('transactionMethod') == $method ? 'selected' : '' }}>
                                    {{ $method }}
                                </option>
                                @endforeach
                            </select>
                            @if ($errors->has('transactionMethod'))
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first('transactionMethod') }}
                            </div>
                            @endif
                        </div>

                        <!-- Transaction ID Field -->
                        <div class="col-md-4 position-relative">
                            <label class="form-label" for="transactionId">Transaction ID </label>
                            <input class="form-control" name="transactionId" type="text" placeholder=""
                                value="{{ old('transactionId') }}">
                            @if ($errors->has('transactionId'))
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first('transactionId') }}
                            </div>
                            @endif
                        </div>
                        <!-- projectfee -->
                        <div class="col-4">
                            <label class="form-label" for="validationCustom01">Project Fee With GST</label>
                            <input class="form-control @error('projectname') is-invalid @enderror"
                                id="validationCustom01" type="number" placeholder="Amount" name="projectfee" value="0" readonly>
                        </div>

                        <!-- Balance -->
                        <div class="col-md-4 position-relative">
                            <label class="form-label" for="balance">Balance Amount</label>
                            <input class="form-control" id="balanceInput" name="balance" type="number" placeholder="" value="{{ old('balance') }}" readonly>
                        </div>
                        <!-- transaction details -->

                        <div class="card-header">
                            <h4>Transaction Details</h4>
                        </div>

                        <div class="col-md-4 position-relative">
                            <label class="form-label" for="title">Title<span style="color: red;">*</span></label>
                            <input class="form-control" name="title" type="text" placeholder=""
                                value="{{ old('title') }}">
                            @if ($errors->has('title'))
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first('title') }}
                            </div>
                            @endif
                        </div>


                        <table class="table" id="dynamic-table">
                            <tbody>
                                <!-- First row template -->
                                <tr class="row-section">
                                     <!-- description -->
    <td class="col-md-3">
    <label class="form-label" for="transactionTitle[]">Description<span style="color: red;">*</span></label>
    <input class="form-control" name="transactionTitle[]" type="text" placeholder="">
  
</td>

                                    <td class="col-md-3">
        <label class="form-label" for="unitPrice[]">Unit Price <span style="color: red;">*</span></label>
        <input class="form-control unit-price" name="unitPrice[]" type="number" placeholder="">
        @foreach ($errors->get('unitPrice.*') as $error)
            <div class="alert alert-danger mt-2">
                {{ $error[0] }}
            </div>
        @endforeach
    </td>
   
                                    <td class="col-md-3" rowspan="2">
                                        <label class="form-label" for="amount[]">Amount</label>
                                        <input class="form-control amount" name="amount[]" type="text"
                                            placeholder="">
                                        @if ($errors->has('amount'))
                                        <div class="alert alert-danger mt-2">
                                            {{ $errors->first('amount') }}
                                        </div>
                                        @endif

                                        <label class="form-label" for="gsts[]">GST</label>
                                        <input class="form-control gsts" name="gsts[]" type="text"
                                            placeholder="">
                                    </td>

                                </tr>

                                <!-- Second row template -->
                                <tr class="row-section">
                                    <td class="col-md-9" colspan="2">
                                        <textarea class="form-control" hidden name="description[]" placeholder="Additional details (optional)"></textarea>

                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- Add Button -->
                        <div class="col-md-1">
                            <button type="button" class="btn btn-sm btn-primary" id="addRowBtn">+</button>
                        </div>

                        <div class="col-md-3 ms-auto">
                            <!-- Subtotal -->
                            <div class="d-flex align-items-center mt-2 ">
                                <label for="subtotal" class="form-label me-1">Subtotal</label>
                                <input class="form-control" id="subtotal" name="subtotal" type="text"
                                    placeholder="Subtotal" readonly>
                            </div>
                            <!-- GST -->
                            <input class="form-control" id="gst" name="gst" type="hidden"
                                value="{{ $gst->gstvalue }}">

                            <!-- GST Amount-->
                            <div class="d-flex align-items-center mt-2">
                                <label for="gstamount" class="form-label me-1">GST Amount</label>
                                <input class="form-control" id="gstamount" name="gstamount" type="text"
                                    placeholder="GST" value="{{ $gst->gstvalue }}">
                            </div>

                            <!-- Total -->
                            <div class="d-flex align-items-center mt-2">
                                <label for="grandtotal" class="form-label me-4"> <b>Total</b></label>
                                <input class="form-control" id="grandtotal" name="grandtotal" type="text"
                                    placeholder="Total" readonly>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="editor">Note for Recipient</label>
                            <div class="col-md-12 position-relative editor-container">
                                <textarea id="editor" name="note" class="form-control" rows="10"></textarea>
                                @if ($errors->has('note'))
                                <div class="alert alert-danger mt-2">
                                    {{ $errors->first('note') }}
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- File Upload -->
                        <div class="col-md-12 position-relative">
                            <label class="form-label" for="document">Add Files</label>
                            <input class="form-control" name="document" type="file" placeholder="choose a file">
                            @if ($errors->has('document'))
                            <div class="alert alert-danger mt-2">
                                {{ $errors->first('document') }}
                            </div>
                            @endif
                        </div>

                        <!-- Submit Button -->
                         <div class="col-12">
                                <button class="btn btn-primary" id="form-submit-btn" type="submit">Submit Form</button>
                            </div>
                        <!--<div class="col-12">-->
                        <!--    <button class="btn btn-primary" type="button" id="form-submit-btn">Submit Form</button>-->
                        <!--</div>-->
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Invoice submitted successfully!
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




{{-- api store --}}
//  <script>
//         document.addEventListener('DOMContentLoaded', function() {
//             const transactionMethodSelect = document.getElementById('transactionMethod');
            // const grandTotalInput = document.getElementById('grandTotal'); // Ensure this ID exists in your form
            // const balanceInput = document.getElementById('balanceInput');
//             transactionMethodSelect.addEventListener('change', function() {

//                 const form = document.getElementById('invoiceForm');
//                 $('#form-submit-btn').on('click', function(e) {
//                     e.preventDefault()
//                     var formData = new FormData($('#invoiceForm')[0]);
                    
        // // Check grand total against balance amount
        //          const grandTotal = parseFloat(grandTotalInput.value) || 0;
        //          const balanceAmount = parseFloat(balanceInput.value) || 0;

        //         if (grandTotal > balanceAmount) {
        //             alert('The total amount exceeds the balance amount.');
        //         return;
        //         }

//                     let formdata = $('#invoiceForm').serialize()

//                     if (transactionMethod.value !== 'Cash') {
//                         $.ajax({
//                             url: baseurl +
//                                 "admin/clientcashinvoice/store", // Replace with your backend route
//                             type: 'POST',
//                             data: formData,
//                             processData: false, // Don't process the data (important for FormData)
//                             contentType: false, // Don't set content type (important for FormData)
//                             success: function(response) {
//                                 // Handle success response
//                                 if (response.success) {
//                                     alert('Invoice submitted successfully!');
//                                 } else {
//                                     alert('There was an error submitting the invoice.');
//                                 }
//                             },
//                             error: function(xhr, status, error) {
//                                 // Handle error response
//                                 console.log('AJAX error:', error);
//                                 alert('There was an error processing the form.');
//                             }
//                         });
//                     }
//                     $('#invoiceForm').submit()

//                 })
//             });
//         });
//     </script>

 <script>
    document.addEventListener('DOMContentLoaded', function() {
        const transactionMethodSelect = document.getElementById('transactionMethod');
        const grandTotalInput = document.querySelector('#grandtotal');
        const balanceInput = document.querySelector('#balanceInput');
        const form = document.getElementById('invoiceForm');

    transactionMethodSelect.addEventListener('change', function() {
    $('#form-submit-btn').on('click', function(e) {
        e.preventDefault();
        var formData = new FormData($('#invoiceForm')[0]);

        const grandTotal = parseFloat(grandTotalInput.value) || 0;
        const balanceAmount = parseFloat(balanceInput.value) || 0;

        console.log('Grand Total:', grandTotal, 'Balance Amount:', balanceAmount);

        if (isNaN(grandTotal) || isNaN(balanceAmount)) {
            showPopup('Please enter valid amounts for Grand Total and Balance.');
            return;
        }

        if (grandTotal > balanceAmount) {
            showPopup('The total amount exceeds the balance amount.');
            return;
        }

        console.log('Proceeding with valid amounts.');

        if (transactionMethodSelect.value !== 'Cash') {
            $.ajax({
                url: baseurl + "admin/clientcashinvoice/store", // Replace with your backend route
                type: 'POST',
                data: formData,
                processData: false, // Don't process the data (important for FormData)
                contentType: false, // Don't set content type (important for FormData)
                success: function(response) {
                    if (response.success) {
                        // showPopup('Invoice submitted successfully!', 'success');
                    } else {
                        // showPopup('There was an error submitting the invoice.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX error:', error);
                    // showPopup('There was an error processing the form.', 'error');
                }
            });
        }

        $('#invoiceForm').submit();
    });
});

// Function to show a custom popup message
function showPopup(message, type = 'error') {
    // Create a popup element
    let popup = document.createElement('div');
    popup.id = 'errorPopup';
    popup.style.position = 'fixed';
    popup.style.top = '20px';
    popup.style.left = '50%';
    popup.style.transform = 'translateX(-50%)';
    popup.style.padding = '10px';
    popup.style.backgroundColor = type === 'error' ? 'red' : 'green';
    popup.style.color = 'white';
    popup.style.borderRadius = '5px';
    popup.style.zIndex = '9999';
    popup.textContent = message;

    // Append the popup to the body
    document.body.appendChild(popup);

    // Remove the popup after 3 seconds (you can adjust this time)
    setTimeout(function() {
        popup.remove();
        // location.reload();
    }, 3000);
}

    });
</script>

<!-- name selection for income table  -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const clientSelect = document.getElementById('clientSelect');
        const nameInput = document.getElementById('nameInput');

        clientSelect.addEventListener('change', () => {
            // Get the selected option
            const selectedOption = clientSelect.options[clientSelect.selectedIndex];

            // Get the 'data-name' attribute from the selected option
            const clientName = selectedOption.getAttribute('data-name');

            // Set the value of the Name input field
            nameInput.value = clientName || ''; // Fallback to empty string if no name is found
        });

        // Trigger change on page load to set the value in case there's a pre-selected client
        const preselectedClient = clientSelect.querySelector('option[selected]');
        if (preselectedClient) {
            nameInput.value = preselectedClient.getAttribute('data-name');
        }
    });
</script>


<!-- balance amount calculation -->

<script>
    var clientInvoices = @json($clientinvoice); // Ensure this contains the expected structure

    document.getElementById('clientSelect').addEventListener('change', function() {
        var clientId = this.value;
        var projectSelect = document.getElementById('projectSelect');
        var projectFeeInput = document.getElementById('validationCustom01');
        var balanceInput = document.getElementById('balanceInput');

        // Reset project dropdown
        // projectSelect.innerHTML = '<option selected value="">Choose Project...</option>';

        // Find client data
        var selectedClient = clientInvoices.find(client => client.clientName == clientId);
        if (selectedClient && selectedClient.projects) {
            selectedClient.projects.forEach(project => {
                var option = document.createElement('option');
                option.value = project.id;
                option.textContent = project.name;
                option.setAttribute('data-fee', project.project_fee || 0); // Default to 0 if no fee
                projectSelect.appendChild(option);
            });

            // If a project is pre-selected, trigger the change event
            if (projectSelect.options.length > 1) {
                projectSelect.selectedIndex = 1; // Select the first project
                projectSelect.dispatchEvent(new Event('change')); // Trigger the event to update fields
            }
        } else {
            // Clear inputs if no client or projects
            projectFeeInput.value = '';
            balanceInput.value = '';
        }
    });

    document.getElementById('projectSelect').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var clientId = document.getElementById('clientSelect').value;
        var projectId = selectedOption.value;
        var projectFeeInput = document.getElementById('validationCustom01');
        var balanceInput = document.getElementById('balanceInput');

        if (!selectedOption.value) {
            projectFeeInput.value = '';
            balanceInput.value = '';
            return;
        }

        // Find matching invoices
        var matchingInvoices = clientInvoices.filter(invoice =>
            invoice.clientName == clientId && invoice.project == projectId
        );

        // Sort to get the latest invoice
        var latestInvoice = matchingInvoices.sort((a, b) => new Date(b.created_at) - new Date(a.created_at))[0];

        if (latestInvoice) {
            balanceInput.value = latestInvoice.balance || 0;
        } else {
            // Fallback to project fee if no invoice exists
            var projectFee = selectedOption.getAttribute('data-fee');
            balanceInput.value = projectFee || '';
        }

        // Set project fee
        projectFeeInput.value = selectedOption.getAttribute('data-fee') || '';
    });

    // Initialize dropdowns on page load
    document.addEventListener('DOMContentLoaded', function() {
        var clientSelect = document.getElementById('clientSelect');
        if (clientSelect.value) {
            clientSelect.dispatchEvent(new Event('change'));
        }
    });
</script>



@endsection