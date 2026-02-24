@extends('layouts.app')
@section('title', "Sale — $sale->invoice_number")
@section('page-title', 'Sale Detail')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1>{{ $sale->invoice_number }}</h1>
            <p>{{ $sale->sale_date->format('d F Y') }} · {{ $sale->customer_name }}</p>
        </div>
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
            <span class="badge badge-{{ $sale->status }}" style="font-size:13px;padding:6px 16px">
                {{ ucfirst($sale->status) }}
            </span>
            <a href="{{ route('sales.index') }}" class="btn btn-ghost">← Back</a>
        </div>
    </div>

    <div style="display:grid;grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));gap:32px;margin-top:24px">
        {{-- Sale Summary --}}
        <div>
            <h2 style="font-size:16px; font-weight:700; color:var(--text-primary); margin-bottom:16px">Sale Summary</h2>
            @foreach([
                ['Gross Amount',  number_format($sale->gross_amount,2).' TK', 'var(--text-primary)'],
                ['Discount',      '− '.number_format($sale->discount,2).' TK', 'var(--coral)'],
                ['VAT ('.$sale->vat_rate.'%)', '+ '.number_format($sale->vat_amount,2).' TK', 'var(--text-secondary)'],
                ['Net Payable',   number_format($sale->net_amount,2).' TK', 'var(--brand)'],
                ['Amount Paid',   number_format($sale->paid_amount,2).' TK', 'var(--green)'],
                ['Amount Due',    number_format($sale->due_amount,2).' TK', 'var(--coral)'],
            ] as [$label, $value, $color])
            <div style="display:flex;justify-content:space-between;align-items:center;padding:14px 0;border-bottom:1px solid var(--border)">
                <span style="font-size:13.5px;color:var(--text-secondary)">{{ $label }}</span>
                <span style="font-size:14px;font-weight:700;color:{{ $color }}">{{ $value }}</span>
            </div>
            @endforeach
        </div>

        {{-- Items --}}
        <div>
            <h2 style="font-size:16px; font-weight:700; color:var(--text-primary); margin-bottom:16px">Items Sold</h2>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->items as $item)
                        <tr>
                            <td style="font-weight:600">{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
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
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; margin-top:40px">
        <h2 style="font-size:16px; font-weight:700; color:var(--text-primary)">Journal Entry — {{ $sale->journalEntry->description }}</h2>
        @php
            $totalDr = $sale->journalEntry->lines->sum('debit');
            $totalCr = $sale->journalEntry->lines->sum('credit');
            $balanced = round($totalDr, 2) === round($totalCr, 2);
        @endphp
        <span class="badge {{ $balanced ? 'badge-success' : 'badge-danger' }}">
            {{ $balanced ? '✓ Balanced' : '✗ Unbalanced' }}
        </span>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Account</th>
                    <th style="text-align:right">Debit (TK)</th>
                    <th style="text-align:right">Credit (TK)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sale->journalEntry->lines as $line)
                <tr>
                    <td style="font-weight:600">{{ $line->account_name }}</td>
                    <td style="text-align:right;font-weight:600">
                        {{ $line->debit > 0 ? number_format($line->debit, 2) : '—' }}
                    </td>
                    <td style="text-align:right;font-weight:600;color:var(--green)">
                        {{ $line->credit > 0 ? number_format($line->credit, 2) : '—' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
@endsection
