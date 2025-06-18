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
                    <select name="customer" id="customer" class="form-control form-select customer-select-input" {{ $ro }}>
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
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label for="shipping_info" class="form-lable">Shipping Info</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="enable-shipping" 
                                {{ ($credit_note->shipping_info || $credit_note->shipping_attention || $credit_note->shipping_address) ? 'checked' : '' }}>
                            <label class="form-check-label" for="enable-shipping">
                                Enable Shipping
                            </label>
                        </div>
                    </div>
                    <input type="text" name="shipping_info" id="shipping_info" class="form-control shipping-field"
                        value="{{ $credit_note->shipping_info }}" {{ $ro }} 
                        {{ ($credit_note->shipping_info || $credit_note->shipping_attention || $credit_note->shipping_address) ? '' : 'disabled' }}>

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
                    <input type="text" name="shipping_attention" id="shipping_attention" class="form-control shipping-field"
                        value="{{ $credit_note->shipping_attention }}" {{ $ro }}
                        {{ ($credit_note->shipping_info || $credit_note->shipping_attention || $credit_note->shipping_address) ? '' : 'disabled' }}>

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
                    <textarea name="shipping_address" id="shipping_address" class="form-control shipping-field" {{ $ro }}
                        {{ ($credit_note->shipping_info || $credit_note->shipping_attention || $credit_note->shipping_address) ? '' : 'disabled' }}>{{ $credit_note->shipping_address }}</textarea>

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
    <button type="button" class="btn btn-primary mb-3" id="select-invoice-btn" 
        data-index-route="{{ route('invoices.index') }}?format=json"
        data-details-route="{{ route('invoices.get-details', ['invoice_no' => ':invoice_no']) }}">Select Invoice</button>
    <div class="table-responsive" style="overflow-y: auto;">
        <table class="table table-hover table-bordered align-middle text-nowrap" id="invoice-items-table">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="text-center" style="width: 5%;">No</th>
                    <th scope="col" style="width: 10%;">Quantity</th>
                    <th scope="col" style="width: 40%;">Description</th>
                    <th scope="col" style="width: 10%;">Unit Price</th>
                    <th scope="col" style="width: 10%;">Amount</th>
                    <th scope="col" style="width: 10%;">Classification</th>
                    <th scope="col" style="width: 10%;">Tax</th>
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
                        <td>
                            <select name="items[{{ $index }}][classification_code]"
                                class="form-control item-classification" {{ $ro }}>
                                <option value=""> {{ 'Choose :' }}</option>
                                @foreach ($classifications as $classification)
                                    <option value="{{ $classification->classification_code }}"
                                        {{ $item->classification_code == $classification->classification_code ? 'selected' : '' }}>
                                        {{ $classification->classification_code }} -
                                        {{ $classification->description }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select name="items[{{ $index }}][tax_type]" class="form-control item-tax"
                            {{ $ro }}>
                            <option value=""> {{ 'Choose :' }}</option>
                            @foreach ($taxes as $tax)
                                <option value="{{ $tax->tax_type }}"
                                    data-tax-code="{{ $tax->tax_code }}" 
                                    data-tax-rate="{{ $tax->tax_rate }}"
                                    {{ $item->tax_type == $tax->tax_type ? 'selected' : '' }}>
                                    {{ $tax->tax_code }} - {{ $tax->tax_type }} ({{ $tax->tax_rate }}%)</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="items[{{ $index }}][tax_code]" class="item-tax-code" value="{{ $item->tax_code ?? '' }}">
                        <input type="hidden" name="items[{{ $index }}][tax_rate]" class="item-tax-rate" value="{{ $item->tax_rate ?? 0 }}">
                        <input type="hidden" name="items[{{ $index }}][tax_amount]" class="item-tax-amount" value="{{ $item->tax_amount ?? 0 }}">
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
                    <td style="width: 50%;">Total excluding Tax</td>
                    <td class="d-flex justify-content-between">RM <span id="excluding_tax">0</span></td>
                </tr>
                <tr>
                    <td style="width: 50%;">Tax amount</td>
                    <td class="d-flex justify-content-between">RM <span id="tax-amount">0</span></td>
                </tr>
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
            {{ $credit_note->control == '1' || $credit_note->control == 'draft' ? 'checked' : '' }} checked>
        <label class="btn btn-outline-primary" for="btnradio1">Draft</label>

        <input type="radio" class="btn-check" name="control" id="btnradio2" value="2" autocomplete="off"
            {{ $credit_note->control == '2' || $credit_note->control == 'pending' ? 'checked' : '' }}>
        <label class="btn btn-outline-primary" for="btnradio2">Pending</label>

        <input type="radio" class="btn-check" name="control" id="btnradio3" value="3" autocomplete="off"
            {{ $credit_note->control == '3' || $credit_note->control == 'ready' ? 'checked' : '' }}>
        <label class="btn btn-outline-primary" for="btnradio3">Ready</label>
    </div>
</div>

<script src="{{ asset('js/invoice-forms.js') }}"></script>

<!-- Invoice Selection Modal -->
<div class="modal fade" id="invoiceSelectionModal" tabindex="-1" aria-labelledby="invoiceSelectionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceSelectionModalLabel">Select Invoice</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <input type="text" id="invoice-search" class="form-control" placeholder="Search invoices...">
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle" id="invoice-selection-table" >
                        <thead class="thead-light">
                            <tr>
                                <th>Invoice No</th>
                                <th>Date</th>
                                <th>Customer</th>
                                <th>Subtotal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Will be populated dynamically -->
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <span id="showing-entries">Showing 0 to 0 of 0 entries</span>
                    </div>
                    <div>
                        <nav aria-label="Invoice pagination">
                            <ul class="pagination mb-0">
                                <li class="page-item disabled" id="prev-page">
                                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                                </li>
                                <li class="page-item disabled" id="next-page">
                                    <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
    
