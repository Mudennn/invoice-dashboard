<input type="hidden" name="id" value="{{ $company_profile->id }}">

{{-- Shipping Information --}}
<div class="input-form form-input-container">
    <div class="d-flex flex-column gap-2 mb-4">
        <h3>Company Information</h3>
        <p class="sub-text">Company information for the contact</p>
    </div>

    <div class="input-container">
        <div class="left-container">
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="company_name" class="form-lable">Company Name</label>
                    <input type="text" name="company_name" class="form-control"
                        value="{{ $company_profile->company_name }}" {{ $ro }}>

                    @error('company_name')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="other_name" class="form-lable">Other Name</label>
                    <input type="text" name="other_name" class="form-control"
                        value="{{ $company_profile->other_name }}" {{ $ro }}>

                    @error('other_name')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row-form-input">
                <div class="d-flex flex-column gap-1">
                    <label for="registration_type" class="form-lable">Registration Number Type</label>
                    <div class="btn-group col-3" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="registration_type" id="regtype1" value="1"
                            autocomplete="off"
                            {{ $company_profile->registration_type == '1' || $company_profile->registration_type == 'None' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="regtype1">None</label>

                        <input type="radio" class="btn-check" name="registration_type" id="regtype2" value="2"
                            autocomplete="off"
                            {{ $company_profile->registration_type == '2' || $company_profile->registration_type == 'BRN' ? 'checked' : '' }}
                            checked>
                        <label class="btn btn-outline-primary" for="regtype2">BRN</label>

                        <input type="radio" class="btn-check" name="registration_type" id="regtype3" value="3"
                            autocomplete="off"
                            {{ $company_profile->registration_type == '3' || $company_profile->registration_type == 'NRIC' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="regtype3">NRIC</label>

                        <input type="radio" class="btn-check" name="registration_type" id="regtype4" value="4"
                            autocomplete="off"
                            {{ $company_profile->registration_type == '4' || $company_profile->registration_type == 'Passport' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="regtype4">Passport</label>

                        <input type="radio" class="btn-check" name="registration_type" id="regtype5" value="5"
                            autocomplete="off"
                            {{ $company_profile->registration_type == '5' || $company_profile->registration_type == 'Army' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="regtype5">Army</label>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="registration_no" class="form-lable">Registration Number</label>
                    <input type="text" name="registration_no" class="form-control"
                        value="{{ $company_profile->registration_no }}" {{ $ro }}>

                    @error('registration_no')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>

                <div class="w-100">
                    <label for="old_registration_no" class="form-lable">Old Registration Number</label>
                    <input type="text" name="old_registration_no" class="form-control"
                        value="{{ $company_profile->old_registration_no }}" {{ $ro }}>

                    @error('old_registration_no')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="tin" class="form-lable">TIN</label>
                    <input type="text" name="tin" class="form-control" value="{{ $company_profile->tin }}"
                        {{ $ro }}>

                    @error('tin')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>

                <div class="w-100">
                    <label for="sst_registration_no" class="form-lable">SST Registration Number</label>
                    <input type="text" name="sst_registration_no" class="form-control"
                        value="{{ $company_profile->sst_registration_no }}" {{ $ro }}>

                    @error('sst_registration_no')
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
        <h3>Comapany Contact</h3>
        <p class="sub-text">Contact person for the company</p>
    </div>

    <div class="input-container">
        <div class="left-container">
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="email" class="form-lable">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $company_profile->email }}"
                        {{ $ro }}>
                    @error('email')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="phone" class="form-lable">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ $company_profile->phone }}"
                        {{ $ro }}>

                    @error('phone')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="right-container"></div>
    </div>
</div>

<hr>

{{-- Address Information --}}
<div class="input-form form-input-container">
    <div class="d-flex flex-column gap-2 mb-4">
        <h3>Address Information</h3>
        <p class="sub-text">Address information for the contact</p>
    </div>

    <div class="input-container">
        <div class="left-container">
            <div class="w-100">
                <label for="address_line_1" class="form-lable">Address Line 1</label>
                <input type="text" name="address_line_1" class="form-control"
                    value="{{ $company_profile->address_line_1 }}" {{ $ro }}>

                @error('address_line_1')
                    <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                @enderror

            </div>
            <div class="w-100">
                <label for="address_line_2" class="form-lable">Address Line 2</label>
                <input type="text" name="address_line_2" class="form-control"
                    value="{{ $company_profile->address_line_2 }}" {{ $ro }}>

                @error('address_line_2')
                    <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                @enderror
            </div>

            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="city" class="form-lable">City</label>
                    <input type="text" name="city" class="form-control" value="{{ $company_profile->city }}"
                        {{ $ro }}>

                    @error('city')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror

                </div>

                <div class="w-100">
                    <label for="postcode" class="form-lable">Postcode</label>
                    <input type="text" name="postcode" class="form-control"
                        value="{{ $company_profile->postcode }}" {{ $ro }}>

                    @error('postcode')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="country" class="form-lable">Country</label>
                    <input type="text" name="country" class="form-control"
                        value="{{ $company_profile->country }}" {{ $ro }}>

                    @error('country')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror

                </div>

                <div class="w-100">
                    <label for="state" class="form-lable">State</label>
                    <select name="state" id="state" class="form-control form-select" {{ $ro }}>
                        <option value=""> {{ 'Choose :' }}</option>
                        @foreach ($states as $state)
                            @if ($company_profile->state)
                                <option value="{{ $state->id }}"
                                    {{ $state->id == $company_profile->state ? 'selected' : '' }}>
                                    {{ $state->selection_data }}</option>
                            @else
                                <option value="{{ $state->id }}"
                                    {{ $state->id == old('state') ? 'selected' : '' }}>
                                    {{ $state->selection_data }}</option>
                            @endif
                        @endforeach
                    </select>

                    @error('state')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="right-container"></div>
    </div>
</div>

<hr>
{{-- Address Information --}}
<div class="input-form form-input-container">
    <div class="d-flex flex-column gap-2 mb-4">
        <h3>Company Logo</h3>
        <p class="sub-text">Company logo for the company</p>
    </div>

    <div class="input-container">
        <div class="left-container">
            <div class="w-100">
                <label for="logo" class="form-lable">Logo</label>
                @if ($company_profile->is_image == 1)
                    <div class="mb-2">
                        <img src="{{ $company_profile->getFirstMediaUrl('is_image') }}" alt=""
                            style="width: 80px; height: 80px; object-fit: cover" class="rounded-circle">
                    </div>
                @endif
                <input type="file" name="is_image" value="{{ old('is_image') ?? $company_profile->is_image }}"
                    class="form-control" {{ $ro }}>
            </div>
        </div>
        <div class="right-container"></div>
    </div>
</div>
