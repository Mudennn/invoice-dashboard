@extends('layouts.dashboard')

@section('content')
    <div>
        <div class="d-flex flex-column gap-2" style="padding: 40px;">
            <h2>Edit Company Profile</h2>
            <p>Edit the company profile for your company</p>
        </div>
        <hr>
        <form  method="POST" method="POST" enctype="multipart/form-data">
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
