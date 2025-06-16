@extends('layouts.dashboard', ['title' => 'Delete Credit Note #' . $credit_note->credit_note_no])

@section('content')
    <div>
        <div class="d-flex flex-column gap-2 form-header-container">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <h2>Delete Credit Note</h2>
            <p>Delete the credit note for your customer</p>
        </div>
        <hr>
        <form action="{{ route('credit_notes.destroy', $credit_note->id) }}" method="POST">
            @csrf
            @method('DELETE')

            @include('credit_notes.form')
            <hr>
            <div class="pt-4">
                <div class="alert alert-danger" role="alert">
                    Are you sure want to delete?
                </div>
            </div>

            <div class="form-button-container">
                <button type="submit" class="delete-button" id="btnSubmit">Delete Credit Note</button>
            </div>
        </form>
    </div>
@endsection
