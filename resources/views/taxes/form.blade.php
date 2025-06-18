@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="list-unstyled mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<input type="hidden" name="id" value="{{ $tax->id }}">

<div class="form-input-container">
    <div class="input-container">
        <div class="left-container">
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <div class="input-form">
                        <label class="form-label">Tax Code</label>
                        <input type="text" name="tax_code" value="{{ old('tax_code') ?? $tax->tax_code }}"
                            class="form-control" {{ $ro }}>

                        @error('tax_code')
                            <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="w-100">
                    <div class="input-form">
                        <label class="form-label">Tax Type</label>
                        <input type="text" name="tax_type" class="form-control" placeholder=""
                            value="{{ old('tax_type', isset($tax->tax_type) ? $tax->tax_type : '') }}"
                            {{ $ro }}>

                        @error('tax_type')
                            <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <div class="input-form">
                        <label class="form-label">Tax Rate</label>
                        <input type="text" name="tax_rate" class="form-control" placeholder=""
                            value="{{ old('tax_rate', isset($tax->tax_rate) ? $tax->tax_rate : '') }}"
                            {{ $ro }}>

                        @error('tax_rate')
                            <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="w-100">
                </div>
            </div>
        </div>
        <div class="right-container"></div>
    </div>
</div>
