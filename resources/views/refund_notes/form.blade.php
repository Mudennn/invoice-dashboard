<input type="hidden" name="id" value="{{ $credit_note->id }}">
<input type="hidden" name="invoice_no" value="{{ $credit_note->invoice_no }}">
<input type="hidden" name="invoice_uuid" value="{{ $credit_note->invoice_uuid }}">
{{-- <input type="hidden" name="credit_note_uuid" value="{{ $credit_note->credit_note_uuid ?? Str::uuid()->toString() }}"> --}}

@if ($errors->any())
    <div class="alert alert-danger" id="validation-errors" style="display: block;">
        <ul class="list-unstyled mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@else
    <div class="alert alert-danger" id="validation-errors" style="display: none;"></div>
@endif


{{-- Shipping Information --}}
<div class="input-form form-input-container">
    <div class="d-flex flex-column gap-2 mb-4">
        <h3>Billing Information</h3>
        <p class="sub-text">Billing information for the invoice</p>
    </div>

    <div class="input-container">
        <div class="left-container">
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="customer" class="form-lable">Customer</label>
                    {{-- <input type="text" name="customer" class="form-control" value="{{ $invoice->customer }}" {{$ro}}> --}}
                    <select name="customer" id="customer" class="form-control form-select" {{ $ro }}>
                        <option value=""> {{ 'Choose :' }}</option>
                        @foreach ($customers as $customer)
                            @if ($credit_note->customer)
                                <option value="{{ $customer }}"
                                    {{ $customer == $credit_note->customer ? 'selected' : '' }}>{{ $customer }}</option>
                            @else
                                <option value="{{ $customer }}"
                                    {{ $customer == old('customer') ? 'selected' : '' }}>{{ $customer }}</option>
                            @endif
                        @endforeach
                    </select>

                    @error('customer')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror

                </div>
                <div class="w-100">
                    <label for="shipping_info" class="form-lable">Shipping Info</label>
                    <input type="text" name="shipping_info" class="form-control"
                        value="{{ $credit_note->shipping_info }}" {{ $ro }}>

                    @error('shipping_info')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="billing_attention" class="form-lable">Billing Attention</label>
                    <input type="text" name="billing_attention" class="form-control"
                        value="{{ $credit_note->billing_attention }}" {{ $ro }}>

                    @error('billing_attention')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="shipping_attention" class="form-lable">Shipping Attention</label>
                    <input type="text" name="shipping_attention" class="form-control"
                        value="{{ $credit_note->shipping_attention }}" {{ $ro }}>

                    @error('shipping_attention')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="billing_address" class="form-lable">Billing Address</label>
                    <textarea name="billing_address" class="form-control" {{ $ro }}>{{ $credit_note->billing_address }}</textarea>

                    @error('billing_address')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="shipping_address" class="form-lable">Shipping Address</label>
                    <textarea name="shipping_address" class="form-control" {{ $ro }}>{{ $credit_note->shipping_address }}</textarea>

                    @error('shipping_address')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="right-container"></div>
    </div>
</div>
<hr>

{{-- General Information --}}
<div class="input-form form-input-container">
    <div class="d-flex flex-column gap-2 mb-4">
        <h3>General Information</h3>
        <p class="sub-text">General information for the invoice</p>
    </div>

    <div class="input-container">
        <div class="left-container">
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="credit_note_no" class="form-lable">Credit Note Number</label>
                    <input type="text" name="credit_note_no" class="form-control"
                        value="{{$credit_note->credit_note_no }}" {{ $ro }}>

                    @error('credit_note_no')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror

                </div>
                <div class="w-100">
                    <label for="reference_number" class="form-lable">Reference Number</label>
                    <input type="text" name="reference_number" class="form-control"
                        value="{{ $credit_note->reference_number }}" {{ $ro }}>

                    @error('reference_number')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="invoice_date" class="form-lable">Date</label>
                    <input type="date" name="invoice_date" class="form-control"
                        value="{{ old('invoice_date', isset($credit_note->invoice_date) ? \Carbon\Carbon::parse($credit_note->invoice_date)->format('Y-m-d') : now()->timezone('Asia/Kuala_Lumpur')->format('Y-m-d')) }}">

                    @error('invoice_date')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="currency" class="form-lable">Currency</label>
                    <input type="text" name="currency" class="form-control" value="MYR" readonly disabled>

                    @error('currency')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="description" class="form-lable">Description</label>
                    <input type="text" name="description" class="form-control"
                        value="{{ $credit_note->description }}" {{ $ro }}>

                    @error('description')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="internal_note" class="form-lable">Internal Note</label>
                    <input type="text" name="internal_note" class="form-control"
                        value="{{ $credit_note->internal_note }}" {{ $ro }}>

                    @error('internal_note')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="tags" class="form-lable">Tags</label>
                    <input type="text" name="tags" class="form-control" value="{{ $credit_note->tags }}"
                        {{ $ro }}>

                    @error('tags')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="title" class="form-lable">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $credit_note->title }}"
                        {{ $ro }}>

                    @error('title')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="right-container"></div>
</div>
<hr>

{{-- Items --}}
<div class="input-form form-input-container">
    <div class="d-flex flex-column gap-2 mb-4">
        <h3>Items</h3>
        <p class="sub-text">Items for the invoice</p>
    </div>
    <button type="button" class="btn btn-primary mb-3" id="select-invoice-btn">Select Invoice</button>
    <div class="table-responsive" style="overflow-y: auto;">
        <table class="table table-hover table-bordered align-middle text-nowrap" id="invoice-items-table">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="text-center" style="width: 5%;">No</th>
                    <th scope="col" style="width: 10%;">Quantity</th>
                    <th scope="col" style="width: 40%;">Description</th>
                    <th scope="col" style="width: 10%;">Unit Price</th>
                    <th scope="col" style="width: 10%;">Amount</th>
                    <th scope="col" style="width: 5%;"></th>
                </tr>
            </thead>
            <tbody id="invoice-items-body">
                @if(isset($credit_note->creditItems) && count($credit_note->creditItems) > 0)
                    @foreach($credit_note->creditItems as $index => $item)
                    <tr class="invoice-item-row">
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>
                            <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                            <input type="number" name="items[{{ $index }}][quantity]" class="form-control item-quantity" value="{{ $item->quantity }}" min="0" {{ $ro }}>
                        </td>
                        <td>
                            <input type="text" name="items[{{ $index }}][description]" class="form-control" value="{{ $item->description }}" {{ $ro }}>
                        </td>
                        <td>
                            <input type="number" name="items[{{ $index }}][unit_price]" class="form-control item-unit-price" value="{{ $item->unit_price }}" min="0" step="0.01" {{ $ro }}>
                        </td>
                        <td>
                            <input type="number" name="items[{{ $index }}][amount]" class="form-control item-amount" value="{{ $item->amount }}" readonly step="0.01" {{ $ro }}>
                            <input type="hidden" name="items[{{ $index }}][total]" class="item-total" value="{{ $item->total }}">
                        </td>
                        <td class="text-center">
                            <button type="button" class="delete-icon-button remove-item" {{ $ro }}>
                                <span class="material-symbols-outlined" style="font-size: 16px;">delete</span>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <div
        class="d-flex flex-column flex-md-row justify-content-between align-items-start w-100 mt-4 mt-md-0 gap-4 gap-md-0">
        <button type="button" class="primary-button" id="add-item-btn" {{ $ro }}>Add Item</button>
        <table class="table table-bordered align-middle text-nowrap table-footer">
            <tbody>
                <tr>
                    <td style="width: 50%;">Sub Total</td>
                    <td class="d-flex justify-content-between">RM <span id="subtotal">0</span></td>
                </tr>
                <tr>
                    <td class="fw-bold" style="width: 50%;">TOTAL</td>
                    <td class="d-flex justify-content-between">RM <span id="total">0</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<hr>

{{-- Control --}}
<div class="input-form form-input-container">
    <div class="d-flex flex-column gap-2 mb-4">
        <h3>Control</h3>
        <p class="sub-text">Controls and statuses for the transaction.</p>
    </div>

    <div class="btn-group col-12 col-md-5 col-lg-3" role="group" aria-label="Basic radio toggle button group">
        <input type="radio" class="btn-check" name="control" id="btnradio1" value="1" autocomplete="off"
            {{ $credit_note->control == 'draft' ? 'checked' : '' }} checked>
        <label class="btn btn-outline-primary" for="btnradio1">Draft</label>

        <input type="radio" class="btn-check" name="control" id="btnradio2" value="2" autocomplete="off"
            {{ $credit_note->control == 'pending' ? 'checked' : '' }}>
        <label class="btn btn-outline-primary" for="btnradio2">Pending</label>

        <input type="radio" class="btn-check" name="control" id="btnradio3" value="3" autocomplete="off"
            {{ $credit_note->control == 'ready' ? 'checked' : '' }}>
        <label class="btn btn-outline-primary" for="btnradio3">Ready</label>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize row counter
        let rowCount = {{ isset($credit_note->creditItems) ? count($credit_note->creditItems) : 0 }};
        
        // Calculate totals on page load
        calculateTotals();
        
        // --------------------------------------------------------------
        // Invoice Selection Modal
        
        // Open invoice selection modal
        document.getElementById('select-invoice-btn').addEventListener('click', function() {
            // Fetch available invoices
            fetch('{{ route('invoices.index') }}?format=json')
                .then(response => response.json())
                .then(data => {
                    populateInvoiceSelectionTable(data);
                    const modal = new bootstrap.Modal(document.getElementById('invoiceSelectionModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error fetching invoices:', error);
                    alert('Failed to load invoices. Please try again.');
                });
        });
        
        // Populate invoice selection table
        function populateInvoiceSelectionTable(invoices) {
            const tableBody = document.querySelector('#invoice-selection-table tbody');
            tableBody.innerHTML = '';
            
            if (invoices && invoices.length > 0) {
                invoices.forEach(invoice => {
                    const row = document.createElement('tr');
                    
                    // Format date if it exists
                    const invoiceDate = invoice.invoice_date ? new Date(invoice.invoice_date).toLocaleDateString() : 'N/A';
                    
                    row.innerHTML = `
                        <td>${invoice.invoice_no || 'N/A'}</td>
                        <td>${invoiceDate}</td>
                        <td>${invoice.customer || 'N/A'}</td>
                        <td>RM ${parseFloat(invoice.subtotal || 0).toFixed(2)}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary select-invoice-btn" 
                                data-invoice-no="${invoice.invoice_no}">
                                Select
                            </button>
                        </td>
                    `;
                    
                    tableBody.appendChild(row);
                });
                
                // Add event listeners to select buttons
                document.querySelectorAll('.select-invoice-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const invoiceNo = this.getAttribute('data-invoice-no');
                        loadInvoiceDetails(invoiceNo);
                        
                        // Set the invoice number in the form
                        document.querySelector('input[name="invoice_no"]').value = invoiceNo;
                        
                        // Close the modal
                        bootstrap.Modal.getInstance(document.getElementById('invoiceSelectionModal')).hide();
                    });
                });
            } else {
                // No invoices available
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td colspan="5" class="text-center">No invoices available</td>
                `;
                tableBody.appendChild(row);
            }
        }
        
        /**
         * Fetches and displays invoice details from the server
         * @param {string} invoice_no - The invoice number to fetch details for
         */
        function loadInvoiceDetails(invoice_no) {
            // Check if we're in edit mode by looking for an ID
            const isEditMode = document.querySelector('input[name="id"]')?.value;
            const oldItems = [];  // Replace with your old items logic if needed

            fetch(`{{ route('invoices.get-details', ['invoice_no' => ':invoice_no']) }}`.replace(':invoice_no', invoice_no))
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Received invoice data:', data); // Debug log

                    // Set invoice UUID from invoice_uuid
                    if (data.invoice_uuid) {
                        document.querySelector('input[name="invoice_uuid"]').value = data.invoice_uuid;
                    }

                    // Clear existing items
                    const itemsTableBody = document.getElementById('invoice-items-body');
                    itemsTableBody.innerHTML = '';
                    rowCount = 0;

                    // Add invoice items to the credit note
                    if (data.items && data.items.length > 0) {
                        data.items.forEach((item, index) => {
                            const newRow = document.createElement('tr');
                            newRow.className = 'invoice-item-row';
                            
                            newRow.innerHTML = `
                                <td class="text-center">${index + 1}</td>
                                <td>
                                    <input type="hidden" name="items[${index}][id]" value="">
                                    <input type="number" name="items[${index}][quantity]" class="form-control item-quantity" value="${item.quantity}" min="0">
                                </td>
                                <td>
                                    <input type="text" name="items[${index}][description]" class="form-control" value="${item.description}">
                                </td>
                                <td>
                                    <input type="number" name="items[${index}][unit_price]" class="form-control item-unit-price" value="${item.unit_price}" min="0" step="0.01">
                                </td>
                                <td>
                                    <input type="number" name="items[${index}][amount]" class="form-control item-amount" value="${item.amount}" readonly step="0.01">
                                    <input type="hidden" name="items[${index}][total]" class="item-total" value="${item.total}">
                                </td>
                                <td class="text-center">
                                    <button type="button" class="delete-icon-button remove-item"><span class="material-symbols-outlined" style="font-size: 16px;">delete</span></button>
                                </td>
                            `;
                            
                            itemsTableBody.appendChild(newRow);
                            rowCount++;
                            
                            // Add event listeners to the new row
                            addEventListenersToRow(newRow);
                        });
                        
                        // Update customer information if available
                        if (data.customer) {
                            const customerSelect = document.querySelector('select[name="customer"]');
                            if (customerSelect) {
                                for (let i = 0; i < customerSelect.options.length; i++) {
                                    if (customerSelect.options[i].value === data.customer) {
                                        customerSelect.selectedIndex = i;
                                        break;
                                    }
                                }
                            }
                        }
                        
                        // Fill billing/shipping information if available
                        if (data.billing_address) document.querySelector('textarea[name="billing_address"]').value = data.billing_address;
                        if (data.shipping_address) document.querySelector('textarea[name="shipping_address"]').value = data.shipping_address;
                        if (data.billing_attention) document.querySelector('input[name="billing_attention"]').value = data.billing_attention;
                        if (data.shipping_attention) document.querySelector('input[name="shipping_attention"]').value = data.shipping_attention;
                        if (data.shipping_info) document.querySelector('input[name="shipping_info"]').value = data.shipping_info;
                        
                        // Calculate totals
                        calculateTotals();
                    }
                })
                .catch(error => {
                    console.error('Error loading invoice details:', error);
                    alert('Failed to load invoice details. Please try again.');
                });
        }
        
        // --------------------------------------------------------------
        // To make sure the form is submitted correctly and the data is not lost when the page is refreshed
        // Form submission handler
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Validate form before submission
                const errorContainer = document.getElementById('validation-errors');
                if (errorContainer) {
                    errorContainer.innerHTML = '';
                    errorContainer.style.display = 'none';
                }

                // Show loading state
                const submitButton = document.getElementById('btnSubmit');
                if (submitButton) {
                    submitButton.disabled = true;
                    const originalText = submitButton.innerHTML;
                    submitButton.innerHTML = 'Processing...';
                    
                    // Re-enable the button after form submission
                    setTimeout(() => {
                        submitButton.disabled = false;
                        submitButton.innerHTML = originalText;
                    }, 3000);
                }

                // Let the form submit normally to the server
                // This will ensure Laravel's Alert toast is displayed correctly
                return true;
            });
        }
        
        // Display validation errors
        function displayErrors(errors) {
            const errorContainer = document.getElementById('validation-errors');
            if (!errorContainer) return;
            
            // console.log('Errors received:', errors); // Debug log
            
            let errorList = '<ul class="list-unstyled mb-0">';
            
            if (typeof errors === 'object' && errors !== null) {
                // Handle Laravel's validation error format
                Object.keys(errors).forEach(field => {
                    if (Array.isArray(errors[field])) {
                        errors[field].forEach(message => {
                            errorList += `<li>${message}</li>`;
                        });
                    } else if (typeof errors[field] === 'string') {
                        errorList += `<li>${errors[field]}</li>`;
                    }
                });
            } else if (typeof errors === 'string') {
                errorList += `<li>${errors}</li>`;
            } else if (Array.isArray(errors)) {
                errors.forEach(message => {
                    errorList += `<li>${message}</li>`;
                });
            }
            
            errorList += '</ul>';
            errorContainer.innerHTML = errorList;
            errorContainer.style.display = 'block';
            
            // Scroll to error messages
            errorContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        
        // --------------------------------------------------------------
        
        // Add new item row
        document.getElementById('add-item-btn').addEventListener('click', function() {
            const tbody = document.getElementById('invoice-items-body');
            const newRow = document.createElement('tr');
            newRow.className = 'invoice-item-row';
            
            newRow.innerHTML = `
                <td class="text-center">${rowCount + 1}</td>
                <td>
                    <input type="hidden" name="items[${rowCount}][id]" value="">
                    <input type="number" name="items[${rowCount}][quantity]" class="form-control item-quantity" value="0" min="0">
                </td>
                <td>
                    <input type="text" name="items[${rowCount}][description]" class="form-control" value="">
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][unit_price]" class="form-control item-unit-price" value="0" min="0" step="0.01">
                </td>
                <td>
                    <input type="number" name="items[${rowCount}][amount]" class="form-control item-amount" value="0" readonly step="0.01">
                    <input type="hidden" name="items[${rowCount}][total]" class="item-total" value="0">
                </td>
                <td class="text-center">
                    <button type="button" class="delete-icon-button remove-item"><span class="material-symbols-outlined" style="font-size: 16px;">delete</span></button>
                </td>
            `;
            
            tbody.appendChild(newRow);
            rowCount++;
            
            // Add event listeners to the new row
            addEventListenersToRow(newRow);
        });
        
        // Add event listeners to existing rows
        document.querySelectorAll('.invoice-item-row').forEach(row => {
            addEventListenersToRow(row);
        });
        
        // Function to add event listeners to a row
        function addEventListenersToRow(row) {
            // Remove item
            row.querySelector('.remove-item').addEventListener('click', function() {
                row.remove();
                updateRowNumbers();
                calculateTotals();
            });
            
            // Calculate amount when quantity or unit price changes
            const quantityInput = row.querySelector('.item-quantity');
            const unitPriceInput = row.querySelector('.item-unit-price');
            
            [quantityInput, unitPriceInput].forEach(input => {
                input.addEventListener('input', function() {
                    calculateRowAmount(row);
                    calculateTotals();
                });
            });
        }
        
        // Update row numbers
        function updateRowNumbers() {
            document.querySelectorAll('#invoice-items-body tr').forEach((row, index) => {
                row.querySelector('td:first-child').textContent = index + 1;
                
                // Update input names with new indices
                const inputs = row.querySelectorAll('input');
                inputs.forEach(input => {
                    const name = input.getAttribute('name');
                    if (name) {
                        const newName = name.replace(/items\[\d+\]/, `items[${index}]`);
                        input.setAttribute('name', newName);
                    }
                });
            });
        }
        
        // Calculate amount for a row
        function calculateRowAmount(row) {
            const quantity = parseFloat(row.querySelector('.item-quantity').value) || 0;
            const unitPrice = parseFloat(row.querySelector('.item-unit-price').value) || 0;
            const amount = quantity * unitPrice;
            
            row.querySelector('.item-amount').value = amount.toFixed(2);
            row.querySelector('.item-total').value = amount.toFixed(2);
        }
        
        // Calculate totals
        function calculateTotals() {
            let subtotal = 0;
            
            document.querySelectorAll('.item-amount').forEach(input => {
                subtotal += parseFloat(input.value) || 0;
            });
            
            document.getElementById('subtotal').textContent = subtotal.toFixed(2);
            document.getElementById('total').textContent = subtotal.toFixed(2);
        }
    });
</script>

<!-- Invoice Selection Modal -->
<div class="modal fade" id="invoiceSelectionModal" tabindex="-1" aria-labelledby="invoiceSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceSelectionModalLabel">Select Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle" id="invoice-selection-table">
                        <thead class="thead-light">
                            <tr>
                                <th>Invoice No</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Will be populated dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    
