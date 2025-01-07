@extends('layouts.dashboard.app')

@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4>Update Client Invoice Details</h4>
                </div>
                <div class="card-body">
                    <!-- Display validation errors -->
                     @if ($errors->any())
                        {{ implode('', $errors->all('<div>:message</div>')) }}
                    @endif
                    <!-- Form starts -->
                    <form method="POST" action="{{ url('/admin/clientinvoice/update', $invoiceData->invoiceNumber) }}"
                        enctype="multipart/form-data" id="clientinvoiceForm">
                        @csrf


                        <div class="row g-4">
                             <!-- Center Field -->
                             <div class="col-6 mb-3">
    <label class="form-label" for="center">Center<span style="color: red;">*</span></label>
    <select class="form-select" name="center">
        <option selected disabled value="">...</option>
        @foreach ($centerdetails as $center)
            <option value="{{ $center->id }}" 
                {{ old('center', $invoiceData->centers->id ?? null) == $center->id ? 'selected' : '' }}>
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

                            <!-- Invoice Number -->
                            <div class="col-md-6">
                                <label class="form-label" for="invoiceNumber">Invoice Number <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    {{-- <span class="input-group-text">{{ $generalData['prefix'] }}</span> --}}
                                    <input class="form-control" type="text" value="{{ $invoiceData->invoiceNumber }}"
                                        disabled>
                                    <input type="hidden" name="invoicePrefix" value="{{ $generalData['prefix'] }}">
                                </div>
                            </div>

                            <!-- Invoice Date -->
                            <div class="col-md-6">
                                <label class="form-label" for="invoiceDate">Invoice Date *</label>
                                <input class="form-control" type="datetime-local" name="invoiceDate"
                                    value="{{ \Carbon\Carbon::parse($invoiceData->invoiceDate)->format('Y-m-d\TH:i') }}">
                                @if ($errors->has('invoiceDate'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('invoiceDate') }}
                                    </div>
                                @endif
                            </div>


                         <div class="col-md-6">
    <label for="clientSelect" class="form-label">Client <span style="color: red;">*</span></label>
    <select class="form-select" name="clientName" id="clientSelect">
        <option selected disabled value="">Choose Client...</option>
        @foreach ($clientDetails as $client)
            <option value="{{ $client->id }}"
                data-name="{{ $client->companyName }}" 
                data-projects="{{ json_encode($client->projects) }}"
                {{ $client->id == old('clientName', $invoiceData->clientName) ? 'selected' : '' }}>
                {{ $client->companyName }}
            </option>
        @endforeach
    </select>
</div>



                           <!-- Project -->
<div class="col-md-6">
<label class="form-label" for="transactionMethod">Project <span style="color: red;">*</span></label>

    <select class="form-select" name="project" id="projectSelect">
        <option disabled value="">Choose Project...</option>
        @foreach ($invoiceData->client->projects->unique('id') ?? [] as $project)
            <option value="{{ $project->id }}"
                {{ old('project', $invoiceData->project) == $project->id ? 'selected' : '' }}>
                {{ $project->projectname }}
            </option>
        @endforeach
    </select>
</div>


                            <div class="col-md-4 position-relative" hidden>
                                <input class="form-control" id="nameInput" name="name" type="text" placeholder="" value="{{ old('name', $invoiceData->clientName) }}">
                            </div>
                            <!-- Head Field -->
                            <div class="col-6 position-relative " hidden >
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

                            <!-- Transaction Method -->
                            {{-- <div class="col-md-4">
                                <label class="form-label" for="transactionMethod">Transaction Method <span style="color: red;">*</span></label>
                                <select class="form-select" name="transactionMethod">
                                    <option selected disabled value="">Choose...</option>
                                    @foreach (config('global.TransactonMethod') as $method)
                                        <option value="{{ $method }}"
                                            {{ $method == $invoiceData->transactionMethod ? 'selected' : '' }}>
                                            {{ $method }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> --}}

                            <div class="col-md-4">
                                <label class="form-label" for="transactionMethod">Transaction Method <span style="color: red;">*</span></label>
                                <select class="form-select" name="transactionMethod" id="transactionMethod">
                                    <option selected disabled value="">Choose...</option>
                                    @foreach (config('global.TransactonMethod') as $method)
                                        <option value="{{ $method }}"
                                            {{ $method == $invoiceData->transactionMethod ? 'selected' : '' }}>
                                            {{ $method }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label" for="transactionId">Transaction ID </label>
                                <input class="form-control" type="text" name="transactionId"
                                    value="{{ $invoiceData->transactionId }}">
                                @if ($errors->has('transactionId'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('transactionId') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Balance -->
<div class="col-md-4 position-relative">
    <label class="form-label" for="balance">Balance Amount</label>
    <input class="form-control" id="balanceInput" name="balance" type="number" placeholder="" value="{{ $invoiceData->balance }}" readonly>
</div>

                          <div class="card-header">
                                <h4>Transaction Details</h4>
                            </div>

                            <div class="col-md-4 position-relative">
                                <label class="form-label" for="title">Title*</label>
                                <input class="form-control" name="title" type="text" placeholder=""
                                    value="{{ $invoiceData->title }}">
                                @if ($errors->has('title'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('title') }}
                                    </div>
                                @endif
                            </div>

                                <table class="table" id="dynamic-table">
                                    <tbody>
                                        @foreach ($transactionTitle as $index => $item)
                                            <!-- First row template -->
                                            <tr class="row-section">
                                          
                                                
                                                <td class="col-md-6">
                                                    <label class="form-label" for="transactionTitle">Description</label>
                                                    <input class="form-control" name="transactionTitle[]" type="text"
                                                        value="{{ $item }}">
                                                    @if ($errors->has('transactionTitle'))
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $errors->first('transactionTitle') }}
                                                        </div>
                                                    @endif
                                                </td>

                                                <td class="col-md-3">
                                                    <label class="form-label" for="unitPrice">Unit Price</label>
                                                    <input class="form-control unit-price" name="unitPrice[]" type="number"
                                                        value="{{ $unitPrices[$index] ?? '' }}">
                                                    @if ($errors->has('unitPrice'))
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $errors->first('unitPrice') }}
                                                        </div>
                                                    @endif
                                                </td>


                                                <td class="col-md-3" rowspan="2">
                                                    <label class="form-label" for="amount[]">Amount</label>
                                                    <input class="form-control amount" name="amount[]" type="text"
                                                        placeholder="" value="{{ $unitPrices[$index] ?? '' }}">
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

                                                    <textarea class="form-control" hidden name="description[]" placeholder="Additional details (optional)">{{ $description[$index] ?? '' }}</textarea>
                                                    @if ($errors->has('description'))
                                                        <div class="alert alert-danger mt-2">
                                                            {{ $errors->first('description') }}
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="col-md-1">
                                    <button type="button" class="btn btn-sm btn-primary m-2" id="addRowBtn">+</button>
                                </div>

                            </div>

                            <div class="col-md-3 ms-auto">

                                <!-- Subtotal, GST, Total -->
                                <div class="d-flex align-items-center">
                                    <label for="subtotal" class="form-label me-1">Subtotal</label>
                                    <input class="form-control" id="subtotal" name="subtotal">
                                </div>

                                <input class="form-control" id="gst" name="gst" type="hidden"
                                    value="{{ $gst->gstvalue }}">

                                <div class="d-none align-items-center">
                                    <label for="gst" class="form-label me-1">GST (%)</label>
                                    <input class="form-control" id="gst" name="gst"
                                        value="{{ $invoiceData->gstamount }}">
                                </div>


                                <div class="d-flex align-items-center">
                                    <label for="gstamount" class="form-label me-1">GST Amount</label>
                                    <input class="form-control" id="gstamount" name="gstamount" type="text"
                                        value="{{ $invoiceData->gstamount }}">
                                </div>

                                <div class="d-flex align-items-center">
                                    <label for="grandtotal" class="form-label me-4">Total</label>
                                    <input class="form-control" id="grandtotal" name="grandtotal"
                                        value="{{ $invoiceData->total ?? '' }}">
                                </div>
                            </div>

                            <!-- Note -->
                            <div class="col-md-12">
                                <label for="note">Note for Recipient</label>
                                <textarea name="note" class="form-control" rows="5">{{ $invoiceData->note }}</textarea>
                            </div>


                            <div class="form-group">
                                <label for="">Existing Document</label>
                                <div>
                                    @if (pathinfo($invoiceData->document, PATHINFO_EXTENSION) == 'pdf')
                                        <!-- Embed the PDF using an iframe -->
                                        <iframe src="{{ asset($invoiceData->document) }}"
                                            style="width: 100%; height: 500px;" frameborder="0"></iframe>
                                    @else
                                        <!-- If it's not a PDF, show an image -->
                                        <img src="{{ asset($invoiceData->document) }}"
                                            style="height: 90px; width: 120px;">
                                    @endif
                                </div>
                            </div>

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
                                <button type="button" id="form-submit-btn" class="btn btn-primary">Update
                                    Invoice</button>

                                {{-- <button type="button" id="form-submit-btn" class="btn btn-primary">Update Invoice</button> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('clientinvoiceForm');
        const formSubmitBtn = document.getElementById('form-submit-btn');
        const transactionMethodSelect = document.getElementById('transactionMethod');
        const grandTotalInput = document.querySelector('#grandtotal');
        const balanceInput = document.querySelector('#balanceInput');

        formSubmitBtn.addEventListener('click', function (e) {
            e.preventDefault(); 

            const grandTotal = parseFloat(grandTotalInput.value) || 0;
            const balanceAmount = parseFloat(balanceInput.value) || 0;

            if (isNaN(grandTotal) || isNaN(balanceAmount)) {
                alert('Please enter valid amounts for Grand Total and Balance.');
                return;
            }

            if (grandTotal > balanceAmount) {
                alert('The total amount exceeds the balance amount.');
                return;
            }

            const formData = new FormData(form);
            const invoiceId = "{{ $invoiceData->invoiceNumber }}"; 
            const api8000Url = `/public/admin/clientinvoice/update/${invoiceId}`;
            const api8080Url = baseurl + "admin/clientcashinvoice/update/" + invoiceId;

            if (transactionMethodSelect.value !== 'Cash') {
                $.ajax({
                    url: api8000Url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        console.log("Updated in web app (8000):", response);

                        $.ajax({
                            url: api8080Url,
                            type: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                alert("Invoice updated successfully!");
                                window.location.href = "/public/admin/clientinvoice";
                            },
                            error: function (xhr) {
                                alert("Error updating in API (8080). Please check the logs.");
                            }
                        });
                    },
                    error: function (xhr) {
                        alert("Error updating in web database (8000). Please try again.");
                    }
                });
            } else {
                alert("Transaction method 'Cash' is not supported for updates.");
            }
        });
    });
</script>

// <script>
//     document.addEventListener('DOMContentLoaded', function() {
//         const form = document.getElementById('clientinvoiceForm');
//         const formSubmitBtn = document.getElementById('form-submit-btn');
//         const transactionMethodSelect = document.getElementById('transactionMethod');

//         // Bind the click event to form-submit-btn
//         formSubmitBtn.addEventListener('click', function(e) {
//             e.preventDefault(); // Prevent the default form submission

//             const formData = new FormData(form);
//             const invoiceId = "{{ $invoiceData->invoiceNumber }}"; // Laravel Blade to inject clientinvoice ID
//             const api8000Url =
//             `/public/admin/clientinvoice/update/${invoiceId}`; // Web app URL
//             const api8080Url =
//             baseurl+"admin/clientcashinvoice/update/"+invoiceId; // API URL

//             // Check if the selected transaction method is not "Cash"
//             if (transactionMethodSelect.value !== 'Cash') {
//                 // First, update the invoice in the web database (8000)
//                 $.ajax({
//                     url: api8000Url,
//                     type: 'POST',
//                     data: formData,
//                     processData: false,
//                     contentType: false,
//                     success: function(response) {
//                         console.log("Updated in web app (8000):", response);

//                         // If successful, now update the invoice in the second database via the API (8080)
//                         $.ajax({
//                             url: api8080Url,
//                             type: 'POST',
//                             data: formData,
//                             processData: false,
//                             contentType: false,
//                             success: function(response) {
//                                 console.log("Updated in API (8080):", response);
//                                 alert("Invoice updated successfully!");
//                                 window.location.href =
//                                     `/public/admin/clientinvoice`; // Redirect after success
//                             },
//                             error: function(xhr) {
//                                 console.error("Error updating in API (8080):",
//                                     xhr);
//                                 alert(
//                                     "Invoice updated in web database (8000), but failed in API (8080). Please check logs.");
//                             }
//                         });
//                     },
//                     error: function(xhr) {
//                         console.error("Error updating in web app (8000):", xhr);
//                         alert(
//                             "Failed to update invoice in web app (8000). Please try again.");
//                     }
//                 });
//             } else {
//                 // If the transaction method is "Cash", you can directly handle this case or show a message
//                 alert("Transaction method 'Cash' is not supported for updates.");
//             }
//         });
//     });
// </script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const clientSelect = document.getElementById('clientSelect');
        const nameInput = document.getElementById('nameInput');

        // Function to update the name input field
        const updateNameInput = () => {
            // Get the selected option
            const selectedOption = clientSelect.options[clientSelect.selectedIndex];

            // Get the 'data-name' attribute from the selected option
            const clientName = selectedOption.getAttribute('data-name');

            // Set the value of the Name input field
            nameInput.value = clientName || ''; // Fallback to empty string if no name is found
        };

        // When the client is changed, update the name input
        clientSelect.addEventListener('change', updateNameInput);

        // Trigger change on page load to set the value if there's a pre-selected client
        updateNameInput();
    });
</script>
<script>
    var clientInvoices = @json($clientinvoice); // Ensure this contains the expected structure

document.getElementById('clientSelect').addEventListener('change', function () {
    var clientId = this.value;
    var projectSelect = document.getElementById('projectSelect');
    var projectFeeInput = document.getElementById('validationCustom01');
    var balanceInput = document.getElementById('balanceInput');

    // Reset project dropdown
    projectSelect.innerHTML = '<option selected value="">Choose Project...</option>';
    
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

document.getElementById('projectSelect').addEventListener('change', function () {
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
document.addEventListener('DOMContentLoaded', function () {
    var clientSelect = document.getElementById('clientSelect');
    if (clientSelect.value) {
        clientSelect.dispatchEvent(new Event('change'));
    }
});

</script>


