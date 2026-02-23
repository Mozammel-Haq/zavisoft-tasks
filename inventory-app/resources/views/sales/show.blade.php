@extends('layouts.app')
@section('title', 'Sale — {{ $sale->invoice_number }}')

@section('body')
<div class="app-shell">
    @include('partials.sidebar')
    <div class="main">
        <header class="topbar">
            <span class="topbar-title">Sale Detail</span>
        </header>
        <div class="content">
            <div class="page-header">
                <div class="page-header-text">
                    <h1>{{ $sale->invoice_number }}</h1>
                    <p>{{ $sale->sale_date->format('d F Y') }} · {{ $sale->customer_name }}</p>
                </div>
                <div style="display:flex;gap:10px;align-items:center">
                    <span class="badge badge-{{ $sale->status }}" style="font-size:13px;padding:6px 16px">
                        {{ ucfirst($sale->status) }}
                    </span>
                    <a href="{{ route('sales.index') }}" class="btn btn-ghost">← Back</a>
                </div>
            </div>

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

                {{-- Sale Summary --}}
                <div class="card">
                    <div class="card-header"><span class="card-header-title">Sale Summary</span></div>
                    <div class="card-body" style="padding:0">
                        @foreach([
                            ['Gross Amount',  number_format($sale->gross_amount,2).' TK', 'var(--text-primary)'],
                            ['Discount',      '− '.number_format($sale->discount,2).' TK', 'var(--coral)'],
                            ['VAT ('.$sale->vat_rate.'%)', '+ '.number_format($sale->vat_amount,2).' TK', 'var(--text-secondary)'],
                            ['Net Payable',   number_format($sale->net_amount,2).' TK', 'var(--brand)'],
                            ['Amount Paid',   number_format($sale->paid_amount,2).' TK', 'var(--green)'],
                            ['Amount Due',    number_format($sale->due_amount,2).' TK', 'var(--coral)'],
                            ['COGS',          number_format($sale->cogs,2).' TK', 'var(--text-secondary)'],
                        ] as [$label, $value, $color])
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 24px;border-bottom:1px solid var(--border)">
                            <span style="font-size:13.5px;color:var(--text-secondary)">{{ $label }}</span>
                            <span style="font-size:14px;font-weight:700;color:{{ $color }}">{{ $value }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Items --}}
                <div class="card">
                    <div class="card-header"><span class="card-header-title">Items Sold</span></div>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sale->items as $item)
                                <tr>
                                    <td style="font-weight:600">{{ $item->product->name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->unit_price, 2) }} TK</td>
                                    <td style="font-weight:600">{{ number_format($item->total_price, 2) }} TK</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            {{-- Journal Entry --}}
            @if($sale->journalEntry)
            <div class="card" style="margin-top:20px">
                <div class="card-header">
                    <span class="card-header-title">Journal Entry — {{ $sale->journalEntry->description }}</span>
                    @php
                        $totalDr = $sale->journalEntry->lines->sum('debit');
                        $totalCr = $sale->journalEntry->lines->sum('credit');
                        $balanced = round($totalDr, 2) === round($totalCr, 2);
                    @endphp
                    <span class="badge {{ $balanced ? 'badge-paid' : 'badge-due' }}">
                        {{ $balanced ? '✓ Balanced' : '✗ Unbalanced' }}
                    </span>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Account</th>
                                <th>Type</th>
                                <th style="text-align:right">Debit (TK)</th>
                                <th style="text-align:right">Credit (TK)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sale->journalEntry->lines as $line)
                            <tr>
                                <td style="font-weight:600">{{ $line->account_name }}</td>
                                <td><span class="badge badge-{{ $line->account_type }}">{{ ucfirst($line->account_type) }}</span></td>
                                <td style="text-align:right;font-weight:600;color:{{ $line->debit > 0 ? 'var(--text-primary)' : 'var(--text-muted)' }}">
                                    {{ $line->debit > 0 ? number_format($line->debit, 2) : '—' }}
                                </td>
                                <td style="text-align:right;font-weight:600;color:{{ $line->credit > 0 ? 'var(--green)' : 'var(--text-muted)' }}">
                                    {{ $line->credit > 0 ? number_format($line->credit, 2) : '—' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" style="font-weight:700">TOTAL</td>
                                <td style="text-align:right;font-weight:700">{{ number_format($totalDr, 2) }}</td>
                                <td style="text-align:right;font-weight:700;color:var(--green)">{{ number_format($totalCr, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
