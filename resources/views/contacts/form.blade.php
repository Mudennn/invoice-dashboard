<input type="hidden" name="id" value="{{ $customer_profile->id }}">

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="list-unstyled mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Shipping Information --}}
<div class="input-form form-input-container">
    <div class="d-flex flex-column gap-2 mb-4">
        <h3>Company Information</h3>
        <p class="sub-text">Company information for the contact</p>
    </div>

    <div class="input-container">
        <div class="left-container">
            <div class="row-form-input mb-2">
                <div class="d-flex flex-column gap-1">
                    <label for="entity_type" class="form-lable">Entity Type</label>
                    <div class="btn-group col-12" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="entity_type" id="entity1" value="1" autocomplete="off" {{ $customer_profile->entity_type == '1' || $customer_profile->entity_type == 'Company' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="entity1">Company</label>

                        <input type="radio" class="btn-check" name="entity_type" id="entity2" value="2" autocomplete="off" {{ $customer_profile->entity_type == '2' || $customer_profile->entity_type == 'Individual' ? 'checked' : '' }} checked>
                        <label class="btn btn-outline-primary" for="entity2">Individual</label>

                        <input type="radio" class="btn-check" name="entity_type" id="entity3" value="3" autocomplete="off" {{ $customer_profile->entity_type == '3' || $customer_profile->entity_type == 'General Public' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="entity3">General Public</label>

                        <input type="radio" class="btn-check" name="entity_type" id="entity4" value="4" autocomplete="off" {{ $customer_profile->entity_type == '4' || $customer_profile->entity_type == 'Foreign Company' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="entity4">Foreign Company</label>

                        <input type="radio" class="btn-check" name="entity_type" id="entity5" value="5" autocomplete="off" {{ $customer_profile->entity_type == '5' || $customer_profile->entity_type == 'Foreign Individual' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="entity5">Foreign Individual</label>

                        <input type="radio" class="btn-check" name="entity_type" id="entity6" value="6" autocomplete="off" {{ $customer_profile->entity_type == '6' || $customer_profile->entity_type == 'Exempted Person' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="entity6">Exempted Person</label>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="customer_name" class="form-lable">Company Name</label>
                    <input type="text" name="customer_name" class="form-control" value="{{ $customer_profile->customer_name }}" {{ $ro }}>

                    @error('customer_name')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
                <div class="w-100">
                    <label for="other_name" class="form-lable">Other Name</label>
                    <input type="text" name="other_name" class="form-control" value="{{ $customer_profile->other_name }}" {{ $ro }}>
    
                    @error('other_name')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row-form-input">
                <div class="d-flex flex-column gap-1">
                    <label for="registration_number_type" class="form-lable">Registration Number Type</label>
                    <div class="btn-group col-3" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="registration_number_type" id="regtype1" value="1" autocomplete="off" {{ $customer_profile->registration_number_type == '1' || $customer_profile->registration_number_type == 'None' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="regtype1">None</label>
    
                        <input type="radio" class="btn-check" name="registration_number_type" id="regtype2" value="2" autocomplete="off" {{ $customer_profile->registration_number_type == '2' || $customer_profile->registration_number_type == 'BRN' ? 'checked' : '' }} checked>
                        <label class="btn btn-outline-primary" for="regtype2">BRN</label>
    
                        <input type="radio" class="btn-check" name="registration_number_type" id="regtype3" value="3" autocomplete="off" {{ $customer_profile->registration_number_type == '3' || $customer_profile->registration_number_type == 'NRIC' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="regtype3">NRIC</label>
    
                        <input type="radio" class="btn-check" name="registration_number_type" id="regtype4" value="4" autocomplete="off" {{ $customer_profile->registration_number_type == '4' || $customer_profile->registration_number_type == 'Passport' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="regtype4">Passport</label>
    
                        <input type="radio" class="btn-check" name="registration_number_type" id="regtype5" value="5" autocomplete="off" {{ $customer_profile->registration_number_type == '5' || $customer_profile->registration_number_type == 'Army' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="regtype5">Army</label>
                    </div>
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="registration_number" class="form-lable">Registration Number</label>
                    <input type="text" name="registration_number" class="form-control" value="{{ $customer_profile->registration_number }}" {{ $ro }}>
    
                    @error('registration_number')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
    
                <div class="w-100">
                    <label for="old_registration_number" class="form-lable">Old Registration Number</label>
                    <input type="text" name="old_registration_number" class="form-control" value="{{ $customer_profile->old_registration_number }}" {{ $ro }}>
    
                    @error('old_registration_number')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="tin" class="form-lable">TIN</label>
                    <input type="text" name="tin" class="form-control" value="{{ $customer_profile->tin }}" {{ $ro }}>
    
                    @error('tin')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
    
                <div class="w-100">
                    <label for="sst_registration_number" class="form-lable">SST Registration Number</label>
                    <input type="text" name="sst_registration_number" class="form-control" value="{{ $customer_profile->sst_registration_number }}" {{ $ro }}>
    
                    @error('sst_registration_number')
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
        <h3>Contact Person</h3>
        <p class="sub-text">Contact person for the company</p>
    </div>

    <div class="input-container">
        <div class="left-container">
            <!-- Primary Contact (Always visible) -->
            <div id="contact-person-1" class="contact-person mb-3">
                <h5>Primary Contact</h5>
                <div class="d-flex flex-column flex-md-row gap-4 w-100">
                    <div class="w-100">
                        <label for="contact_name_1" class="form-lable">Name</label>
                        <input type="text" name="contact_name_1" class="form-control" value="{{ $customer_profile->contact_name_1 }}" {{ $ro }}>

                        @error('contact_name_1')
                            <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-100">
                        <label for="email_1" class="form-lable">Email</label>
                        <input type="email" name="email_1" class="form-control" value="{{ $customer_profile->email_1 }}" {{ $ro }}>

                        @error('email_1')
                            <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="d-flex flex-column flex-md-row gap-4 w-100 mt-3">
                    <div class="w-100">
                        <label for="contact_1" class="form-lable">Phone</label>
                        <input type="text" name="contact_1" class="form-control" value="{{ $customer_profile->contact_1 }}" {{ $ro }}>

                        @error('contact_1')
                            <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-100"></div>
                </div>
            </div>

            <!-- Second Contact (Initially hidden if no data) -->
            <div id="contact-person-2" class="contact-person mb-3" style="{{ $customer_profile->contact_name_2 ? '' : 'display: none;' }}">
                <hr>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h5>Secondary Contact</h5>
                    <button type="button" class="btn btn-sm btn-danger remove-contact" data-contact="2">Remove</button>
                </div>
                <div class="d-flex flex-column flex-md-row gap-4 w-100">
                    <div class="w-100">
                        <label for="contact_name_2" class="form-lable">Name</label>
                        <input type="text" name="contact_name_2" class="form-control" value="{{ $customer_profile->contact_name_2 }}" {{ $ro }}>

                        @error('contact_name_2')
                            <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-100">
                        <label for="email_2" class="form-lable">Email</label>
                        <input type="email" name="email_2" class="form-control" value="{{ $customer_profile->email_2 }}" {{ $ro }}>

                        @error('email_2')
                            <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="d-flex flex-column flex-md-row gap-4 w-100 mt-3">
                    <div class="w-100">
                        <label for="contact_2" class="form-lable">Phone</label>
                        <input type="text" name="contact_2" class="form-control" value="{{ $customer_profile->contact_2 }}" {{ $ro }}>

                        @error('contact_2')
                            <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-100"></div>
                </div>
            </div>

            <!-- Third Contact (Initially hidden if no data) -->
            <div id="contact-person-3" class="contact-person mb-3" style="{{ $customer_profile->contact_name_3 ? '' : 'display: none;' }}">
                <hr>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <h5>Additional Contact</h5>
                    <button type="button" class="btn btn-sm btn-danger remove-contact" data-contact="3">Remove</button>
                </div>
                <div class="d-flex flex-column flex-md-row gap-4 w-100">
                    <div class="w-100">
                        <label for="contact_name_3" class="form-lable">Name</label>
                        <input type="text" name="contact_name_3" class="form-control" value="{{ $customer_profile->contact_name_3 }}" {{ $ro }}>

                        @error('contact_name_3')
                            <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-100">
                        <label for="email_3" class="form-lable">Email</label>
                        <input type="email" name="email_3" class="form-control" value="{{ $customer_profile->email_3 }}" {{ $ro }}>

                        @error('email_3')
                            <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="d-flex flex-column flex-md-row gap-4 w-100 mt-3">
                    <div class="w-100">
                        <label for="contact_3" class="form-lable">Phone</label>
                        <input type="text" name="contact_3" class="form-control" value="{{ $customer_profile->contact_3 }}" {{ $ro }}>

                        @error('contact_3')
                            <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                        @enderror
                    </div>
                    <div class="w-100"></div>
                </div>
            </div>

            <button type="button" id="add-contact-btn" class="primary-button" {{ $ro ? 'disabled' : '' }}>Add Contact</button>
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
                <input type="text" name="address_line_1" class="form-control" value="{{ $customer_profile->address_line_1 }}" {{ $ro }}>
    
                @error('address_line_1')
                    <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                @enderror
    
            </div>
            <div class="w-100">
                <label for="address_line_2" class="form-lable">Address Line 2</label>
                <input type="text" name="address_line_2" class="form-control" value="{{ $customer_profile->address_line_2 }}" {{ $ro }}>
    
                @error('address_line_2')
                    <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                @enderror
            </div>

            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="city" class="form-lable">City</label>
                    <input type="text" name="city" class="form-control" value="{{ $customer_profile->city }}" {{ $ro }}>
    
                    @error('city')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
    
                </div>
    
                <div class="w-100">
                    <label for="postcode" class="form-lable">Postcode</label>
                    <input type="text" name="postcode" class="form-control" value="{{ $customer_profile->postcode }}" {{ $ro }}>
    
                    @error('postcode')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="country" class="form-lable">Country</label>
                    <input type="text" name="country" class="form-control" value="{{ $customer_profile->country }}" {{ $ro }}>
    
                    @error('country')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
    
                </div>
    
                <div class="w-100">
                    <label for="state" class="form-lable">State</label>
                    <select name="state" id="state" class="form-control form-select" {{ $ro }}>
                        <option value=""> {{ 'Choose :' }}</option>
                        @foreach ($states as $state)
                            @if ($customer_profile->state)
                                <option value="{{ $state->id }}" {{ $state->id == $customer_profile->state ? 'selected' : '' }}>
                                    {{ $state->selection_data }}</option>
                            @else
                                <option value="{{ $state->id }}" {{ $state->id == old('state') ? 'selected' : '' }}>
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

{{-- Details Information --}}
<div class="input-form form-input-container">
    <div class="d-flex flex-column gap-2 mb-4">
        <h3>Details Information</h3>
        <p class="sub-text">Details information for the contact</p>
    </div>

    <div class="input-container">
        <div class="left-container">
            <div class="d-flex flex-column flex-md-row gap-4 w-100">
                <div class="w-100">
                    <label for="msic_code" class="form-lable">MSIC Code</label>
                    <select name="msic_code" id="msic_code" class="form-control form-select msic-select-input" {{ $ro }}>
                        <option value=""> {{ 'Choose :' }}</option>
                        @foreach ($msics as $msic)
                            @if ($customer_profile->msic_code)
                                <option value="{{ $msic->id }}" {{ $msic->id == $customer_profile->msic_code ? 'selected' : '' }}>
                                    {{ $msic->msic_code }} - {{ $msic->description }}</option>
                            @else
                                <option value="{{ $msic->id }}" {{ $msic->id == old('msic_code') ? 'selected' : '' }}>
                                    {{ $msic->msic_code }} - {{ $msic->description }}</option>
                            @endif
                        @endforeach
                    </select>
    
                    @error('msic_code')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
    
                </div>
    
                <div class="w-100">
                    <label for="company_description" class="form-lable">Company Description</label>
                    <textarea name="company_description" id="company_description" cols="30" rows="10" class="form-control" {{ $ro }}>{{ $customer_profile->company_description }}</textarea>
    
                    @error('company_description')
                        <span class="text-danger font-weight-bold small"># {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="right-container"></div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // initialize Select2 for msic code
        $('#msic_code').select2();

        const addContactBtn = document.getElementById('add-contact-btn');
        const contactPerson2 = document.getElementById('contact-person-2');
        const contactPerson3 = document.getElementById('contact-person-3');
        
        // Add contact button click handler
        addContactBtn.addEventListener('click', function() {
            // If contact person 2 is hidden, show it first
            if (contactPerson2.style.display === 'none') {
                contactPerson2.style.display = '';
                return;
            }
            
            // If contact person 3 is hidden, show it
            if (contactPerson3.style.display === 'none') {
                contactPerson3.style.display = '';
                // Disable the add button since we've reached the maximum
                addContactBtn.disabled = true;
                return;
            }
        });
        
        // Remove contact buttons click handlers
        document.querySelectorAll('.remove-contact').forEach(function(button) {
            button.addEventListener('click', function() {
                const contactNumber = this.getAttribute('data-contact');
                const contactElement = document.getElementById('contact-person-' + contactNumber);
                
                // Clear input values
                contactElement.querySelectorAll('input').forEach(function(input) {
                    input.value = '';
                });
                
                // Hide the contact section
                contactElement.style.display = 'none';
                
                // Re-enable the add button if it was disabled
                addContactBtn.disabled = false;
            });
        });
        
        // Check if we should enable/disable the add button on page load
        if (contactPerson2.style.display !== 'none' && contactPerson3.style.display !== 'none') {
            addContactBtn.disabled = true;
        }
    });
</script>
@endpush
