@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Overview')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="page-header">
        <div class="page-header-text">
            <h1>Welcome back, {{ explode(' ', Auth::user()->name)[0] }}</h1>
            <p>Here is what is happening in your inventory today.</p>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap">
            <a href="{{ route('sales.create') }}" class="btn btn-outline">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                New Sale
            </a>
            <a href="{{ route('products.create') }}" class="btn btn-ghost">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Add Product
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon-box purple">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
            </div>
            <div class="stat-value">{{ $stats['total_products'] }}</div>
            <div class="stat-label">Total Products</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-box teal">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div class="stat-value">{{ $stats['total_sales'] }}</div>
            <div class="stat-label">Total Sales</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-box green">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
            </div>
            <div class="stat-value">{{ number_format($stats['total_revenue'], 0) }}</div>
            <div class="stat-label">Total Revenue (TK)</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-box coral">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="stat-value">{{ number_format($stats['total_due'], 0) }}</div>
            <div class="stat-label">Total Due (TK)</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-box yellow">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </div>
            <div class="stat-value">{{ $stats['low_stock'] }}</div>
            <div class="stat-label">Low Stock Items</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-box purple">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div class="stat-value">{{ number_format($stats['today_sales'], 0) }}</div>
            <div class="stat-label">Today Sales (TK)</div>
        </div>
    </div>

    {{-- Recent Sales --}}
    <div class="card">
        <div class="card-header" style="flex-wrap: wrap;">
            <span class="card-header-title">Recent Sales</span>
            <a href="{{ route('sales.index') }}" class="btn btn-ghost btn-sm">View All</a>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Net Amount</th>
                        <th>Paid</th>
                        <th>Due</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_sales as $sale)
                    <tr>
                        <td>
                            <a href="{{ route('sales.show', $sale) }}"
                               style="color:var(--brand);font-weight:600;text-decoration:none">
                                {{ $sale->invoice_number }}
                            </a>
                        </td>
                        <td>{{ $sale->customer_name }}</td>
                        <td>{{ $sale->sale_date->format('d M Y') }}</td>
                        <td style="font-weight:600">{{ number_format($sale->net_amount, 2) }} TK</td>
                        <td style="color:var(--green)">{{ number_format($sale->paid_amount, 2) }} TK</td>
                        <td style="color:var(--coral)">{{ number_format($sale->due_amount, 2) }} TK</td>
                        <td>
                            <span class="badge badge-{{ $sale->status }}">
                                {{ ucfirst($sale->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:40px;color:var(--text-muted)">
                            No sales recorded yet.
                            <a href="{{ route('sales.create') }}" style="color:var(--brand)">Record first sale</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
