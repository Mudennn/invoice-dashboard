@extends('layouts.dashboard', ['title' => 'View Items Self-Billed Invoice #' . $self_billed_invoice->invoice_no])

@section('content')
<div>
    <div class="d-flex flex-column gap-2 form-header-container">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <a href="{{ url()->previous() }}" class="back-button mb-4">
                <span class="material-symbols-outlined" style="font-size: 16px;">arrow_back</span>
                Back
            </a>
            <a href="{{ route('self_billed_invoices.edit', $self_billed_invoice->id) }}" class="primary-button">Edit</a>
        </div>
       
        <h2>Self-Billed Invoice Details</h2>
        <p>View the self-billed invoice details</p>
    </div>
    <hr>
<div class="form-input-container">
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th class="text-center" style="width: 5%;">No</th>
                    <th class="text-center" style="width: 10%;">Quantity</th>
                    <th style="width: 30%;">Description</th>
                    <th style="width: 10%;">Tax Type</th>
                    <th style="width: 10%;">Classification</th>
                    <th style="width: 15%;" class="text-end">Unit Price</th>
                    <th style="width: 20%;" class="text-end">Amount</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($self_billed_invoice->selfBilledInvoiceItems) && count($self_billed_invoice->selfBilledInvoiceItems) > 0)
                    @foreach($self_billed_invoice->selfBilledInvoiceItems as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->tax_code }} - {{ $item->tax_type }}</td>
                            <td>{{ $item->classification_code }} - {{ $item->classification->description }}</td>
                            <td class="text-end">RM{{ number_format($item->unit_price, 2) }}</td>
                            <td class="text-end">RM{{ number_format($item->amount, 2) }}</td>
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
                    <td colspan="6" class="text-end"><strong>Total excluding Tax</strong></td>
                    <td class="text-end">RM{{ isset($self_billed_invoice->selfBilledInvoiceItems) ? number_format($self_billed_invoice->selfBilledInvoiceItems->sum('excluding_tax'), 2) : '0.00' }}</td>
                </tr>
                <tr>
                    <td colspan="6" class="text-end"><strong>Tax amount</strong></td>
                    <td class="text-end">RM{{ isset($self_billed_invoice->selfBilledInvoiceItems) ? number_format($self_billed_invoice->selfBilledInvoiceItems->sum('tax_amount'), 2) : '0.00' }}</td>
                </tr>
                <tr>
                    <td colspan="6" class="text-end"><strong>Subtotal</strong></td>
                    <td class="text-end">RM{{ isset($self_billed_invoice->selfBilledInvoiceItems) ? number_format($self_billed_invoice->selfBilledInvoiceItems->sum('excluding_tax') + $self_billed_invoice->selfBilledInvoiceItems->sum('tax_amount'), 2) : '0.00' }}</td>
                </tr>
                <tr>
                    <td colspan="6" class="text-end"><strong>TOTAL</strong></td>
                    <td class="text-end fw-bold">RM{{ isset($self_billed_invoice->selfBilledInvoiceItems) ? number_format($self_billed_invoice->selfBilledInvoiceItems->sum('excluding_tax') + $self_billed_invoice->selfBilledInvoiceItems->sum('tax_amount'), 2) : '0.00' }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

</div>
@endsection
