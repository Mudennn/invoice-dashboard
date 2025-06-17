@extends('layouts.dashboard', ['title' => 'Delete Debit Note #' . $debit_note->debit_note_no])

@section('content')
    <div>
        <div class="d-flex flex-column gap-2 form-header-container">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <h2>Delete Debit Note</h2>
            <p>Delete the debit note for your customer</p>
        </div>
        <hr>
        <form action="{{ route('debit_notes.destroy', $debit_note->id) }}" method="POST">
            @csrf
            @method('DELETE')

            @include('debit_notes.form')
            <hr>
            <div style="padding: 32px 32px 16px 32px;">
                <div class="alert alert-danger" role="alert">
                    Are you sure want to delete?
                </div>
            </div>

            <div class="form-button-container">
                <button type="submit" class="delete-button" id="btnSubmit">Delete Debit Note</button>
            </div>
        </form>
    </div>
@endsection
