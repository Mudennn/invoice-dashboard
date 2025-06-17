<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Invoice #{{ $invoice->invoice_no }}</title>
    @include('layouts.styles.print')
    @include('layouts.styles.index')

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    @php
        $itemsPerPage = 8;
        $items = $invoice->invoiceItems->where('status', '0')->values();
        $chunks = $items->chunk($itemsPerPage);
        $totalPages = $chunks->count();
    @endphp

    @foreach ($chunks as $pageNum => $pageItems)
        <div class="invoice-container {{ $pageNum > 0 ? 'page-break' : '' }}">
            <div class="invoice-details">
                @if ($pageNum === 0)
                    <div class="header">
                        <div class="company-header">
                            <h5 class="chinese-text">金晶珠宝制造商</h5>
                            <h6 class="company-name">{{ $ourCompany->company_name }}</h6>
                            <p class="company-address">{{ $ourCompany->address_line_1 }}, {{ $ourCompany->address_line_2 }},
                                {{ $ourCompany->postcode }}
                                {{ $ourCompany->city }},
                                {{ $ourCompany->s_state }} </p>
                            <p>{{ $ourCompany->phone}}</p>
                            <p>{{ $ourCompany->email }}</p>
                        </div>
                    </div>

                    <div class="customer-details">
                        <div class="left-side">
                            <h6>Issued To:</h6>
                            <p class="customer-name">{{ $invoice->customer }}</p>
                            @php
                                $profile = $customerProfile ?? $otherProfile;
                            @endphp
                            @if ($profile)
                                <p class="customer-address">
                                    {{ $profile->address_line_1 }}, {{ $profile->address_line_2 }}
                                </p>
                                <p class="customer-address">
                                    {{ $profile->postcode }}, {{ $profile->city }}, {{ $profile->s_state }}
                                </p>
                                <p>{{ $profile->contact_1 }}</p>
                                <p>{{ $profile->email_1 }}</p>
                            @endif
                        </div>
                        {{-- <div class="center-side">
                        </div> --}}
                        <div class="right-side">
                            <h6 class="invoice-no">Invoice No: <span class="invoice-no-text">{{ $invoice->invoice_no }}</span></h6>
                            <p class="invoice-date">Date:
                                {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d F Y') }}</p>
                            <p class="page-number">Page {{ $pageNum + 1 }} of {{ $totalPages }}</p>
                        </div>
                    </div>
                @else
                    <div class="continuation-header">
                        <div class="left-side">
                            <div class="company-name">{{ $ourCompany->company_name }}</div>
                        </div>
                        <div class="right-side">
                            <p class="invoice-no">Invoice No: <span class="invoice-no-text">{{ $invoice->invoice_no }}</span></p>
                            <p class="invoice-date">Date:
                                {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d F Y') }}</p>
                            <p class="page-number">Page {{ $pageNum + 1 }} of {{ $totalPages }}</p>
                        </div>
                    </div>
                @endif

                <div class="invoice-items">
                    <table class="invoice-table">
                        <thead>
                            <tr>
                                <th style="width: 5%;" class="no-text">No</th>
                                <th style="width: 5%;" class="text-center">Quantity</th>
                                <th style="width: 15%;">Description</th>
                                <th style="width: 8%;" class="total-data">Unit Price</th>
                                <th style="width: 12%;" class="total-data">Total</th>
                         
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pageItems as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ number_format($item->quantity) == 0 ? '-' : number_format($item->quantity) }} </td>
                                    <td>{{ $item->description }}</td>
                                    <td class="total-data">{{ number_format($item->unit_price, 2) == 0 ? '-' : 'RM ' . number_format($item->unit_price, 2) }}
                                    </td>
                                    <td class="total-data">RM{{ number_format($item->total, 2) }}</td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                        @if ($pageNum === $totalPages - 1)
                            <tfoot class="totals-table">
                                <tr>
                                    <td colspan="4" class="total">Subtotal:</td>
                                    <td style="font-weight: bold !important;" class="total-data total">RM{{ number_format($item->subtotal, 2) }}
                                    </td>
                                    
                                </tr>
                            </tfoot>
                        @endif
                    </table>


                </div>

                <div class="signature-section">
                    <div class="signature-box">
                        <p class="signature-line">
                            Goods Received By: {{ $invoice->goods_received_by }}
                        </p>
                    </div>
                    <div class="signature-box">
                        <p class="signature-line">
                            Payment Received By: {{ $invoice->payment_received_by }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
