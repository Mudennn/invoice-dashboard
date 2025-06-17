@extends('layouts.dashboard' , ['title' => 'Company Profile'])

@section('content')
    <div style="padding: 40px;">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-2xl font-bold">Company Profile</h2>
            @if(!$company_profile)
                <a href="{{ route('company_profile.create') }}" class="primary-button">Create</a>
            @else
                <a href="{{ route('company_profile.edit', $company_profile->id) }}" class="primary-button">Edit</a>
            @endif
        </div>
        <div class="profile-detail-content">
            <div class="name-box">

                @if ($company_profile->getFirstMediaUrl('is_image'))
                    <img src="{{ $company_profile->getFirstMediaUrl('is_image') }}" alt=""
                        style="width: 80px; height: 80px; object-fit: cover" class="rounded-circle">
                @else
                    <div
                        style="width: 80px; height: 80px; border-radius: 50%; background-color: #f0f0f0; display: flex; justify-content: center; align-items: center;">
                        <span class="material-symbols-outlined">
                            person
                        </span>
                    </div>
                @endif
                <div class="id">
                    <h3>{{ $company_profile->company_name }}</h3>
                </div>
            </div>
            <div class="personal-information">
                <h3>Personal Information</h3>
                <div class="personal-information-details">
                    <div class="email-phone-container">
                        <div class="email-detail">
                            <h4>Email</h4>
                            <p>{{ $company_profile->email }}</p>
                        </div>

                        <div class="phone-detail">
                            <h4>Phone</h4>
                            <p>{{ $company_profile->phone }}</p>
                        </div>

                    </div>
                </div>

            </div>
            <div class="address-information">
                <h3>Business Information</h3>
                <div class="address-information-details">
                    <div class="city-state-container">
                        <div class="address-detail">
                            <h4>Registration Number</h4>
                            <p>{{ $company_profile->registration_no }} ({{ $company_profile->registration_type_text }})</p>
                        </div>
                        <div class="state-detail">
                            <h4>Old Registration Number</h4>
                            <p>{{ $company_profile->old_registration_no }}</p>
                        </div>
                    </div>
                   
                    <div class="city-state-container">

                        <div class="city-detail">
                            <h4>TIN</h4>
                            <p>{{ $company_profile->tin }}</p>
                        </div>
                        <div class="state-detail">
                            <h4>SST Registration No</h4>
                            <p>{{ $company_profile->sst_registration_no }}</p>
                        </div>
                    </div>
                </div>

            </div>
           
            <div class="address-information">
                <h3>Address Information</h3>
                <div class="address-information-details">
                    <div class="address-postcode-container">

                        <div class="address-detail">
                            <h4>Address</h4>
                            <p>{{ $company_profile->address_line_1 }} <br> {{ $company_profile->address_line_2 }} </p>
                        </div>

                        <div class="postcode-detail">
                            <h4>Postocede</h4>
                            <p>{{ $company_profile->postcode }}</p>
                        </div>
                    </div>

                    <div class="city-state-container">

                        <div class="city-detail">
                            <h4>City</h4>
                            <p>{{ $company_profile->city }}</p>
                        </div>
                        <div class="state-detail">
                            <h4>State</h4>
                            <p>{{ $company_profile->s_state }}</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
