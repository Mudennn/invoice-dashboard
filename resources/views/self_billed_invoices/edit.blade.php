@extends('layouts.dashboard', ['title' => 'Edit Self-Billed Invoice #' . $self_billed_invoice->self_billed_invoice_no])

@section('content')
    <div>
        <div class="d-flex flex-column gap-2 form-header-container">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <h2>Edit Self-Billed Invoice</h2>
            <p>Edit the self-billed invoice for your supplier</p>
        </div>
        <hr>
        <form action="{{ route('self_billed_invoices.update', $self_billed_invoice->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            @include('self_billed_invoices.form')
            <hr>
            <div class="form-button-container">
                <button type="submit" class="primary-button" id="btnSubmit">Update Self-Billed Invoice</button>
            </div>
        </form>
    </div>
@endsection
