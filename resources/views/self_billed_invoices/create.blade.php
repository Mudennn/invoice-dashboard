@extends('layouts.dashboard', ['title' => 'New Self-Billed Invoice'])

@section('content')
    <div class="relative">
        <div class="d-flex flex-column gap-2 form-header-container">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <h2>New Self-Billed Invoice</h2>
            <p>Create a new self-billed invoice for your supplier</p>
        </div>
        <hr>
        <form action="{{ route('self_billed_invoices.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('self_billed_invoices.form')

            <div class="form-button-container">
                <button type="submit" class="primary-button" id="btnSubmit">Create Self-Billed Invoice</button>
            </div>
        </form>
    </div>
@endsection
