@extends('layouts.dashboard', ['title' => 'Create Classification'])

@section('content')
<div class="relative">
    <div class="d-flex flex-column gap-2 form-header-container">
        <a href="{{ url()->previous() }}" class="back-button mb-4">
            <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
            Back
        </a>
        <h2>New Classification</h2>
        <p>Create a new classification for your customer</p>
    </div>
    <hr>
    <form action="{{ route('classifications.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('classifications.form')

        <div class="form-button-container">
            <button type="submit" class="primary-button" id="btnSubmit">Create Classification</button>
        </div>
    </form>
</div>
@endsection