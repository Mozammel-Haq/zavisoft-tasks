@extends('layouts.app')
@section('title', 'Add Product')

@section('body')
<div class="app-shell">
    @include('partials.sidebar')

    <div class="main">
        <header class="topbar">
            <span class="topbar-title">Add Product</span>
        </header>

        <div class="content">

            <div class="page-header">
                <div class="page-header-text">
                    <h1>Add New Product</h1>
                    <p>Enter product details. Opening stock becomes the initial current stock.</p>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-ghost">
                    ← Back to Products
                </a>
            </div>

            <div class="card" style="max-width:700px">
                <div class="card-header">
                    <span class="card-header-title">Product Information</span>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('products.store') }}">
                        @csrf

                        <div class="form-grid" style="margin-bottom:18px">
                            <div class="form-group">
                                <label class="form-label">Product Name *</label>
                                <div class="input-wrap">
                                    <span class="input-icon">
                                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                                    </span>
                                    <input type="text" name="name"
                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                        value="{{ old('name') }}"
                                        placeholder="e.g. Demo Product"
                                        required>
                                </div>
                                @error('name')<div class="form-error">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">SKU (Optional)</label>
                                <div class="input-wrap">
                                    <span class="input-icon">
                                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                                    </span>
                                    <input type="text" name="sku"
                                        class="form-control {{ $errors->has('sku') ? 'is-invalid' : '' }}"
                                        value="{{ old('sku') }}"
                                        placeholder="e.g. PROD-001">
                                </div>
                                @error('sku')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom:18px">
                            <label class="form-label">Description (Optional)</label>
                            <textarea name="description"
                                class="form-control no-icon"
                                rows="2"
                                placeholder="Brief product description..."
                                style="resize:vertical">{{ old('description') }}</textarea>
                        </div>

                        <div class="form-grid" style="margin-bottom:18px">
                            <div class="form-group">
                                <label class="form-label">Purchase Price (TK) *</label>
                                <div class="input-wrap">
                                    <span class="input-icon">
                                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                    </span>
                                    <input type="number" name="purchase_price"
                                        class="form-control {{ $errors->has('purchase_price') ? 'is-invalid' : '' }}"
                                        value="{{ old('purchase_price', 100) }}"
                                        step="0.01" min="0.01" required
                                        placeholder="100.00">
                                </div>
                                @error('purchase_price')<div class="form-error">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Sell Price (TK) *</label>
                                <div class="input-wrap">
                                    <span class="input-icon">
                                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                                    </span>
                                    <input type="number" name="sell_price"
                                        class="form-control {{ $errors->has('sell_price') ? 'is-invalid' : '' }}"
                                        value="{{ old('sell_price', 200) }}"
                                        step="0.01" min="0.01" required
                                        placeholder="200.00">
                                </div>
                                @error('sell_price')<div class="form-error">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">Opening Stock *</label>
                                <div class="input-wrap">
                                    <span class="input-icon">
                                        <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/></svg>
                                    </span>
                                    <input type="number" name="opening_stock"
                                        class="form-control {{ $errors->has('opening_stock') ? 'is-invalid' : '' }}"
                                        value="{{ old('opening_stock', 50) }}"
                                        min="0" required
                                        placeholder="50">
                                </div>
                                @error('opening_stock')<div class="form-error">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div style="display:flex;gap:10px;margin-top:8px">
                            <button type="submit" class="btn btn-primary">
                                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                Save Product
                            </button>
                            <a href="{{ route('products.index') }}" class="btn btn-ghost">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
