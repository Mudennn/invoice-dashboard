@extends('layouts.dashboard', ['title' => 'Create Admin'])

@section('content')
<div class="relative">
    <div class="d-flex flex-column gap-2 form-header-container">
        <a href="{{ url()->previous() }}" class="back-button mb-4">
            <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
            Back
        </a>
        <h2>New Admin</h2>
        <p>Create a new admin for your system</p>
    </div>
    <hr>
    <form action="{{ route('admins.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admins.form')

        <div class="form-button-container">
            <button type="submit" class="primary-button" id="btnSubmit">Create Admin</button>
        </div>
    </form>
</div>
@endsection