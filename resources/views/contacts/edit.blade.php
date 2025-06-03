@extends('layouts.dashboard')

@section('content')
    <div>
        <div class="d-flex flex-column gap-2" style="padding: 40px;">
            <h2>New Invoice</h2>
            <p>Create a new invoice for your customer</p>
        </div>
        <hr>
        <form action="{{ route('contacts.update', $customer_profile->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            @include('contacts.form')
            <hr>
            <div class="form-button-container">
                <button type="submit" class="primary-button" id="btnSubmit">Update Contact</button>
            </div>
        </form>
    </div>
@endsection
