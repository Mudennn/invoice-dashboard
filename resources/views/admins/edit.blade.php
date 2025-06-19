@extends('layouts.dashboard' , ['title' => 'Edit Admin #' . $admin->name])

@section('content')
    <div class="relative">
        <div class="d-flex flex-column gap-2 form-header-container">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <h2>Edit Admin</h2>
            <p>Edit the admin for your system</p>
        </div>
        <hr>
        <form action="{{ route('admins.update', $admin->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            @include('admins.form')
            <hr>
            <div class="form-button-container">
                <button type="submit" class="primary-button" id="btnSubmit">Update Admin</button>
            </div>
        </form>
    </div>
@endsection