@extends('layouts.dashboard', ['title' => 'Edit Refund Note #' . $refund_note->refund_note_no])

@section('content')
    <div>
        <div class="d-flex flex-column gap-2 form-header-container">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <h2>Edit Refund Note</h2>
            <p>Edit the refund note for your customer</p>
        </div>
        <hr>
        <form action="{{ route('refund_notes.update', $refund_note->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            @include('refund_notes.form')
            <hr>
            <div class="form-button-container">
                <button type="submit" class="primary-button" id="btnSubmit">Update Refund Note</button>
            </div>
        </form>
    </div>
@endsection
