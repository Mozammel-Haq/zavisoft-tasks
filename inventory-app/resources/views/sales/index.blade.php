@extends('layouts.app')
@section('title', 'Sales')
@section('page-title', 'Sales Management')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1>Sales</h1>
            <p>All recorded sales with journal entries.</p>
        </div>
        <a href="{{ route('sales.create') }}" class="btn btn-outline">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New Sale
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                <tr>
                    <td style="font-weight:600;color:var(--brand)">{{ $sale->invoice_number }}</td>
                    <td>{{ $sale->customer_name }}</td>
                    <td>{{ $sale->sale_date->format('d M Y') }}</td>
                    <td style="font-weight:700">{{ number_format($sale->net_amount, 2) }}</td>
                    <td style="color:var(--green)">{{ number_format($sale->paid_amount, 2) }}</td>
                    <td style="color:var(--coral)">{{ number_format($sale->due_amount, 2) }}</td>
                    <td><span class="badge badge-{{ $sale->status }}">{{ ucfirst($sale->status) }}</span></td>
                    <td>
                        <a href="{{ route('sales.show', $sale) }}" class="btn btn-ghost btn-sm">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:48px;color:var(--text-muted)">
                        No sales recorded yet. <a href="{{ route('sales.create') }}" style="color:var(--brand)">Record first sale</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($sales->hasPages())
    <div class="pagination-wrap">
        <span>Showing {{ $sales->firstItem() }}–{{ $sales->lastItem() }} of {{ $sales->total() }}</span>
        {{ $sales->links('partials.pagination') }}
    </div>
    @endif
@endsection
