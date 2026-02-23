@extends('layouts.app')
@section('title', 'Sign In — Inventory')

@section('styles')
<style>
    body { background: #f4f6fb; }

    .auth-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        position: relative;
        overflow: hidden;
    }

    .shape-coral {
        position: fixed;
        top: -40px; right: -40px;
        width: 130px; height: 130px;
        background: #e85d6a;
        border-radius: 0 0 0 100%;
        z-index: 0;
    }

    .shape-yellow {
        position: fixed;
        bottom: -40px; left: -40px;
        width: 140px; height: 140px;
        background: #f5c842;
        border-radius: 50%;
        z-index: 0;
    }

    .auth-card {
        display: flex;
        width: 100%;
        max-width: 820px;
        min-height: 500px;
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        z-index: 1;
    }

    .auth-panel {
        width: 310px;
        flex-shrink: 0;
        background: #6366f1;
        display: flex;
        flex-direction: column;
        padding: 32px 28px;
        position: relative;
        overflow: hidden;
    }

    .panel-shape-circle {
        position: absolute;
        bottom: 50px; left: -50px;
        width: 160px; height: 160px;
        border-radius: 50%;
        background: rgba(255,255,255,.1);
    }

    .panel-shape-diamond {
        position: absolute;
        top: 50%; right: 24px;
        width: 36px; height: 36px;
        background: rgba(255,255,255,.18);
        transform: translateY(-50%) rotate(45deg);
    }

    .panel-shape-diamond-sm {
        position: absolute;
        top: 36%; right: 60px;
        width: 16px; height: 16px;
        background: rgba(255,255,255,.14);
        transform: rotate(45deg);
    }

    .panel-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: auto;
    }

    .panel-brand-icon {
        width: 36px; height: 36px;
        border: 1.5px solid rgba(255,255,255,.45);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .panel-brand-name {
        font-size: 15px;
        font-weight: 700;
        color: #fff;
    }

    .panel-content {
        position: relative;
        z-index: 1;
        margin-bottom: 36px;
    }

    .panel-heading {
        font-size: 26px;
        font-weight: 800;
        color: #fff;
        line-height: 1.25;
        margin-bottom: 14px;
    }

    .panel-text {
        font-size: 13.5px;
        color: rgba(255,255,255,.78);
        line-height: 1.65;
    }

    .auth-form-wrap {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 48px 44px;
    }

    .auth-form-inner { width: 100%; max-width: 320px; }

    .auth-title {
        font-size: 26px;
        font-weight: 800;
        color: #6366f1;
        text-align: center;
        margin-bottom: 28px;
    }

    .input-group {
        position: relative;
        margin-bottom: 14px;
    }

    .input-icon-auth {
        position: absolute;
        left: 13px; top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        display: flex;
        pointer-events: none;
    }

    .form-control-auth {
        width: 100%;
        padding: 12px 14px 12px 42px;
        border: none;
        border-radius: 8px;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        color: #2d3748;
        background: #f4f6f8;
        outline: none;
        transition: all .15s;
    }

    .form-control-auth:focus {
        background: #eef2ff;
        box-shadow: 0 0 0 2px #6366f1;
    }

    .form-control-auth.is-invalid {
        box-shadow: 0 0 0 2px #e85d6a;
    }

    .form-err-msg {
        font-size: 12px;
        color: #e85d6a;
        margin-top: -8px;
        margin-bottom: 10px;
        font-weight: 500;
        padding-left: 4px;
    }

    .check-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 22px;
    }

    .check-row input { accent-color: #6366f1; width: 15px; height: 15px; }
    .check-row label { font-size: 13px; color: #718096; font-weight: 500; cursor: pointer; }

    .btn-submit {
        width: 100%;
        padding: 13px;
        border-radius: 50px;
        border: none;
        background: #6366f1;
        color: #fff;
        font-family: 'Inter', sans-serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: .8px;
        text-transform: uppercase;
        cursor: pointer;
        transition: all .18s;
    }

    .btn-submit:hover {
        background: #4f46e5;
        transform: translateY(-1px);
    }

    .demo-fill {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        padding: 9px;
        border: 1.5px dashed #c7d2fe;
        border-radius: 8px;
        background: #eef2ff;
        color: #4338ca;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        margin-bottom: 20px;
        font-family: 'Inter', sans-serif;
        transition: all .15s;
    }

    .demo-fill:hover { background: #e0e7ff; }
</style>
@endsection

@section('body')
<div class="auth-page">
    <div class="shape-coral"></div>
    <div class="shape-yellow"></div>

    <div class="auth-card">

        {{-- Left Panel --}}
        <div class="auth-panel">
            <div class="panel-shape-circle"></div>
            <div class="panel-shape-diamond"></div>
            <div class="panel-shape-diamond-sm"></div>

            <div class="panel-brand">
                <div class="panel-brand-icon">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="white" stroke-width="2">
                        <path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                        <path d="M16 3H8a2 2 0 0 0-2 2v2h12V5a2 2 0 0 0-2-2z"/>
                        <line x1="12" y1="12" x2="12" y2="16"/>
                        <line x1="10" y1="14" x2="14" y2="14"/>
                    </svg>
                </div>
                <span class="panel-brand-name">Inventory</span>
            </div>

            <div class="panel-content">
                <div class="panel-heading">Manage<br>Smarter.</div>
                <p class="panel-text">
                    Track products, record sales with proper accounting journal entries, and view date-wise financial reports.
                </p>
            </div>
        </div>

        {{-- Right Form --}}
        <div class="auth-form-wrap">
            <div class="auth-form-inner">

                <div class="auth-title">Sign In</div>

                @if($errors->any())
                    <div style="background:#fff0f1;border:1px solid #fecdd3;color:#9f1239;padding:11px 14px;border-radius:8px;font-size:13px;font-weight:500;margin-bottom:16px;display:flex;align-items:center;gap:8px">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $errors->first() }}
                    </div>
                @endif

                <button type="button" class="demo-fill" onclick="fillDemo()">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    Fill Demo Credentials
                </button>

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <div class="input-group">
                        <span class="input-icon-auth">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </span>
                        <input type="email" id="email" name="email"
                            class="form-control-auth {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            placeholder="Email" value="{{ old('email') }}"
                            required autofocus>
                    </div>
                    @error('email')
                        <div class="form-err-msg">{{ $message }}</div>
                    @enderror

                    <div class="input-group">
                        <span class="input-icon-auth">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <input type="password" id="password" name="password"
                            class="form-control-auth"
                            placeholder="Password" required>
                    </div>

                    <div class="check-row" style="margin-top:4px">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="btn-submit">Sign In</button>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
function fillDemo() {
    document.getElementById('email').value    = 'admin@inventory.com';
    document.getElementById('password').value = 'password';
}
</script>
@endsection
