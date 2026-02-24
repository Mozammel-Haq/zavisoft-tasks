@extends('layouts.app')
@section('title', 'Financial Report')
@section('page-title', 'Reports')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1>Financial Report</h1>
            <p>Date-wise breakdown of total sell and total expense.</p>
        </div>
    </div>

    {{-- Date Filter --}}
    <div class="card" style="margin-bottom:24px">
        <div class="card-body" style="padding:20px">
            <form method="GET" style="display:flex;align-items:flex-end;gap:14px;flex-wrap:wrap">
                <div>
                    <label class="form-label">From Date</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </span>
                        <input type="date" name="from"
                            class="form-control" value="{{ $from }}"
                            style="width:180px">
                    </div>
                </div>
                <div>
                    <label class="form-label">To Date</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </span>
                        <input type="date" name="to"
                            class="form-control" value="{{ $to }}"
                            style="width:180px">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Apply Filter</button>
                <a href="{{ route('reports.financial') }}" class="btn btn-ghost">Reset</a>
            </form>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="stats-grid" style="margin-bottom:24px">
        <div class="stat-card">
            <div class="stat-icon-box green">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
            </div>
            <div class="stat-value">{{ number_format($summary['total_sell'], 0) }}</div>
            <div class="stat-label">Total Sell (TK)</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-box coral">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></svg>
            </div>
            <div class="stat-value">{{ number_format($summary['total_expense'], 0) }}</div>
            <div class="stat-label">Total COGS (TK)</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-box purple">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
            <div class="stat-value" style="color:{{ $summary['gross_profit'] >= 0 ? 'var(--green)' : 'var(--coral)' }}">
                {{ number_format($summary['gross_profit'], 0) }}
            </div>
            <div class="stat-label">Gross Profit (TK)</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-box yellow">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="stat-value" style="color:var(--coral)">{{ number_format($summary['total_due'], 0) }}</div>
            <div class="stat-label">Total Due (TK)</div>
        </div>
    </div>

    {{-- Date-wise Table --}}
    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th style="text-align:right">Total Sell</th>
                        <th style="text-align:right">Total COGS</th>
                        <th style="text-align:right">Gross Profit</th>
                        <th style="text-align:right">Due</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dailyReport as $row)
                    <tr>
                        <td style="font-weight:600">
                            {{ \Carbon\Carbon::parse($row->sale_date)->format('d M Y') }}
                        </td>
                        <td style="text-align:right;font-weight:700;color:var(--green)">{{ number_format($row->net_sales, 0) }}</td>
                        <td style="text-align:right;color:var(--coral)">{{ number_format($row->total_expense, 0) }}</td>
                        <td style="text-align:right;font-weight:700;color:{{ $row->gross_profit >= 0 ? 'var(--green)' : 'var(--coral)' }}">
                            {{ number_format($row->gross_profit, 0) }}
                        </td>
                        <td style="text-align:right;color:var(--coral)">{{ number_format($row->total_due, 0) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align:center;padding:48px;color:var(--text-muted)">
                            No sales data for this period.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
