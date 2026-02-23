@extends('layouts.app')
@section('title', 'Journal Entry')

@section('body')
<div class="app-shell">
    @include('partials.sidebar')
    <div class="main">
        <header class="topbar">
            <span class="topbar-title">Journal Entry Detail</span>

        </header>
        <div class="content">
            @php
                $dr = $journalEntry->lines->sum('debit');
                $cr = $journalEntry->lines->sum('credit');
                $ok = round($dr,2) === round($cr,2);
            @endphp
            <div class="page-header">
                <div class="page-header-text">
                    <h1>Journal Entry #{{ $journalEntry->id }}</h1>
                    <p>{{ $journalEntry->description }} · {{ $journalEntry->entry_date->format('d F Y') }}</p>
                </div>
                <div style="display:flex;gap:10px;align-items:center">
                    <span class="badge {{ $ok ? 'badge-paid' : 'badge-due' }}" style="font-size:13px;padding:6px 16px">
                        {{ $ok ? '✓ Balanced' : '✗ Unbalanced' }}
                    </span>
                    <a href="{{ route('journal.index') }}" class="btn btn-ghost">← Back</a>
                </div>
            </div>
            <div class="card">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Account Name</th>
                                <th>Account Type</th>
                                <th style="text-align:right">Debit (TK)</th>
                                <th style="text-align:right">Credit (TK)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($journalEntry->lines as $line)
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
                                <td style="text-align:right;font-weight:750;font-size:15px">{{ number_format($dr, 2) }}</td>
                                <td style="text-align:right;font-weight:750;font-size:15px;color:var(--green)">{{ number_format($cr, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
