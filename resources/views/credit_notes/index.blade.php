@extends('layouts.dashboard', ['title' => 'Credit Notes'])

@section('content')
    <div style="padding: 40px;">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="text-2xl font-bold">Credit Notes</h2>
            <a href="{{ route('credit_notes.create') }}" class="primary-button">Create</a>
        </div>
        <div class="table-responsive" style="min-height: 200px; overflow-y: auto; margin-top: 32px;">
            <table class="table table-hover table-bordered align-middle text-nowrap" id="invoiceTable">
                <thead class="thead-light">
                    <tr>
                        <th scope="col" class="text-center" style="width: 5%;">No</th>
                        <th style="width: 5%;">Credit Note No</th>
                        <th style="width: 5%;">Invoice No</th>
                        <th style="width: 5%;">Date</th>
                        <th style="width: 20%;">Company Name</th>
                        <th style="width: 5%;" class="text-end">Subtotal</th>
                        <th style="width: 5%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($credit_notes as $index => $credit_note)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $credit_note->credit_note_no }}</td>
                            <td>{{ $credit_note->invoice_no }}</td>
                            <td>{{ $credit_note->credit_note_date }}</td>
                            <td>{{ $credit_note->customer }}</td>
                            <td class="text-end">{{ number_format($credit_note->subtotal, 2) }}</td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="hide-arrow p-0 border-0" type="button" id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="material-symbols-outlined"style="font-size: 18px; color: #646e78;">
                                            more_vert
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a href="{{ route('credit_notes.edit', $credit_note->id) }}" class="dropdown-item"
                                                href="#"
                                                style="display: flex; justify-content: start; align-items: center; gap:8px; font-size:14px;"><span
                                                    class="material-symbols-outlined" style="font-size: 14px">
                                                    edit
                                                </span> Edit</a></li>
                                        <li><a href="{{ route('credit_notes.view', $credit_note->id) }}" class="dropdown-item"
                                                style="display: flex; justify-content: start; align-items: center; gap:8px; font-size:14px;"><span
                                                    class="material-symbols-outlined" style="font-size: 14px">
                                                    list_alt
                                                </span> View Items</a></li>
                                        <li><a href="{{ route('credit_notes.destroy', $credit_note->id) }}"
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
            </table>
        </div>
    </div>
@endsection
