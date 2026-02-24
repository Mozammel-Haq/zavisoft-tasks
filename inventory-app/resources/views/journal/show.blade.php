@extends('layouts.app')
@section('title', "Journal — $entry->description")
@section('page-title', 'Journal Detail')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1>Journal Entry</h1>
            <p>{{ $entry->description }} · {{ $entry->entry_date->format('d F Y') }}</p>
        </div>
        <a href="{{ route('journal.index') }}" class="btn btn-ghost">← Back</a>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; margin-top:30px">
        <h2 style="font-size:16px; font-weight:700; color:var(--text-primary)">Double Entry Breakdown</h2>
        @php
            $totalDr = $entry->lines->sum('debit');
            $totalCr = $entry->lines->sum('credit');
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
                @foreach($entry->lines as $line)
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
            <tfoot>
                <tr>
                    <td style="font-weight:700">TOTAL</td>
                    <td style="text-align:right;font-weight:700">{{ number_format($totalDr, 2) }}</td>
                    <td style="text-align:right;font-weight:700;color:var(--green)">{{ number_format($totalCr, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
