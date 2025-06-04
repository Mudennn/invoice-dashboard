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
                        <th scope="col" style="width: 10%;">Control</th>
                        <th scope="col" style="width: 5%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->id }}</td>
                            <td>{{ $invoice->invoice_no }}</td>
                            <td>{{ $invoice->invoice_date }} {{ $invoice->control_text }}</td>
                            <td>{{ $invoice->customer }}</td>
                            <td>{{ $invoice->amount }}</td>
                            @php
                                $control_text = $invoice->control_text;
                                if ($control_text == 'Draft') {
                                    $badge_color = 'bg-warning';
                                } elseif ($control_text == 'Pending') {
                                    $badge_color = 'bg-info';
                                } elseif ($control_text == 'Ready') {
                                    $badge_color = 'bg-success';
                                }
                            @endphp
                            <td><span class="badge {{ $badge_color }}">{{ $control_text }}</span></td>
                            <td>
                                <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-primary">Edit</a>
                                <a href="{{ route('invoices.view', $invoice->id) }}" class="btn btn-info">View</a>
                                <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
