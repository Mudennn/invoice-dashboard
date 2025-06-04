<input type="hidden" name="id" value="{{ $invoice->id }}">
<input type="hidden" name="invoice_uuid" value="{{ $invoice->invoice_uuid ?? Str::uuid()->toString() }}">

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
                            @if ($invoice->customer)
                                <option value="{{ $customer }}"
                                    {{ $customer == $invoice->customer ? 'selected' : '' }}>{{ $customer }}</option>
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
                        value="{{ $invoice->shipping_info }}" {{ $ro }}>

                    @error('shipping_info')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="billing_attention" class="form-lable">Billing Attention</label>
                    <input type="text" name="billing_attention" class="form-control"
                        value="{{ $invoice->billing_attention }}" {{ $ro }}>

                    @error('billing_attention')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="shipping_attention" class="form-lable">Shipping Attention</label>
                    <input type="text" name="shipping_attention" class="form-control"
                        value="{{ $invoice->shipping_attention }}" {{ $ro }}>

                    @error('shipping_attention')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="billing_address" class="form-lable">Billing Address</label>
                    <textarea name="billing_address" class="form-control" {{ $ro }}>{{ $invoice->billing_address }}</textarea>

                    @error('billing_address')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="shipping_address" class="form-lable">Shipping Address</label>
                    <textarea name="shipping_address" class="form-control" {{ $ro }}>{{ $invoice->shipping_address }}</textarea>

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
                    <label for="invoice_no" class="form-lable">Invoice Number</label>
                    <input type="text" name="invoice_no" class="form-control"
                        value="{{$invoice->invoice_no }}" {{ $ro }}>

                    @error('invoice_no')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror

                </div>
                <div class="w-100">
                    <label for="reference_number" class="form-lable">Reference Number</label>
                    <input type="text" name="reference_number" class="form-control"
                        value="{{ $invoice->reference_number }}" {{ $ro }}>

                    @error('reference_number')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="invoice_date" class="form-lable">Date</label>
                    <input type="date" name="invoice_date" class="form-control"
                        value="{{ old('invoice_date', isset($invoice->invoice_date) ? \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d') : now()->timezone('Asia/Kuala_Lumpur')->format('Y-m-d')) }}">

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
                        value="{{ $invoice->description }}" {{ $ro }}>

                    @error('description')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="internal_note" class="form-lable">Internal Note</label>
                    <input type="text" name="internal_note" class="form-control"
                        value="{{ $invoice->internal_note }}" {{ $ro }}>

                    @error('internal_note')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="tags" class="form-lable">Tags</label>
                    <input type="text" name="tags" class="form-control" value="{{ $invoice->tags }}"
                        {{ $ro }}>

                    @error('tags')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="title" class="form-lable">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $invoice->title }}"
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
                @if(isset($invoice->invoiceItems) && count($invoice->invoiceItems) > 0)
                    @foreach($invoice->invoiceItems as $index => $item)
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
            {{ $invoice->control == 'draft' ? 'checked' : '' }} checked>
        <label class="btn btn-outline-primary" for="btnradio1">Draft</label>

        <input type="radio" class="btn-check" name="control" id="btnradio2" value="2" autocomplete="off"
            {{ $invoice->control == 'pending' ? 'checked' : '' }}>
        <label class="btn btn-outline-primary" for="btnradio2">Pending</label>

        <input type="radio" class="btn-check" name="control" id="btnradio3" value="3" autocomplete="off"
            {{ $invoice->control == 'ready' ? 'checked' : '' }}>
        <label class="btn btn-outline-primary" for="btnradio3">Ready</label>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize row counter
        let rowCount = {{ isset($invoice->invoiceItems) ? count($invoice->invoiceItems) : 0 }};
        
        // Calculate totals on page load
        calculateTotals();
        
        // --------------------------------------------------------------
        // Form submission handler
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Clear previous errors
                const errorContainer = document.getElementById('validation-errors');
                if (errorContainer) {
                    errorContainer.innerHTML = '';
                    errorContainer.style.display = 'none';
                }
                
                // Submit form via AJAX
                const formData = new FormData(form);
                
                fetch(form.action, {
                    method: form.method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    // Check if the response is ok (status in the range 200-299)
                    if (!response.ok) {
                        if (response.status === 422) {
                            // Validation error
                            return response.json().then(data => {
                                throw { validationErrors: data };
                            });
                        }
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        // Redirect on success
                        window.location.href = data.redirect;
                    } else if (data.message || data.errors) {
                        // Display validation errors
                        displayErrors(data.message || data.errors);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (error.validationErrors) {
                        // Handle validation errors returned by the server
                        displayErrors(error.validationErrors.errors || error.validationErrors.message || error.validationErrors);
                    } else if (errorContainer) {
                        errorContainer.innerHTML = '<ul class="list-unstyled mb-0"><li>An unexpected error occurred. Please try again.</li></ul>';
                        errorContainer.style.display = 'block';
                    }
                });
            });
        }
        
        // Display validation errors
        function displayErrors(errors) {
            const errorContainer = document.getElementById('validation-errors');
            if (!errorContainer) return;
            
            console.log('Errors received:', errors); // Debug log
            
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
    
