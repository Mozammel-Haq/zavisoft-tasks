@extends('layouts.app')
@section('title', 'Journal Entries')
@section('page-title', 'Accounting')

@section('sidebar')
    @include('partials.sidebar')
@endsection

@section('content')
    <div class="page-header">
        <div class="page-header-text">
            <h1>Journal Entries</h1>
            <p>All double-entry accounting records. Every entry is balanced.</p>
        </div>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th style="text-align:right">Total DR</th>
                        <th style="text-align:right">Total CR</th>
                        <th>Balanced</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($entries as $entry)
                    @php
                        $dr = $entry->lines->sum('debit');
                        $cr = $entry->lines->sum('credit');
                        $ok = round($dr,2) === round($cr,2);
                    @endphp
                    <tr>
                        <td style="color:var(--text-muted)">{{ $entry->id }}</td>
                        <td style="font-weight:600">{{ $entry->description }}</td>
                        <td>{{ $entry->entry_date->format('d M Y') }}</td>
                        <td style="text-align:right;font-weight:600">{{ number_format($dr, 2) }}</td>
                        <td style="text-align:right;font-weight:600;color:var(--green)">{{ number_format($cr, 2) }}</td>
                        <td>
                            <span class="badge {{ $ok ? 'badge-success' : 'badge-danger' }}">
                                {{ $ok ? '✓ Yes' : '✗ No' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('journal.show', $entry) }}" class="btn btn-ghost btn-sm">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:48px;color:var(--text-muted)">
                            No journal entries yet. Record a sale to generate entries.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($entries->hasPages())
        <div class="pagination-wrap">
            <span>Showing {{ $entries->firstItem() }}–{{ $entries->lastItem() }} of {{ $entries->total() }}</span>
            {{ $entries->links('partials.pagination') }}
        </div>
        @endif
    </div>
@endsection
