@extends('layouts.dashboard', ['title' => 'New Credit Note'])

@section('content')
    <div class="relative">
        <div class="d-flex flex-column gap-2 form-header-container">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <h2>New Credit Note</h2>
            <p>Create a new credit note for your customer</p>
        </div>
        <hr>
        <form action="{{ route('credit_notes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('credit_notes.form')

            <div class="form-button-container">
                <button type="submit" class="primary-button" id="btnSubmit">Create Credit Note</button>
            </div>
        </form>
    </div>
@endsection
