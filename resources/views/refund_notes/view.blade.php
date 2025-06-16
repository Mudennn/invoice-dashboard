@extends('layouts.dashboard', ['title' => 'View Items Refund Note #' . $refund_note->refund_note_no])

@section('content')
<div>
    <div class="d-flex flex-column gap-2 form-header-container">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <a href="{{ route('refund_notes.edit', $refund_note->id) }}" class="primary-button">Edit</a>
        </div>
       
        <h2>Refund Note Details</h2>
        <p>View the refund note details</p>
    </div>
    <hr>
<div class="form-input-container">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th class="text-center" style="width: 5%;">No</th>
                    <th class="text-center" style="width: 10%;">Quantity</th>
                    <th style="width: 50%;">Description</th>
                    <th style="width: 15%;">Unit Price</th>
                    <th style="width: 20%;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($refund_note->refundItems) && count($refund_note->refundItems) > 0)
                    @foreach($refund_note->refundItems as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td>{{ $item->description }}</td>
                            <td>RM {{ number_format($item->unit_price, 2) }}</td>
                            <td>RM {{ number_format($item->amount, 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="text-center">No items found</td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-end"><strong>Subtotal</strong></td>
                    <td>RM {{ isset($refund_note->refundItems) ? number_format($refund_note->refundItems->sum('amount'), 2) : '0.00' }}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-end"><strong>TOTAL</strong></td>
                    <td>RM {{ isset($refund_note->refundItems) ? number_format($refund_note->refundItems->sum('amount'), 2) : '0.00' }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

</div>
@endsection
