@extends('layouts.dashboard')

@section('content')
    <div style="padding: 40px;">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-2xl font-bold">Invoices</h2>
            <a href="{{ route('invoices.create') }}" class="primary-button">Create</a>
        </div>
        <div class="table-responsive" style="min-height: 200px; overflow-y: auto; margin-top: 32px;">
            <table class="table table-hover table-bordered align-middle text-nowrap" id="invoiceTable">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="text-center" style="width: 5%;">No</th>
                        <th scope="col" style="width: 10%;">Invoice No</th>
                        <th scope="col" style="width: 10%;">Invoice Date</th>
                        <th scope="col" style="width: 40%;">Customer</th>
                        <th scope="col" style="width: 10%;">Amount</th>
                        <th scope="col" style="width: 10%;">Status</th>
                        <th scope="col" style="width: 5%;">Actions</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
@endsection
