@extends('layouts.dashboard')

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="list-unstyled mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <div>
        <div class="d-flex flex-column gap-2 form-header-container">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <h2>Edit Contact</h2>
            <p>Edit the contact for your company</p>
        </div>
        <hr>
        
        <form action="{{ route('contacts.update', $customer_profile->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            @include('contacts.form')
            <hr>
            <div class="form-button-container">
                <button type="submit" class="primary-button" id="btnSubmit">Update Contact</button>
            </div>
        </form>
    </hr>
@endsection
