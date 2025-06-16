@extends('layouts.dashboard', ['title' => 'Edit Credit Note #' . $credit_note->credit_note_no])

@section('content')
    <div>
        <div class="d-flex flex-column gap-2 form-header-container">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <h2>Edit Credit Note</h2>
            <p>Edit the credit note for your customer</p>
        </div>
        <hr>
        <form action="{{ route('credit_notes.update', $credit_note->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            @include('credit_notes.form')
            <hr>
            <div class="form-button-container">
                <button type="submit" class="primary-button" id="btnSubmit">Update Credit Note</button>
            </div>
        </form>
    </div>
@endsection
