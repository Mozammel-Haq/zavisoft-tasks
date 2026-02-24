@extends('layouts.app')
@section('title', 'Products')
@section('page-title', 'Product Management')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1>Products</h1>
            <p>Manage your product catalog and stock levels.</p>
        </div>
        <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap">
            {{-- View Toggle --}}
            <div class="view-toggle">
                <button class="toggle-btn active" id="btnList" onclick="setView('list')" title="List View">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <line x1="8"  y1="6"  x2="21" y2="6"/>
                        <line x1="8"  y1="12" x2="21" y2="12"/>
                        <line x1="8"  y1="18" x2="21" y2="18"/>
                        <line x1="3"  y1="6"  x2="3.01" y2="6"/>
                        <line x1="3"  y1="12" x2="3.01" y2="12"/>
                        <line x1="3"  y1="18" x2="3.01" y2="18"/>
                    </svg>
                </button>
                <button class="toggle-btn" id="btnGrid" onclick="setView('grid')" title="Grid View">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <rect x="3"  y="3"  width="7" height="7"/>
                        <rect x="14" y="3"  width="7" height="7"/>
                        <rect x="14" y="14" width="7" height="7"/>
                        <rect x="3"  y="14" width="7" height="7"/>
                    </svg>
                </button>
            </div>

            <a href="{{ route('products.create') }}" class="btn btn-outline">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add Product
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ── LIST VIEW ──────────────────────────────────────── --}}
    <div id="listView">
        <div class="card">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Purchase Price</th>
                            <th>Sell Price</th>
                            <th>Current Stock</th>
                            <th>Margin</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        @php
                            $margin = $product->sell_price > 0
                                ? round((($product->sell_price - $product->purchase_price) / $product->sell_price) * 100, 1)
                                : 0;
                        @endphp
                        <tr>
                            <td style="color:var(--text-muted);font-size:12px">{{ $loop->iteration }}</td>
                            <td>
                                <div style="font-weight:600;color:var(--text-primary)">{{ $product->name }}</div>
                                @if($product->description)
                                    <div style="font-size:12px;color:var(--text-muted);margin-top:2px">
                                        {{ Str::limit($product->description, 40) }}
                                    </div>
                                @endif
                            </td>
                            <td style="font-family:monospace;font-size:12px;color:var(--text-secondary)">
                                {{ $product->sku ?? '—' }}
                            </td>
                            <td>{{ number_format($product->purchase_price, 2) }} TK</td>
                            <td style="font-weight:600;color:var(--brand)">
                                {{ number_format($product->sell_price, 2) }} TK
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;gap:8px">
                                    <span style="font-weight:700;font-size:13px;color:{{ $product->current_stock <= 5 ? 'var(--coral)' : 'var(--text-primary)' }}">
                                        {{ $product->current_stock }}
                                    </span>
                                    @if($product->current_stock <= 5)
                                        <span class="badge badge-danger" style="font-size:10px">Low</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span style="font-weight:600;color:{{ $margin >= 30 ? 'var(--green)' : ($margin >= 10 ? 'var(--brand)' : 'var(--coral)') }}">
                                    {{ $margin }}%
                                </span>
                            </td>
                            <td>
                                <div style="display:flex;gap:6px">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-ghost btn-sm">View</a>
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-ghost btn-sm">Edit</a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align:center;padding:56px;color:var(--text-muted)">
                                No products yet.
                                <a href="{{ route('products.create') }}" style="color:var(--brand);font-weight:600">Add first product</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
            <div class="pagination-wrap">
                <span>Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }}</span>
                {{ $products->links('partials.pagination') }}
            </div>
            @endif
        </div>
    </div>

    {{-- ── GRID VIEW ──────────────────────────────────────── --}}
    <div id="gridView" style="display:none">
        @if($products->isEmpty())
            <div style="text-align:center;padding:64px;color:var(--text-muted)">
                No products yet.
                <a href="{{ route('products.create') }}" style="color:var(--brand);font-weight:600">Add first product</a>
            </div>
        @else
        <div class="product-grid">
            @foreach($products as $product)
            @php
                $margin = $product->sell_price > 0
                    ? round((($product->sell_price - $product->purchase_price) / $product->sell_price) * 100, 1)
                    : 0;
            @endphp
            <div class="card" style="padding: 20px;">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:15px">
                    <div style="width:42px;height:42px;border-radius:10px;background:var(--brand-light);color:var(--brand);display:flex;align-items:center;justify-content:center;font-weight:700">
                        {{ strtoupper(substr($product->name, 0, 2)) }}
                    </div>
                    <div style="flex:1;min-width:0">
                        <div style="font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ $product->name }}</div>
                        <div style="font-size:12px;color:var(--text-muted)">{{ $product->sku ?? 'No SKU' }}</div>
                    </div>
                </div>
                <div style="display:flex;justify-content:space-between;margin-bottom:15px;font-size:13px">
                    <div>
                        <div style="color:var(--text-muted);font-size:11px;text-transform:uppercase">Price</div>
                        <div style="font-weight:700">{{ number_format($product->sell_price, 0) }} TK</div>
                    </div>
                    <div style="text-align:right">
                        <div style="color:var(--text-muted);font-size:11px;text-transform:uppercase">Stock</div>
                        <div style="font-weight:700;color:{{ $product->current_stock <= 5 ? 'var(--coral)' : 'inherit' }}">{{ $product->current_stock }}</div>
                    </div>
                </div>
                <div style="display:flex;gap:8px">
                    <a href="{{ route('products.show', $product) }}" class="btn btn-ghost btn-sm" style="flex:1;justify-content:center">View</a>
                    <a href="{{ route('products.edit', $product) }}" class="btn btn-ghost btn-sm" style="flex:1;justify-content:center">Edit</a>
                </div>
            </div>
            @endforeach
        </div>

        @if($products->hasPages())
        <div style="margin-top:20px;display:flex;justify-content:flex-end">
            {{ $products->links('partials.pagination') }}
        </div>
        @endif
        @endif
    </div>

    <style>
        .view-toggle {
            display: flex;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            padding: 3px;
            gap: 2px;
        }

        .toggle-btn {
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 6px;
            background: transparent;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all .15s;
        }

        .toggle-btn.active {
            background: var(--surface);
            color: var(--brand);
            box-shadow: 0 1px 3px rgba(0,0,0,.08);
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 16px;
        }
    </style>

    <script>
        function setView(view) {
            localStorage.setItem('productView', view);
            applyView(view);
        }

        function applyView(view) {
            const isList = view === 'list';
            document.getElementById('listView').style.display = isList ? 'block' : 'none';
            document.getElementById('gridView').style.display = isList ? 'none'  : 'block';
            document.getElementById('btnList').classList.toggle('active', isList);
            document.getElementById('btnGrid').classList.toggle('active', !isList);
        }

        const saved = localStorage.getItem('productView') || 'list';
        applyView(saved);
    </script>
@endsection
