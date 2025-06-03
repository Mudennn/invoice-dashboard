@extends('layouts.dashboard')

@section('content')
    <div class="relative">
        <div class="d-flex flex-column gap-2 form-header-container">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <h2>New Contact</h2>
            <p>Create a new contact for your company</p>
        </div>
        <hr>
        <form action="{{ route('contacts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('contacts.form')

            <div class="form-button-container">
                <button type="submit" class="primary-button" id="btnSubmit">Save Contact</button>
            </div>
        </form>
    </div>
@endsection
