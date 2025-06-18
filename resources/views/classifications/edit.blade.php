@extends('layouts.dashboard', ['title' => 'Edit Classification #' . $classification->classification_code])

@section('content')

<div class="form-container pt-4 px-4">
    <div>
        <div class="d-flex flex-column gap-2 form-header-container">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <h2>Edit Classification</h2>
            <p>Edit the classification for your customer</p>
        </div>
        <hr>
        <form action="{{ route('classifications.update', $classification->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            @include('classifications.form')
            <hr>
            <div class="form-button-container">
                <button type="submit" class="primary-button" id="btnSubmit">Update Classification</button>
            </div>
        </form>
    </div>
</div>
@endsection
