@extends('layouts.dashboard', ['title' => 'Create Receipt'])

@section('content')
<div class="relative">
    <div class="d-flex flex-column gap-2 form-header-container">
        <a href="{{ url()->previous() }}" class="back-button mb-4">
            <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
            Back
        </a>
        <h2>New Receipt</h2>
        <p>Create a new receipt for your customer</p>
    </div>
    <hr>
    <form action="{{ route('receipts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('receipts.form')

        <div class="form-button-container">
            <button type="submit" class="primary-button" id="btnSubmit">Create Receipt</button>
        </div>
    </form>
</div>
@endsection