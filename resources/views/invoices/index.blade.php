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
                        <th scope="col" style="width: 5%;"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->id }}</td>
                            <td>{{ $invoice->invoice_no }}</td>
                            <td>{{ $invoice->invoice_date }}</td>
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
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="hide-arrow p-0 border-0" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="material-symbols-outlined"style="font-size: 18px; color: #646e78;">
                                            more_vert
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a href="{{ route('invoices.edit', $invoice->id) }}" class="dropdown-item"
                                                href="#"
                                                style="display: flex; justify-content: start; align-items: center; gap:8px; font-size:14px;"><span
                                                    class="material-symbols-outlined" style="font-size: 14px">
                                                    edit
                                                </span> Edit</a></li>
                                        {{-- <li><a href="{{ route('invoices.payments', $invoice->id) }}"
                                                    class="dropdown-item"
                                                    style="display: flex; justify-content: start; align-items: center; gap:8px; font-size:14px;"><span
                                                        class="material-symbols-outlined" style="font-size: 14px">
                                                        payments
                                                    </span> View Payments</a></li> --}}
                                        <li><a href="{{ route('invoices.view', $invoice->id) }}" class="dropdown-item"
                                                style="display: flex; justify-content: start; align-items: center; gap:8px; font-size:14px;"><span
                                                    class="material-symbols-outlined" style="font-size: 14px">
                                                    list_alt
                                                </span> View Items</a></li>
                                        {{-- <li><a href="{{ route('invoices.print', $invoice->id) }}" class="dropdown-item"
                                                    target="_blank"
                                                    style="display: flex; justify-content: start; align-items: center; gap:8px; font-size:14px;"><span
                                                        class="material-symbols-outlined" style="font-size: 14px">
                                                        print
                                                    </span> Print Invoice</a></li> --}}
                                        <li><a href="{{ route('invoices.destroy', $invoice->id) }}"
                                                class="dropdown-item text-danger" href="#"
                                                style="display: flex; justify-content: start; align-items: center; gap:8px; font-size:14px;"><span
                                                    class="material-symbols-outlined" style="font-size: 14px">
                                                    delete
                                                </span>Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
