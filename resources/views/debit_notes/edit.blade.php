@extends('layouts.dashboard', ['title' => 'Edit Debit Note #' . $debit_note->debit_note_no])

@section('content')
    <div>
        <div class="d-flex flex-column gap-2 form-header-container">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <h2>Edit Debit Note</h2>
            <p>Edit the debit note for your customer</p>
        </div>
        <hr>
        <form action="{{ route('debit_notes.update', $debit_note->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            @include('debit_notes.form')
            <hr>
            <div class="form-button-container">
                <button type="submit" class="primary-button" id="btnSubmit">Update Debit Note</button>
            </div>
        </form>
    </div>
@endsection
