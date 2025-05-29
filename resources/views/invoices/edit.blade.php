@extends('layouts.dashboard')

@section('content')
    <div>
        <div class="d-flex flex-column gap-2" style="padding: 40px;">
            <h2>New Invoice</h2>
            <p>Create a new invoice for your customer</p>
        </div>
        <hr>
        <form  method="POST" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            @include('invoices.form')
            <hr>
            <div class="form-button-container">
                <button type="submit" class="primary-button" id="btnSubmit">Create Invoice</button>
                <a href="{{ route('invoices.index') }}" class="third-button">Cancel</a>
            </div>
        </form>
    </div>
@endsection
