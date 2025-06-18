@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="list-unstyled mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<input type="hidden" name="id" value="{{ $classification->id }}">

<div class="form-input-container">
    <div class="input-container">
        <div class="left-container">
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <div class="input-form">
                        <label class="form-label">Classification Code</label>
                        <input type="text" name="classification_code" value="{{ old('classification_code') ?? $classification->classification_code }}"
                            class="form-control" {{ $ro }}>

                        @error('classification_code')
                            <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="w-100">
                    <div class="input-form">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control" placeholder=""
                            value="{{ old('description', isset($classification->description) ? $classification->description : '') }}"
                            {{ $ro }}>

                        @error('description')
                            <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="right-container"></div>
    </div>
</div>
