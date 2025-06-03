@extends('layouts.dashboard')

@section('content')
    <div style="padding: 40px;">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-2xl font-bold">Invoices</h2>
            <a href="{{ route('contacts.create') }}" class="primary-button">Create</a>
        </div>
        <div class="table-responsive" style="min-height: 200px; overflow-y: auto; margin-top: 32px;">
            <table class="table table-hover table-bordered align-middle text-nowrap" id="invoiceTable">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="text-center" style="width: 5%;">No</th>
                        <th scope="col" style="width: 10%;">Company Name</th>
                        <th scope="col" style="width: 10%;">Registration Number</th>
                        <th scope="col" style="width: 40%;">Entity Type</th>
                        <th scope="col" style="width: 5%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $index => $customer)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $customer->customer_name }}</td>
                            <td>{{ $customer->registration_number }}</td>
                            <td>{{ $customer->entity_type_text }}</td>
                            <td>
                                <a href="{{ route('contacts.edit', $customer->id) }}" class="btn btn-warning">Edit</a>
                                <a href="{{ route('contacts.show', $customer->id) }}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection
