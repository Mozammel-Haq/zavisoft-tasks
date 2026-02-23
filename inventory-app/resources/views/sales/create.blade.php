@extends('layouts.app')
@section('title', 'New Sale')

@section('body')
<div class="app-shell">
    @include('partials.sidebar')

    <div class="main">
        <header class="topbar">
            <span class="topbar-title">New Sale</span>
        </header>

        <div class="content">
            <div class="page-header">
                <div class="page-header-text">
                    <h1>Record New Sale</h1>
                    <p>Journal entries will be generated automatically on save.</p>
                </div>
                <a href="{{ route('sales.index') }}" class="btn btn-ghost">← Back</a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start">

                {{-- Form --}}
                <div class="card">
                    <div class="card-header">
                        <span class="card-header-title">Sale Details</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('sales.store') }}" id="saleForm">
                            @csrf

                            <div class="form-grid" style="margin-bottom:18px">
                                <div class="form-group">
                                    <label class="form-label">Product *</label>
                                    <div class="input-wrap">
                                        <span class="input-icon">
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                                        </span>
                                        <select name="product_id" id="productSelect"
                                            class="form-control {{ $errors->has('product_id') ? 'is-invalid' : '' }}"
                                            required>
                                            <option value="">— Select Product —</option>
                                            @foreach($products as $p)
                                                <option value="{{ $p->id }}"
                                                    data-price="{{ $p->sell_price }}"
                                                    data-stock="{{ $p->current_stock }}"
                                                    {{ old('product_id') == $p->id ? 'selected' : '' }}>
                                                    {{ $p->name }} (Stock: {{ $p->current_stock }} | Price: {{ number_format($p->sell_price, 2) }} TK)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('product_id')<div class="form-error">{{ $message }}</div>@enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Customer Name</label>
                                    <div class="input-wrap">
                                        <span class="input-icon">
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                        </span>
                                        <input type="text" name="customer_name"
                                            class="form-control"
                                            value="{{ old('customer_name') }}"
                                            placeholder="Walk-in Customer">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Quantity *</label>
                                    <div class="input-wrap">
                                        <span class="input-icon">
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                                        </span>
                                        <input type="number" name="quantity" id="quantity"
                                            class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}"
                                            value="{{ old('quantity', 10) }}"
                                            min="1" required>
                                    </div>
                                    @error('quantity')<div class="form-error">{{ $message }}</div>@enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Sale Date</label>
                                    <div class="input-wrap">
                                        <span class="input-icon">
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                        </span>
                                        <input type="date" name="sale_date"
                                            class="form-control"
                                            value="{{ old('sale_date', now()->toDateString()) }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Discount (TK)</label>
                                    <div class="input-wrap">
                                        <span class="input-icon">
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="19" y1="5" x2="5" y2="19"/><circle cx="6.5" cy="6.5" r="2.5"/><circle cx="17.5" cy="17.5" r="2.5"/></svg>
                                        </span>
                                        <input type="number" name="discount" id="discount"
                                            class="form-control"
                                            value="{{ old('discount', 50) }}"
                                            min="0" step="0.01">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">VAT Rate (%)</label>
                                    <div class="input-wrap">
                                        <span class="input-icon">
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20z"/><path d="M12 8v4l3 3"/></svg>
                                        </span>
                                        <input type="number" name="vat_rate" id="vatRate"
                                            class="form-control"
                                            value="{{ old('vat_rate', 5) }}"
                                            min="0" max="100" step="0.01">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Amount Paid (TK) *</label>
                                    <div class="input-wrap">
                                        <span class="input-icon">
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                                        </span>
                                        <input type="number" name="paid_amount" id="paidAmount"
                                            class="form-control {{ $errors->has('paid_amount') ? 'is-invalid' : '' }}"
                                            value="{{ old('paid_amount', 1000) }}"
                                            min="0" step="0.01" required>
                                    </div>
                                    @error('paid_amount')<div class="form-error">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div style="display:flex;gap:10px;margin-top:8px">
                                <button type="submit" class="btn btn-primary">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    Record Sale & Generate Journal
                                </button>
                                <a href="{{ route('sales.index') }}" class="btn btn-ghost">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Live Preview Panel --}}
                <div class="card" style="position:sticky;top:20px">
                    <div class="card-header">
                        <span class="card-header-title">Live Calculation</span>
                    </div>
                    <div class="card-body" style="padding:20px">

                        <div style="display:flex;flex-direction:column;gap:0">
                            @foreach([
                                ['Gross Amount',   'previewGross',    'var(--text-primary)', false],
                                ['Discount',       'previewDiscount', 'var(--coral)',        false],
                                ['Net before VAT', 'previewNetPre',   'var(--text-secondary)', false],
                                ['VAT Amount',     'previewVat',      'var(--text-secondary)', false],
                            ] as [$label, $id, $color, $bold])
                            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border)">
                                <span style="font-size:13px;color:var(--text-secondary)">{{ $label }}</span>
                                <span id="{{ $id }}" style="font-size:13.5px;font-weight:600;color:{{ $color }}">0.00 TK</span>
                            </div>
                            @endforeach

                            <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0;border-bottom:2px solid var(--border)">
                                <span style="font-size:14px;font-weight:700;color:var(--text-primary)">Net Payable</span>
                                <span id="previewNet" style="font-size:16px;font-weight:750;color:var(--brand)">0.00 TK</span>
                            </div>

                            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--border)">
                                <span style="font-size:13px;color:var(--text-secondary)">Amount Paid</span>
                                <span id="previewPaid" style="font-size:13.5px;font-weight:600;color:var(--green)">0.00 TK</span>
                            </div>

                            <div style="display:flex;justify-content:space-between;align-items:center;padding:12px 0">
                                <span style="font-size:14px;font-weight:700;color:var(--text-primary)">Due Amount</span>
                                <span id="previewDue" style="font-size:16px;font-weight:750;color:var(--coral)">0.00 TK</span>
                            </div>
                        </div>

                        <div id="statusBadge" style="margin-top:14px;text-align:center"></div>

                        <div style="margin-top:16px;padding:14px;background:var(--bg);border-radius:var(--radius-sm)">
                            <div style="font-size:11px;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:8px">Journal Preview</div>
                            <div style="font-size:12px;color:var(--text-secondary);line-height:1.9">
                                DR Cash / Bank <span id="jDrCash" style="float:right;font-weight:600">0.00</span><br>
                                DR Receivable <span id="jDrRec" style="float:right;font-weight:600">0.00</span><br>
                                DR Discount <span id="jDrDisc" style="float:right;font-weight:600">0.00</span><br>
                                CR Sales Revenue <span id="jCrSales" style="float:right;font-weight:600;color:var(--green)">0.00</span><br>
                                CR VAT Payable <span id="jCrVat" style="float:right;font-weight:600;color:var(--green)">0.00</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
function fmt(n) { return parseFloat(n).toFixed(2) + ' TK'; }
function fmtN(n) { return parseFloat(n).toFixed(2); }

function recalculate() {
    const opt      = document.querySelector('#productSelect option:checked');
    const price    = parseFloat(opt?.dataset.price  || 0);
    const qty      = parseFloat(document.getElementById('quantity').value    || 0);
    const discount = parseFloat(document.getElementById('discount').value    || 0);
    const vatRate  = parseFloat(document.getElementById('vatRate').value     || 0);
    const paid     = parseFloat(document.getElementById('paidAmount').value  || 0);

    const gross    = price * qty;
    const netPre   = gross - discount;
    const vat      = parseFloat((netPre * vatRate / 100).toFixed(2));
    const net      = parseFloat((netPre + vat).toFixed(2));
    const due      = parseFloat(Math.max(0, net - paid).toFixed(2));

    document.getElementById('previewGross').textContent   = fmt(gross);
    document.getElementById('previewDiscount').textContent= fmt(discount);
    document.getElementById('previewNetPre').textContent  = fmt(netPre);
    document.getElementById('previewVat').textContent     = fmt(vat);
    document.getElementById('previewNet').textContent     = fmt(net);
    document.getElementById('previewPaid').textContent    = fmt(paid);
    document.getElementById('previewDue').textContent     = fmt(due);

    // Journal preview
    document.getElementById('jDrCash').textContent   = fmtN(paid > 0 ? paid : 0);
    document.getElementById('jDrRec').textContent    = fmtN(due);
    document.getElementById('jDrDisc').textContent   = fmtN(discount);
    document.getElementById('jCrSales').textContent  = fmtN(gross);
    document.getElementById('jCrVat').textContent    = fmtN(vat);

    // Status badge
    const status = paid >= net ? 'paid' : paid > 0 ? 'partial' : 'due';
    const colors = { paid: ['var(--green-bg)','#065f46','Paid'], partial: ['#fffbeb','#92400e','Partial'], due: ['#fff0f1','#9f1239','Due'] };
    const [bg, color, label] = colors[status];
    document.getElementById('statusBadge').innerHTML =
        `<span style="display:inline-flex;align-items:center;gap:6px;padding:5px 16px;border-radius:20px;background:${bg};color:${color};font-size:12px;font-weight:700">Status: ${label}</span>`;
}

document.querySelectorAll('#productSelect,#quantity,#discount,#vatRate,#paidAmount')
    .forEach(el => el.addEventListener('input', recalculate));

// Run on load
recalculate();
</script>
@endsection
