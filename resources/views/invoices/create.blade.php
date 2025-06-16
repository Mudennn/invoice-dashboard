@extends('layouts.dashboard', ['title' => 'New Invoice'])

@section('content')
    <div class="relative">
        <div class="d-flex flex-column gap-2 form-header-container">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <h2>New Invoice</h2>
            <p>Create a new invoice for your customer</p>
        </div>
        <hr>
        <form action="{{ route('invoices.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('invoices.form')

            <div class="form-button-container">
                <button type="submit" class="primary-button" id="btnSubmit">Create Invoice</button>
            </div>
        </form>
    </div>
@endsection
