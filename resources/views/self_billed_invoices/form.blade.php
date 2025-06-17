<input type="hidden" name="id" value="{{ $self_billed_invoice->id }}">
<input type="hidden" name="self_billed_invoice_uuid" value="{{ $self_billed_invoice->self_billed_invoice_uuid ?? Str::uuid()->toString() }}">

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
        <p class="sub-text">Billing information for the self-billed invoice</p>
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
                            @if ($self_billed_invoice->customer)
                                <option value="{{ $customer }}"
                                    {{ $customer == $self_billed_invoice->customer ? 'selected' : '' }}>{{ $customer }}</option>
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
                                {{ ($self_billed_invoice->shipping_info || $self_billed_invoice->shipping_attention || $self_billed_invoice->shipping_address) ? 'checked' : '' }}>
                            <label class="form-check-label" for="enable-shipping">
                                Enable Shipping
                            </label>
                        </div>
                    </div>
                    <input type="text" name="shipping_info" id="shipping_info" class="form-control shipping-field"
                        value="{{ $self_billed_invoice->shipping_info }}" {{ $ro }} 
                        {{ ($self_billed_invoice->shipping_info || $self_billed_invoice->shipping_attention || $self_billed_invoice->shipping_address) ? '' : 'disabled' }}>

                    @error('shipping_info')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="billing_attention" class="form-lable">Billing Attention</label>
                    <input type="text" name="billing_attention" class="form-control"
                        value="{{ $self_billed_invoice->billing_attention }}" {{ $ro }}>

                    @error('billing_attention')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="shipping_attention" class="form-lable">Shipping Attention</label>
                    <input type="text" name="shipping_attention" id="shipping_attention" class="form-control shipping-field"
                        value="{{ $self_billed_invoice->shipping_attention }}" {{ $ro }}
                        {{ ($self_billed_invoice->shipping_info || $self_billed_invoice->shipping_attention || $self_billed_invoice->shipping_address) ? '' : 'disabled' }}>

                    @error('shipping_attention')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="billing_address" class="form-lable">Billing Address</label>
                    <textarea name="billing_address" class="form-control" {{ $ro }}>{{ $self_billed_invoice->billing_address }}</textarea>

                    @error('billing_address')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="shipping_address" class="form-lable">Shipping Address</label>
                    <textarea name="shipping_address" id="shipping_address" class="form-control shipping-field" {{ $ro }}
                        {{ ($self_billed_invoice->shipping_info || $self_billed_invoice->shipping_attention || $self_billed_invoice->shipping_address) ? '' : 'disabled' }}>{{ $self_billed_invoice->shipping_address }}</textarea>

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
                    <label for="self_billed_invoice_no" class="form-lable">Invoice Number</label>
                    <input type="text" name="self_billed_invoice_no" class="form-control"
                        value="{{$self_billed_invoice->self_billed_invoice_no }}" {{ $ro }}>

                    @error('self_billed_invoice_no')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror

                </div>
                <div class="w-100">
                    <label for="reference_number" class="form-lable">Reference Number</label>
                    <input type="text" name="reference_number" class="form-control"
                        value="{{ $self_billed_invoice->reference_number }}" {{ $ro }}>

                    @error('reference_number')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="self_billed_invoice_date" class="form-lable">Date</label>
                    <input type="date" name="self_billed_invoice_date" class="form-control"
                        value="{{ old('self_billed_invoice_date', isset($self_billed_invoice->self_billed_invoice_date) ? \Carbon\Carbon::parse($self_billed_invoice->self_billed_invoice_date)->format('Y-m-d') : now()->timezone('Asia/Kuala_Lumpur')->format('Y-m-d')) }}">

                    @error('self_billed_invoice_date')
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
                        value="{{ $self_billed_invoice->description }}" {{ $ro }}>

                    @error('description')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="internal_note" class="form-lable">Internal Note</label>
                    <input type="text" name="internal_note" class="form-control"
                        value="{{ $self_billed_invoice->internal_note }}" {{ $ro }}>

                    @error('internal_note')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="tags" class="form-lable">Tags</label>
                    <input type="text" name="tags" class="form-control" value="{{ $self_billed_invoice->tags }}"
                        {{ $ro }}>

                    @error('tags')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="title" class="form-lable">Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $self_billed_invoice->title }}"
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
                @if(isset($self_billed_invoice->selfBilledInvoiceItems) && count($self_billed_invoice->selfBilledInvoiceItems) > 0)
                    @foreach($self_billed_invoice->selfBilledInvoiceItems as $index => $item)
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
            {{$self_billed_invoice->control == '1' || $self_billed_invoice->control == 'draft' ? 'checked' : '' }} checked>
        <label class="btn btn-outline-primary" for="btnradio1">Draft</label>

        <input type="radio" class="btn-check" name="control" id="btnradio2" value="2" autocomplete="off"
            {{ $self_billed_invoice->control == '2' || $self_billed_invoice->control == 'pending' ? 'checked' : '' }}>
        <label class="btn btn-outline-primary" for="btnradio2">Pending</label>

        <input type="radio" class="btn-check" name="control" id="btnradio3" value="3" autocomplete="off"
            {{ $self_billed_invoice->control == '3' || $self_billed_invoice->control == 'ready' ? 'checked' : '' }}>
        <label class="btn btn-outline-primary" for="btnradio3">Ready</label>
    </div>
</div>

<script src="{{ asset('js/invoice-forms.js') }}"></script>
    
