@extends('layouts.dashboard')

@section('content')
    <div>
        <div class="d-flex flex-column gap-2" style="padding: 40px;">
            <h2>Delete Invoice</h2>
        </div>
        <hr>
        <form method="POST" method="POST">
            @csrf
            @method('DELETE')

            @include('invoices.form')
            <hr>
            <div class="pt-4">
                <div class="alert alert-danger" role="alert">
                    Are you sure want to delete?
                </div>
            </div>

            <div class="form-button-container">
                <button type="submit" class="delete-button" id="btnSubmit">Delete User</button>
                <a href="{{ route('admin.list_users.index') }}" class="third-button">Cancel</a>
            </div>
        </form>
    </div>
@endsection
