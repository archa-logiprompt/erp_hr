<script src="{{asset('assets/js/jquery.min.js')}}""></script>
<!-- Bootstrap js-->
<script src="{{asset('assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- feather icon js-->
<script src="{{asset('assets/js/icons/feather-icon/feather.min.js')}}"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{asset('assets/js/icons/feather-icon/feather-icon.js')}}"></script>
<!-- scrollbar js-->
<script src="{{asset('assets/js/scrollbar/simplebar.js')}}"></script>
<script src="{{asset('assets/js/scrollbar/custom.js')}}"></script>
<!-- Sidebar jquery-->
<script src="{{asset('assets/js/config.js')}}"></script>
<!-- Plugins JS start-->
<script src="{{asset('assets/js/sidebar-menu.js')}}"></script>
<script src="{{asset('assets/js/sidebar-pin.js')}}"></script>
<script src="{{asset('assets/js/slick/slick.min.js')}}"></script>
<script src="{{asset('assets/js/slick/slick.js')}}"></script>
<script src="{{asset('assets/js/header-slick.js')}}"></script>
<!--selectbox-->
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<!-- calendar js-->
    <script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/custom.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/jszip.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/buttons.colVis.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/dataTables.autoFill.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/dataTables.select.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/buttons.bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/buttons.print.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/dataTables.bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/responsive.bootstrap5.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/dataTables.keyTable.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/dataTables.colReorder.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatable-extension/dataTables.scroller.min.js')}}"></script> 
    <script src="../assets/js/tooltip-init.js"></script>t> 
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{asset('assets/js/script.js')}}"></script> 
<script src="{{asset('assets/js/dropzone/dropzone.js')}}"></script>
<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>

<script src="{{asset('assets/js/editors/quill.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>
@dd(config('util.api'))

<!-- automatic fee update -->
<script>
    var baseurl="<?php echo config('util.api') ?>";

    document.addEventListener('DOMContentLoaded', function () {
        // Listen for change event on the course dropdown
        document.getElementById('validationCourse').addEventListener('change', function() {
            // Get the selected option
            var selectedOption = this.options[this.selectedIndex];
            
            // Get the fee data attribute from the selected option
            var fee = selectedOption.getAttribute('data-fee');
            
            // Set the fee value in the input field
            document.getElementById('validationCustomFees').value = fee;
        });
    });



// Client and Project Selection in invoic creation
// document.getElementById('clientSelect').addEventListener('change', function () {
//     var projects = JSON.parse(this.options[this.selectedIndex].getAttribute('data-projects'));
//     var projectSelect = document.getElementById('projectSelect');

//     // Clear existing projects
//     projectSelect.innerHTML = '<option disabled value="">Choose Project...</option>';

//     // Add new projects
//     if (projects.length > 0) {
//         projects.forEach(function (project) {
//             var option = document.createElement('option');
//             option.value = project.id;
//             option.textContent = project.projectname;
//             projectSelect.appendChild(option);
//         });
//     } else {
//         var option = document.createElement('option');
//         option.disabled = true;
//         option.textContent = 'No projects available';
//         projectSelect.appendChild(option);
//     }
// });

// // Trigger the event on page load to populate the project list for the selected client
// document.addEventListener('DOMContentLoaded', function () {
//     var clientSelect = document.getElementById('clientSelect');
//     if (clientSelect.value) {
//         clientSelect.dispatchEvent(new Event('change'));
//     }
// });


document.getElementById('clientSelect').addEventListener('change', function () {
    var projects = JSON.parse(this.options[this.selectedIndex].getAttribute('data-projects'));
    var projectSelect = document.getElementById('projectSelect');
    var projectFeeInput = document.getElementById('validationCustom01'); // Input for project fee

    // Clear existing projects
    projectSelect.innerHTML = '<option  value="">Choose Project...</option>';

    // Add new projects
    if (projects.length > 0) {
        projects.forEach(function (project) {
            var option = document.createElement('option');
            option.value = project.id;
            option.textContent = project.projectname;
            option.setAttribute('data-fee', project.projectfee); // Add project fee as a data attribute
            projectSelect.appendChild(option);
        });
    } else {
        var option = document.createElement('option');
        option.disabled = true;
        option.textContent = 'No projects available';
        projectSelect.appendChild(option);
    }
});

// Add event listener to project dropdown
document.getElementById('projectSelect').addEventListener('change', function () {
    var selectedOption = this.options[this.selectedIndex];
    var projectFee = selectedOption.getAttribute('data-fee'); // Get project fee from selected option
    var projectFeeInput = document.getElementById('validationCustom01');

    // Set the project fee in the input field
    if (projectFee) {
        projectFeeInput.value = projectFee;
    } else {
        projectFeeInput.value = ''; // Clear the input if no fee is available
    }
});

// Trigger the event on page load to populate the project list for the selected client
document.addEventListener('DOMContentLoaded', function () {
    var clientSelect = document.getElementById('clientSelect');
    if (clientSelect.value) {
        clientSelect.dispatchEvent(new Event('change'));
    }
});

// gst and row adding in client invoice
document.addEventListener('DOMContentLoaded', function () {
    const table = document.getElementById('dynamic-table');
    const addRowBtn = document.getElementById('addRowBtn');
    const gstInput = document.querySelector('#gst');  // The input where GST percentage is entered

    // Function to update the amount and gsts field for a row
    function updateAmountAndGST(row) {
        const unitPriceInput = row.querySelector('.unit-price');
        const amountInput = row.querySelector('.amount');
        const gstsInput = row.querySelector('.gsts');  // The GST input field in the row

        const unitPrice = parseFloat(unitPriceInput.value) || 0;
        const gst = parseFloat(gstInput.value) || 0;  // Get GST percentage

        // Calculate amount (Unit Price)
        amountInput.value = unitPrice.toFixed(2);

        // Calculate GST and update the gsts field
        const gstAmount = (unitPrice * gst) / 100;
        gstsInput.value = gstAmount.toFixed(2);

        updateTotals(); // Recalculate totals whenever an amount or GST changes
    }

    // Function to attach event listeners for unit price changes
    function attachUnitPriceEvent(firstRow) {
        const unitPriceInput = firstRow.querySelector('.unit-price');
        const amountInput = firstRow.querySelector('.amount');
        const gstsInput = firstRow.querySelector('.gsts');

        // Event listener for unit price changes
        unitPriceInput.addEventListener('input', function () {
            updateAmountAndGST(firstRow);
        });

        updateAmountAndGST(firstRow); // Initialize the amount and GST for the new row
    }

    // Function to update subtotal, GST, and total
    function updateTotals() {
        let subtotal = 0;

        // Sum up all the amounts
        document.querySelectorAll('.amount').forEach(function (input) {
            subtotal += parseFloat(input.value) || 0;
        });

        const subtotalInput = document.querySelector('#subtotal');
        subtotalInput.value = subtotal.toFixed(2);

        const gst = parseFloat(gstInput.value) || 0; // Get the GST percentage

        // Calculate GST amount
        const gstAmount = (subtotal * gst) / 100;
        const gstAmountInput = document.querySelector('#gstamount');
        gstAmountInput.value = gstAmount.toFixed(2); // Display GST amount

        // Calculate the grand total
        const grandTotal = subtotal + gstAmount;
        const grandTotalInput = document.querySelector('#grandtotal');
        grandTotalInput.value = grandTotal.toFixed(2);
    }

    // Add new rows when the "Add Row" button is clicked
    addRowBtn.addEventListener('click', function () {
        const tableBody = table.querySelector('tbody');

        // Create a new first row
        const firstRow = document.createElement('tr');
        firstRow.className = 'row-section';
        firstRow.innerHTML = `
            <td class="col-md-6">
                <label class="form-label" for="transactionTitle[]">Description</label>
                <input class="form-control" name="transactionTitle[]" type="text" placeholder="" >
            </td>
            <td class="col-md-3">
                <label class="form-label" for="unitPrice[]">Unit Price</label>
                <input class="form-control unit-price" name="unitPrice[]" type="number" placeholder="" >
            </td>
            <td class="col-md-3" rowspan="2">
                <label class="form-label" for="amount[]">Amount</label>
                <input class="form-control amount" name="amount[]" type="text" placeholder="" readonly>
                <label class="form-label" for="gsts[]">GST</label>
                <input class="form-control gsts" name="gsts[]" type="text" placeholder="" readonly>
            </td>
            <td class="col-md-3" rowspan="2">
                <button type="button" class="btn btn-danger delete-btn">x</button>
            </td>
        `;

        // Create a new second row
        // const secondRow = document.createElement('tr');
        // secondRow.className = 'row-section';
        // secondRow.innerHTML = `
        //     <td class="col-md-9" colspan="2">
        //         <label class="form-label" for="description[]">Description (Optional)</label>
        //         <textarea class="form-control" name="description[]" placeholder="Additional details (optional)"></textarea>
        //     </td>
        // `;

        const secondRow = document.createElement('tr');
        secondRow.className = 'row-section';
        secondRow.innerHTML = `
           
        `;

        // Append the new rows to the table
        tableBody.appendChild(firstRow);
        tableBody.appendChild(secondRow);

        // Attach event listeners to the new first row
        attachUnitPriceEvent(firstRow);

        // Attach delete event to the delete button
        const deleteButton = firstRow.querySelector('.delete-btn');
        deleteButton.addEventListener('click', function () {
            tableBody.removeChild(firstRow); // Remove the first row
            tableBody.removeChild(secondRow); // Remove the second row
            updateTotals(); // Recalculate totals after deletion
        });
    });

    // Event listener for GST input changes (this will update the totals when GST value changes)
    gstInput.addEventListener('input', function () {
        updateTotals();
    });

    // Attach event listeners to existing rows on page load
    document.querySelectorAll('.row-section').forEach(function (row) {
        if (row.querySelector('.unit-price')) {
            attachUnitPriceEvent(row);

            // Attach delete event to the delete button for existing rows
            const deleteButton = row.querySelector('.delete-btn');
            if (deleteButton) {
                deleteButton.addEventListener('click', function () {
                    const rowToDelete = row;
                    const nextRow = rowToDelete.nextElementSibling; // Get the second row
                    table.querySelector('tbody').removeChild(rowToDelete); // Remove first row
                    table.querySelector('tbody').removeChild(nextRow); // Remove second row
                    updateTotals(); // Recalculate totals after deletion
                });
            }
        }
    });

    // Initialize totals on page load
    updateTotals();
});

// date checking
// document.getElementById("example-datetime-local-input").max = new Date().toISOString().slice(0, 16);

</script>


<!-- validation  -->
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const formFields = document.querySelectorAll('.form-control');

        formFields.forEach(field => {
            field.addEventListener('input', () => {
                const parent = field.parentElement;

                if (field.value.trim() !== "") {
                    // Remove error feedback if value is entered
                    parent.querySelector('.invalid-feedback')?.remove();
                    field.classList.remove('is-invalid');
                }
            });
        });
    });
</script>
<!-- selectbox validation -->
<script>
    function clearValidationMessage(selectElement) {
        if (selectElement.value) {
            selectElement.classList.remove('is-invalid');
            const errorFeedback = selectElement.parentNode.querySelector('.invalid-feedback');
            if (errorFeedback) {
                errorFeedback.style.display = 'none';
            }
        }
    }
</script>
<!-- image -->
<script>
    const imageInput = document.getElementById('imageInput');
    const existingPhotoContainer = document.getElementById('existingPhotoContainer');
    const previewContainer = document.getElementById('previewContainer');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            // Create a FileReader to read the selected image
            const reader = new FileReader();
            reader.onload = function (event) {
                // Hide the existing photo or "No photo uploaded" text
                existingPhotoContainer.style.display = 'none';

                // Clear any previous preview
                previewContainer.innerHTML = '';

                // Add the new image preview
                const img = document.createElement('img');
                img.src = event.target.result;
                img.style.height = '90px';
                img.style.width = '120px';
                previewContainer.appendChild(img);
            };

            reader.readAsDataURL(file); // Read the image file as a data URL
        }
    });
</script>
<!-- frequency validations -->
 <script>
document.addEventListener("DOMContentLoaded", () => {
    const formFields = document.querySelectorAll('.form-control');

    formFields.forEach(field => {
        field.addEventListener('input', () => {
            const parent = field.parentElement;

            // Remove error feedback if value is entered
            if (field.value.trim() !== "") {
                parent.querySelector('.alert')?.remove();
                field.classList.remove('is-invalid');
            }

            // Custom validation for 'frequency'
            if (field.id === 'frequency') {
                const value = parseInt(field.value, 10);
                if (isNaN(value) || value < 1 || value > 24) {
                    field.classList.add('is-invalid');
                    if (!parent.querySelector('.invalid-feedback')) {
                        const errorDiv = document.createElement('div');
                        errorDiv.classList.add('alert', 'alert-danger', 'mt-2');
                        errorDiv.textContent = 'Duration must be between 1 and 24 months.';
                        parent.appendChild(errorDiv);
                    }
                } else {
                    parent.querySelector('.alert')?.remove();
                    field.classList.remove('is-invalid');
                }
            }
        });
    });
});
</script>

<!-- student invoice -->
<script>
    document.getElementById('studentSelect').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const admissionNo = selectedOption.getAttribute('data-admission');
    const course = selectedOption.getAttribute('data-course');
    const balancefee = selectedOption.getAttribute('data-balancefee');
    
    const fees = selectedOption.getAttribute('data-fees');

    // Populate the fields
    document.getElementById('admissionNo').value = admissionNo || '';
    document.getElementById('courseName').value = course || '';
    document.getElementById('courseFees').value = fees || '';
    document.getElementById('balanceamount').value = balancefee || '';
});

</script>
<!-- student data fetching--invoice -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const unitPriceInput = document.getElementById('unitprice');
    const gstInput = document.getElementById('gst');
    const amountInput = document.getElementById('amount');
    const totalAmountInput = document.getElementById('total_amount');
    const balanceAmountInput = document.getElementById('balanceamount');
    const studentSelect = document.getElementById('studentSelect');

    const gstRate = {{ $gstValue ?? 18 }};  // Default to 18% if gstValue is available

    // Function to update the balance amount for the selected student
    const setCourseFee = () => {
        const selectedStudent = studentSelect.options[studentSelect.selectedIndex]; // Get the selected student option
        if (selectedStudent) {
            const courseFee = parseFloat(selectedStudent.getAttribute('data-fees')) || 0; // Get course fee for the selected student

            // Calculate balance amount (course fee - unit price)
            const unitPrice = parseFloat(unitPriceInput.value) || 0;
            const balanceAmount = courseFee - unitPrice;

            // Update the balance amount input with the calculated balance
            balanceAmountInput.value = balanceAmount.toFixed(2);
        }
    };

    // Handle student selection change
    studentSelect.addEventListener('change', function () {
        // setCourseFee(); // Update course fee and balance amount when a new student is selected
    });

    // Handle unit price input and calculate other fields
    unitPriceInput.addEventListener('input', function () {
        const unitPrice = parseFloat(unitPriceInput.value) || 0;

        // Calculate GST
        const gstAmount = unitPrice * (gstRate / (100 + gstRate));
        gstInput.value = gstAmount.toFixed(2);

        // Calculate Amount (Unit Price - GST)
        const amount = unitPrice - gstAmount;
        amountInput.value = amount.toFixed(2);

        // Total Amount (Equal to Unit Price)
        totalAmountInput.value = unitPrice.toFixed(2);

        // Calculate balance amount for the selected student
        setCourseFee();
    });

    // Set initial balance amount on page load (if a student is pre-selected)
    setCourseFee();
});

</script>


<!-- fees -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const courseSelect = document.getElementById('validationCourse');
        const feeInput = document.getElementById('validationCustomFees');

        // Set fee based on selected course when the page loads
        const selectedOption = courseSelect.options[courseSelect.selectedIndex];
        if (selectedOption && selectedOption.dataset.fee) {
            feeInput.value = selectedOption.dataset.fee;
        }

        // Update fee when course changes
        courseSelect.addEventListener('change', function () {
            const selectedOption = courseSelect.options[courseSelect.selectedIndex];
            feeInput.value = selectedOption.dataset.fee || ''; // Update fee or clear if none
        });
    });
</script>
<!-- balance amount -->
 




