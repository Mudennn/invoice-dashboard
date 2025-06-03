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
                    <input type="text" name="customer" class="form-control">

                    @error('customer')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror

                </div>
                <div class="w-100">
                    <label for="shipping_info" class="form-lable">Shipping Info</label>
                    <input type="text" name="shipping_info" class="form-control">

                    @error('shipping_info')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="billing_attention" class="form-lable">Billing Attention</label>
                    <input type="text" name="billing_attention" class="form-control">

                    @error('billing_attention')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="shipping_attention" class="form-lable">Shipping Attention</label>
                    <input type="text" name="shipping_attention" class="form-control">

                    @error('shipping_attention')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="billing_address" class="form-lable">Billing Address</label>
                    <textarea name="billing_address" class="form-control"></textarea>

                    @error('billing_address')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="shipping_address" class="form-lable">Shipping Address</label>
                    <textarea name="shipping_address" class="form-control"></textarea>

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
                    <label for="invoice_number" class="form-lable">Invoice Number</label>
                    <input type="text" name="invoice_number" class="form-control">

                    @error('invoice_number')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror

                </div>
                <div class="w-100">
                    <label for="reference_number" class="form-lable">Reference Number</label>
                    <input type="text" name="reference_number" class="form-control">

                    @error('reference_number')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="date" class="form-lable">Date</label>
                    <input type="date" name="date" class="form-control">

                    @error('date')
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
                    <input type="text" name="description" class="form-control">
    
                    @error('description')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="internal_note" class="form-lable">Internal Note</label>
                    <input type="text" name="internal_note" class="form-control">
    
                    @error('internal_note')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="tags" class="form-lable">Tags</label>
                    <input type="text" name="tags" class="form-control">
    
                    @error('tags')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="title" class="form-lable">Title</label>
                    <input type="text" name="title" class="form-control">
    
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
        <table class="table table-hover table-bordered align-middle text-nowrap">
            <thead class="thead-light">
                <tr>
                    <th scope="col" class="text-center" style="width: 5%;">No</th>
                    <th scope="col" style="width: 10%;">Quantity</th>
                    <th scope="col" style="width: 40%;">Description</th>
                    <th scope="col" style="width: 10%;">Unit Price</th>
                    <th scope="col" style="width: 10%;">Amount</th>
                    <th scope="col" style="width: 5%;">Actions</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start w-100 mt-4 mt-md-0 gap-4 gap-md-0">
        <button class="primary-button">Add Item</button>
        <table class="table table-bordered align-middle text-nowrap table-footer">
            <tbody>
                <tr>
                    <td style="width: 50%;">Sub Total</td>
                    <td class="d-flex justify-content-between">RM <span>0.00</span></td>
                </tr>
                <tr>
                    <td class="fw-bold" style="width: 50%;">TOTAL</td>
                    <td class="d-flex justify-content-between">RM <span>0.00</span></td>
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
        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
        <label class="btn btn-outline-primary" for="btnradio1">Draft</label>
      
        <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
        <label class="btn btn-outline-primary" for="btnradio2">Pending</label>
      
        <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
        <label class="btn btn-outline-primary" for="btnradio3">Ready</label>
      </div>
</div>
