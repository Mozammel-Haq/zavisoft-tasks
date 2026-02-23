@extends('layouts.app')
@section('title', 'Products')

@section('body')
<div class="app-shell">
    @include('partials.sidebar')

    <div class="main">
        <header class="topbar">
            <span class="topbar-title">Products</span>
        </header>

        <div class="content">

            @if(session('success'))
                <div class="alert alert-success">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="page-header">
                <div class="page-header-text">
                    <h1>Products</h1>
                    <p>Manage your product catalog and stock levels.</p>
                </div>
                <div style="display:flex;align-items:center;gap:10px">

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
                                    <th>Opening Stock</th>
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
                                    <td>{{ $product->opening_stock }}</td>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:8px">
                                            <div class="stock-bar-wrap">
                                                @php
                                                    $pct = $product->opening_stock > 0
                                                        ? min(100, round(($product->current_stock / $product->opening_stock) * 100))
                                                        : 0;
                                                    $barColor = $pct > 50 ? 'var(--green)' : ($pct > 20 ? 'var(--yellow)' : 'var(--coral)');
                                                @endphp
                                                <div class="stock-bar">
                                                    <div class="stock-bar-fill" style="width:{{ $pct }}%;background:{{ $barColor }}"></div>
                                                </div>
                                            </div>
                                            <span style="font-weight:700;font-size:13px;color:{{ $product->current_stock <= 5 ? 'var(--coral)' : 'var(--text-primary)' }}">
                                                {{ $product->current_stock }}
                                            </span>
                                            @if($product->current_stock <= 5)
                                                <span class="badge badge-due" style="font-size:10px">Low</span>
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
                                            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm">Edit</a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" style="text-align:center;padding:56px;color:var(--text-muted)">
                                        <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="display:block;margin:0 auto 12px;color:var(--border)"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                                        No products yet.
                                        <a href="{{ route('products.create') }}" style="color:var(--brand);font-weight:600">Add your first product</a>
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
                        <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="display:block;margin:0 auto 12px;color:var(--border)"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                        No products yet.
                        <a href="{{ route('products.create') }}" style="color:var(--brand);font-weight:600">Add your first product</a>
                    </div>
                @else
                <div class="product-grid">
                    @foreach($products as $product)
                    @php
                        $margin = $product->sell_price > 0
                            ? round((($product->sell_price - $product->purchase_price) / $product->sell_price) * 100, 1)
                            : 0;
                        $pct = $product->opening_stock > 0
                            ? min(100, round(($product->current_stock / $product->opening_stock) * 100))
                            : 0;
                        $barColor = $pct > 50 ? 'var(--green)' : ($pct > 20 ? 'var(--yellow)' : 'var(--coral)');
                    @endphp
                    <div class="product-card">

                        {{-- Card Top --}}
                        <div class="product-card-top">
                            <div class="product-card-avatar">
                                {{ strtoupper(substr($product->name, 0, 2)) }}
                            </div>
                            <div style="flex:1;min-width:0">
                                <div class="product-card-name">{{ $product->name }}</div>
                                <div class="product-card-sku">{{ $product->sku ?? 'No SKU' }}</div>
                            </div>
                            <span style="font-weight:700;font-size:13px;color:{{ $margin >= 30 ? 'var(--green)' : ($margin >= 10 ? 'var(--brand)' : 'var(--coral)') }}">
                                {{ $margin }}%
                            </span>
                        </div>

                        {{-- Prices --}}
                        <div class="product-card-prices">
                            <div class="price-block">
                                <div class="price-label">Buy Price</div>
                                <div class="price-value">{{ number_format($product->purchase_price, 0) }} TK</div>
                            </div>
                            <div class="price-divider"></div>
                            <div class="price-block">
                                <div class="price-label">Sell Price</div>
                                <div class="price-value" style="color:var(--brand)">{{ number_format($product->sell_price, 0) }} TK</div>
                            </div>
                            <div class="price-divider"></div>
                            <div class="price-block">
                                <div class="price-label">Profit</div>
                                <div class="price-value" style="color:var(--green)">
                                    {{ number_format($product->sell_price - $product->purchase_price, 0) }} TK
                                </div>
                            </div>
                        </div>

                        {{-- Stock Bar --}}
                        <div style="padding:0 18px 16px">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px">
                                <span style="font-size:11.5px;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:.4px">Stock Level</span>
                                <div style="display:flex;align-items:center;gap:6px">
                                    <span style="font-size:13.5px;font-weight:750;color:{{ $product->current_stock <= 5 ? 'var(--coral)' : 'var(--text-primary)' }}">
                                        {{ $product->current_stock }}
                                    </span>
                                    <span style="font-size:12px;color:var(--text-muted)">/ {{ $product->opening_stock }}</span>
                                    @if($product->current_stock <= 5)
                                        <span class="badge badge-due" style="font-size:10px">Low</span>
                                    @endif
                                </div>
                            </div>
                            <div class="stock-bar" style="height:6px">
                                <div class="stock-bar-fill" style="width:{{ $pct }}%;background:{{ $barColor }}"></div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="product-card-actions">
                            <a href="{{ route('products.show', $product) }}" class="btn btn-ghost btn-sm" style="flex:1;justify-content:center">View</a>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm" style="flex:1;justify-content:center">Edit</a>
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

        </div>
    </div>
</div>

<style>
    /* ── View Toggle ──────────────────────────── */
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

    .toggle-btn:hover { color: var(--text-primary); background: var(--surface); }

    .toggle-btn.active {
        background: var(--surface);
        color: var(--brand);
        box-shadow: 0 1px 3px rgba(0,0,0,.08);
    }

    /* ── Stock Bar ────────────────────────────── */
    .stock-bar-wrap { width: 60px; }

    .stock-bar {
        width: 100%;
        height: 5px;
        background: var(--border);
        border-radius: 10px;
        overflow: hidden;
    }

    .stock-bar-fill {
        height: 100%;
        border-radius: 10px;
        transition: width .3s ease;
    }

    /* ── Product Grid ─────────────────────────── */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 16px;
    }

    .product-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        transition: border-color .15s, transform .15s;
    }

    .product-card:hover {
        border-color: var(--brand);
        transform: translateY(-2px);
    }

    .product-card-top {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 18px 18px 14px;
    }

    .product-card-avatar {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: var(--brand-light);
        color: var(--brand);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 750;
        flex-shrink: 0;
        letter-spacing: -.5px;
    }

    .product-card-name {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-primary);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-bottom: 2px;
    }

    .product-card-sku {
        font-size: 11.5px;
        color: var(--text-muted);
        font-family: monospace;
    }

    .product-card-prices {
        display: flex;
        align-items: stretch;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
        margin-bottom: 14px;
    }

    .price-block {
        flex: 1;
        padding: 12px 10px;
        text-align: center;
    }

    .price-divider {
        width: 1px;
        background: var(--border);
    }

    .price-label {
        font-size: 10.5px;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: 4px;
    }

    .price-value {
        font-size: 14px;
        font-weight: 750;
        color: var(--text-primary);
    }

    .product-card-actions {
        display: flex;
        gap: 8px;
        padding: 0 18px 18px;
    }
</style>

<script>
    // Persist view preference in localStorage
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

    // On load, restore saved preference
    const saved = localStorage.getItem('productView') || 'grid';
    applyView(saved);
</script>

@endsection
