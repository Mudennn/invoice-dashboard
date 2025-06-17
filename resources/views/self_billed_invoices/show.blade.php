@extends('layouts.dashboard', ['title' => 'Delete Self-Billed Invoice #' . $self_billed_invoice->invoice_no])

@section('content')
    <div>
        <div class="d-flex flex-column gap-2 form-header-container">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <h2>Delete Self-Billed Invoice</h2>
            <p>Delete the self-billed invoice for your supplier</p>
        </div>
        <hr>
        <form action="{{ route('self_billed_invoices.destroy', $self_billed_invoice->id) }}" method="POST">
            @csrf
            @method('DELETE')

            @include('self_billed_invoices.form')
            <hr>
            <div style="padding: 32px 32px 16px 32px;">
                <div class="alert alert-danger" role="alert">
                    Are you sure want to delete?
                </div>
            </div>

            <div class="form-button-container">
                <button type="submit" class="delete-button" id="btnSubmit">Delete Self-Billed Invoice</button>
            </div>
        </form>
    </div>
@endsection
