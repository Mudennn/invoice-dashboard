@extends('layouts.dashboard')

@section('content')
    <div>
        <div class="d-flex flex-column gap-2 form-header-container">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <h2>Edit Invoice</h2>
            <p>Edit the invoice for your customer</p>
        </div>
        <hr>
        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            @include('invoices.form')
            <hr>
            <div class="form-button-container">
                <button type="submit" class="primary-button" id="btnSubmit">Update Invoice</button>
            </div>
        </form>
    </div>
@endsection
