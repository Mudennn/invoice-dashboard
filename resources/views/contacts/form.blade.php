{{-- Shipping Information --}}
<div class="input-form form-input-container">
    <div class="d-flex flex-column gap-2 mb-4">
        <h3>Company Information</h3>
        <p class="sub-text">Company information for the contact</p>
    </div>

    <div class="row-form-input mb-2">
        <div class="d-flex flex-column gap-1">
            <label for="entity_type" class="form-lable">Entity Type</label>
            <div class="btn-group col-12" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" name="entity_type" id="btnradio1" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio1">Company</label>

                <input type="radio" class="btn-check" name="entity_type" id="btnradio2" autocomplete="off" checked>
                <label class="btn btn-outline-primary" for="btnradio2">Individual</label>

                <input type="radio" class="btn-check" name="entity_type" id="btnradio3" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio3">General Public</label>

                <input type="radio" class="btn-check" name="entity_type" id="btnradio4" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio4">Foreign Company</label>

                <input type="radio" class="btn-check" name="entity_type" id="btnradio5" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio5">Foreign Individual</label>

                <input type="radio" class="btn-check" name="entity_type" id="btnradio6" autocomplete="off">
                <label class="btn btn-outline-primary" for="btnradio6">Exempted Person</label>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column gap-3">
        <div class="row-form-input">
            <div class="col-12 col-md-5 col-lg-3">
                <label for="company_name" class="form-lable">Company Name</label>
                <input type="text" name="company_name" class="form-control">

                @error('company_name')
                    <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                @enderror

            </div>

            <div class="col-12 col-md-5 col-lg-3">
                <label for="other_name" class="form-lable">Other Name</label>
                <input type="text" name="other_name" class="form-control">

                @error('other_name')
                    <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="row-form-input">
            <div class="d-flex flex-column gap-1">
                <label for="registration_number_type" class="form-lable">Registration Number Type</label>
                <div class="btn-group col-3" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btnradio1">None</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" checked>
                    <label class="btn btn-outline-primary" for="btnradio2">BRN</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btnradio3">NRIC</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio4" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btnradio4">Passport</label>

                    <input type="radio" class="btn-check" name="btnradio" id="btnradio5" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btnradio5">Army</label>
                </div>
            </div>
        </div>

        <div class="row-form-input">
            <div class="col-12 col-md-5 col-lg-3">
                <label for="registration_number" class="form-lable">Registration Number</label>
                <input type="text" name="registration_number" class="form-control">

                @error('registration_number')
                    <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                @enderror
            </div>

            <div class="col-12 col-md-5 col-lg-3">
                <label for="old_registration_number" class="form-lable">Old Registration Number</label>
                <input type="text" name="old_registration_number" class="form-control">

                @error('old_registration_number')
                    <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="row-form-input">
            <div class="col-12 col-md-5 col-lg-3">
                <label for="tin" class="form-lable">TIN</label>
                <input type="text" name="tin" class="form-control">

                @error('tin')
                    <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                @enderror
            </div>

            <div class="col-12 col-md-5 col-lg-3">
                <label for="sst_registration_number" class="form-lable">SST Registration Number</label>
                <input type="text" name="sst_registration_number" class="form-control">

                @error('sst_registration_number')
                    <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>

<hr>

{{-- General Information --}}
<div class="input-form form-input-container">
    <div class="d-flex flex-column gap-2 mb-4">
        <h3>Contact Person</h3>
        <p class="sub-text">Contact person for the company</p>
    </div>

    <div class="d-flex flex-column gap-3">
        <div class="row-form">
            <div class="col-12 col-md-5 col-lg-3 row-form-container">
                <div>
                    <label for="name" class="form-lable">Name</label>
                    <input type="text" name="name" class="form-control">
    
                    @error('name')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
    
                </div>
                <div>
                    <label for="email" class="form-lable">Email</label>
                    <input type="email" name="email" class="form-control">
    
                    @error('email')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>
    
            <div class="col-12 col-md-5 col-lg-3 row-form-container">
                <div>
                    <label for="phone" class="form-lable">Phone</label>
                    <input type="text" name="phone" class="form-control">
    
                    @error('phone')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <button class="primary-button">Add Contact</button>
    
    </div>
</div>

<hr>

{{-- Address Information --}}
<div class="input-form form-input-container">
    <div class="d-flex flex-column gap-2 mb-4">
        <h3>Address Information</h3>
        <p class="sub-text">Address information for the contact</p>
    </div>
    <div class="col-12 col-md-5 col-lg-6 row-form-container mb-3">
        <div>
            <label for="address_line_1" class="form-lable">Address Line 1</label>
            <input type="text" name="address_line_1" class="form-control">

            @error('address_line_1')
                <span class="text-danger font-weight-bold small"># {{ $message }}</span>
            @enderror

        </div>
        <div>
            <label for="address_line_2" class="form-lable">Address Line 2</label>
            <input type="text" name="address_line_2" class="form-control">

            @error('address_line_2')
                <span class="text-danger font-weight-bold small"># {{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="d-flex flex-column gap-3">
    <div class="row-form-input">
        <div class="col-12 col-md-5 col-lg-3">
            <label for="city" class="form-lable">City</label>
            <input type="text" name="city" class="form-control">

            @error('city')
                <span class="text-danger font-weight-bold small"># {{ $message }}</span>
            @enderror

        </div>

        <div class="col-12 col-md-5 col-lg-3">
            <label for="postcode" class="form-lable">Postcode</label>
            <input type="text" name="postcode" class="form-control">

            @error('postcode')
                <span class="text-danger font-weight-bold small"># {{ $message }}</span>
            @enderror
        </div>
    </div>
    
    <div class="row-form-input">
        <div class="col-12 col-md-5 col-lg-3">
            <label for="country" class="form-lable">Country</label>
            <input type="text" name="country" class="form-control">

            @error('country')
                <span class="text-danger font-weight-bold small"># {{ $message }}</span>
            @enderror

        </div>

        <div class="col-12 col-md-5 col-lg-3">
            <label for="state" class="form-lable">State</label>
            <input type="text" name="state" class="form-control">

            @error('state')
                <span class="text-danger font-weight-bold small"># {{ $message }}</span>
            @enderror
        </div>
    </div>        
</div>
</div>