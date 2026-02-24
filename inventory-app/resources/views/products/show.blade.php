@extends('layouts.app')
@section('title', "Product — $product->name")
@section('page-title', 'Product Detail')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1>{{ $product->name }}</h1>
            <p>{{ $product->sku ?? '—' }} · {{ $product->description ?? 'No description provided.' }}</p>
        </div>
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
            <a href="{{ route('products.index') }}" class="btn btn-ghost">← Back</a>
            <a href="{{ route('products.edit', $product) }}" class="btn btn-outline">Edit Product</a>
        </div>
    </div>

    <div style="display:grid;grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));gap:20px">
        <div class="card">
            <div class="card-header"><span class="card-header-title">Details</span></div>
            <div class="card-body">
                <div style="display:flex;justify-content:space-between;padding:12px 0;border-bottom: 1px solid var(--border)">
                    <span class="text-muted">Purchase Price</span>
                    <span style="font-weight:700">{{ number_format($product->purchase_price,2) }} TK</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:12px 0;border-bottom: 1px solid var(--border)">
                    <span class="text-muted">Sell Price</span>
                    <span style="font-weight:700;color:var(--brand)">{{ number_format($product->sell_price,2) }} TK</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:12px 0;border-bottom: 1px solid var(--border)">
                    <span class="text-muted">Opening Stock</span>
                    <span style="font-weight:700">{{ $product->opening_stock }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;padding:12px 0">
                    <span class="text-muted">Current Stock</span>
                    <span style="font-weight:700;color:{{ $product->current_stock <= 5 ? 'var(--coral)' : 'var(--green)' }}">{{ $product->current_stock }}</span>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><span class="card-header-title">Recent Sales</span></div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Date</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($product->sellItems as $item)
                        <tr>
                            <td>
                                @if($item->sale)
                                    <a href="{{ route('sales.show', $item->sale) }}" style="color:var(--brand);font-weight:600;text-decoration:none">{{ $item->sale->invoice_number }}</a>
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ optional($item->sale->sale_date)->format('d M Y') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td style="font-weight:700">{{ number_format($item->total_price,2) }} TK</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align:center;padding:28px;color:var(--text-muted)">No sales for this product yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
