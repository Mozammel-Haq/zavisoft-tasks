@extends('layouts.app')
@section('title', 'Financial Report')

@section('body')
<div class="app-shell">
    @include('partials.sidebar')
    <div class="main">
        <header class="topbar">
            <span class="topbar-title">Financial Report</span>
        </header>
        <div class="content">

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
                    <div class="stat-value">{{ number_format($summary['total_sell'], 2) }}</div>
                    <div class="stat-label">Total Sell (TK)</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-box coral">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></svg>
                    </div>
                    <div class="stat-value">{{ number_format($summary['total_expense'], 2) }}</div>
                    <div class="stat-label">Total Expense / COGS (TK)</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-box purple">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                    <div class="stat-value" style="color:{{ $summary['gross_profit'] >= 0 ? 'var(--green)' : 'var(--coral)' }}">
                        {{ number_format($summary['gross_profit'], 2) }}
                    </div>
                    <div class="stat-label">Gross Profit (TK)</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-box yellow">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div class="stat-value" style="color:var(--coral)">{{ number_format($summary['total_due'], 2) }}</div>
                    <div class="stat-label">Total Due (TK)</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-box teal">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="19" y1="5" x2="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/></svg>
                    </div>
                    <div class="stat-value">{{ number_format($summary['total_discount'], 2) }}</div>
                    <div class="stat-label">Total Discount (TK)</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-box purple">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20z"/><path d="M12 8v4l3 3"/></svg>
                    </div>
                    <div class="stat-value">{{ number_format($summary['total_vat'], 2) }}</div>
                    <div class="stat-label">Total VAT (TK)</div>
                </div>
            </div>

            {{-- Date-wise Table --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-header-title">
                        Date-wise Breakdown
                        <span style="font-weight:400;color:var(--text-muted);font-size:12px;margin-left:8px">
                            {{ \Carbon\Carbon::parse($from)->format('d M Y') }} — {{ \Carbon\Carbon::parse($to)->format('d M Y') }}
                        </span>
                    </span>
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th style="text-align:center">Transactions</th>
                                <th style="text-align:right">Gross Sales</th>
                                <th style="text-align:right">Discount</th>
                                <th style="text-align:right">VAT</th>
                                <th style="text-align:right">Total Sell</th>
                                <th style="text-align:right">Total Expense</th>
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
                                <td style="text-align:center">
                                    <span class="badge badge-asset">{{ $row->total_transactions }}</span>
                                </td>
                                <td style="text-align:right">{{ number_format($row->gross_sales, 2) }}</td>
                                <td style="text-align:right;color:var(--coral)">{{ number_format($row->total_discount, 2) }}</td>
                                <td style="text-align:right">{{ number_format($row->total_vat, 2) }}</td>
                                <td style="text-align:right;font-weight:700;color:var(--green)">{{ number_format($row->net_sales, 2) }}</td>
                                <td style="text-align:right;color:var(--coral)">{{ number_format($row->total_expense, 2) }}</td>
                                <td style="text-align:right;font-weight:700;color:{{ $row->gross_profit >= 0 ? 'var(--green)' : 'var(--coral)' }}">
                                    {{ number_format($row->gross_profit, 2) }}
                                </td>
                                <td style="text-align:right;color:var(--coral)">{{ number_format($row->total_due, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" style="text-align:center;padding:48px;color:var(--text-muted)">
                                    No sales data for this period.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($dailyReport->count() > 0)
                        <tfoot>
                            <tr>
                                <td colspan="2" style="font-weight:700">TOTAL</td>
                                <td style="text-align:right;font-weight:700">{{ number_format($dailyReport->sum('gross_sales'), 2) }}</td>
                                <td style="text-align:right;font-weight:700;color:var(--coral)">{{ number_format($summary['total_discount'], 2) }}</td>
                                <td style="text-align:right;font-weight:700">{{ number_format($summary['total_vat'], 2) }}</td>
                                <td style="text-align:right;font-weight:750;color:var(--green)">{{ number_format($summary['total_sell'], 2) }}</td>
                                <td style="text-align:right;font-weight:750;color:var(--coral)">{{ number_format($summary['total_expense'], 2) }}</td>
                                <td style="text-align:right;font-weight:750;color:var(--green)">{{ number_format($summary['gross_profit'], 2) }}</td>
                                <td style="text-align:right;font-weight:750;color:var(--coral)">{{ number_format($summary['total_due'], 2) }}</td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
