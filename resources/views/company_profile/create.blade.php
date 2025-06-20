@extends('layouts.dashboard')

@section('content')
    <div class="relative">
        <div class="d-flex flex-column gap-2 form-header-container">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <h2>New Company Profile</h2>
            <p>Create a new company profile for your company</p>
        </div>
        <hr>
        <form action="{{ route('company_profile.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('company_profile.form')

            <div class="form-button-container">
                <button type="submit" class="primary-button" id="btnSubmit">Save Company Profile</button>
            </div>
        </form>
    </div>
@endsection
