@extends('layouts.dashboard' , ['title' => 'Edit Company Profile'])

@section('content')
    <div>
        <div class="d-flex flex-column gap-2 form-header-container">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <h2>Edit Company Profile</h2>
            <p>Edit the company profile for your company</p>
        </div>
        <hr>
        <form action="{{ route('company_profile.update', $company_profile->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            @include('company_profile.form')
            <hr>
            <div class="form-button-container">
                <button type="submit" class="primary-button" id="btnSubmit">Save Company Profile</button>
            </div>
        </form>
    </div>
@endsection
