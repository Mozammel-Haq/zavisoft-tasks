@extends('layouts.app')

@section('title', 'Sign In — Foodpanda')

@section('styles')
<style>
    body { background: #f0f2f5; }

    .auth-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        position: relative;
        overflow: hidden;
    }

    .shape-teal {
        position: fixed;
        top: -40px;
        right: -40px;
        width: 130px;
        height: 130px;
        background: #2ec4b6;
        border-radius: 0 0 0 100%;
        z-index: 0;
    }

    .shape-yellow {
        position: fixed;
        bottom: -40px;
        left: -40px;
        width: 140px;
        height: 140px;
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

    /* Left panel — foodpanda coral */
    .auth-panel {
        width: 330px;
        flex-shrink: 0;
        background: #e85d6a;
        display: flex;
        flex-direction: column;
        padding: 32px 28px;
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    .panel-shape-circle {
        position: absolute;
        bottom: 50px;
        left: -50px;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        background: rgba(255,255,255,.1);
    }

    .panel-shape-diamond {
        position: absolute;
        top: 50%;
        right: 24px;
        width: 36px;
        height: 36px;
        background: rgba(255,255,255,.18);
        transform: translateY(-50%) rotate(45deg);
    }

    .panel-shape-diamond-sm {
        position: absolute;
        top: 36%;
        right: 60px;
        width: 16px;
        height: 16px;
        background: rgba(255,255,255,.14);
        transform: rotate(45deg);
    }

    .panel-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 100px;
    }

    .panel-brand-icon {
        width: 36px;
        height: 36px;
        border: 1.5px solid rgba(255,255,255,.5);
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
        margin-bottom: 28px;
    }

    /* SSO button in panel */
    .btn-sso-panel {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 20px;
        border-radius: 50px;
        border: 2px solid rgba(255,255,255,.6);
        background: transparent;
        color: #fff;
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .8px;
        text-transform: uppercase;
        text-decoration: none;
        transition: all .2s;
        cursor: pointer;
    }

    .btn-sso-panel:hover {
        background: rgba(255,255,255,.18);
        border-color: #fff;
    }

    /* Right form */
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
        color: #e85d6a;
        text-align: center;
        margin-bottom: 8px;
    }

    .auth-subtitle {
        text-align: center;
        font-size: 13px;
        color: #a0aec0;
        margin-bottom: 26px;
    }

    .input-group {
        position: relative;
        margin-bottom: 14px;
    }

    .input-icon {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #a0aec0;
        display: flex;
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
        background: #fff5f6;
        box-shadow: 0 0 0 2px #e85d6a;
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

    .check-row input { accent-color: #e85d6a; width: 15px; height: 15px; }
    .check-row label { font-size: 13px; color: #718096; font-weight: 500; cursor: pointer; }

    .btn-submit {
        width: 100%;
        padding: 13px;
        border-radius: 50px;
        border: none;
        background: #e85d6a;
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
        background: #d44f5c;
        transform: translateY(-1px);
    }

    .divider-or {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 20px 0;
        color: #a0aec0;
        font-size: 12px;
    }

    .divider-or::before,
    .divider-or::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e8ecf0;
    }
</style>
@endsection

@section('body')
<div class="auth-page">

    <div class="shape-teal"></div>
    <div class="shape-yellow"></div>

    <div class="auth-card">

        {{-- Left Panel --}}
        <div class="auth-panel">
            <div class="panel-shape-circle"></div>
            <div class="panel-shape-diamond"></div>
            <div class="panel-shape-diamond-sm"></div>

            <div class="panel-brand">
                <div class="panel-brand-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2C8 2 4 5 4 9c0 5.25 8 13 8 13s8-7.75 8-13c0-4-4-7-8-7z" fill="white" opacity=".9"/>
                        <circle cx="12" cy="9" r="2.5" fill="#e85d6a"/>
                    </svg>
                </div>
                <span class="panel-brand-name">Foodpanda</span>
            </div>

            <div class="panel-content">
                <div class="panel-heading">Hello Again!</div>
                <p class="panel-text">
                    Already have an Ecommerce account? Sign in instantly with SSO — no new password needed.
                </p>
                <a href="{{ route('sso.redirect') }}" class="btn-sso-panel">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    Login via Ecommerce SSO
                </a>
            </div>
        </div>

        {{-- Right Form --}}
        <div class="auth-form-wrap">
            <div class="auth-form-inner">

                <div class="auth-title">Sign In</div>
                <div class="auth-subtitle">Use your Foodpanda credentials</div>

                @if($errors->any())
                    <div style="background:#fff5f6;border:1px solid #fecdd3;color:#b83040;padding:11px 14px;border-radius:8px;font-size:13px;font-weight:500;margin-bottom:16px;display:flex;align-items:center;gap:8px">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    <div class="input-group">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </span>
                        <input
                            type="email"
                            name="email"
                            class="form-control-auth {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            placeholder="Email"
                            value="{{ old('email') }}"
                            required autofocus
                        >
                    </div>
                    @error('email')
                        <div class="form-err-msg">{{ $message }}</div>
                    @enderror

                    <div class="input-group">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <input
                            type="password"
                            name="password"
                            class="form-control-auth"
                            placeholder="Password"
                            required
                        >
                    </div>

                    <div class="check-row" style="margin-top:4px">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>

                    <button type="submit" class="btn-submit">Sign In</button>
                </form>

                <div class="divider-or">or continue with</div>

                <a href="{{ route('sso.redirect') }}"
                   style="display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:12px;border-radius:50px;border:1.5px solid #e8ecf0;background:#fff;color:#2d3748;font-family:'Inter',sans-serif;font-size:13px;font-weight:600;text-decoration:none;transition:all .15s;letter-spacing:.3px">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <rect x="3" y="3" width="7" height="7" rx="1" fill="#2ec4b6"/>
                        <rect x="14" y="3" width="7" height="7" rx="1" fill="#2ec4b6" opacity=".7"/>
                        <rect x="3" y="14" width="7" height="7" rx="1" fill="#2ec4b6" opacity=".7"/>
                        <rect x="14" y="14" width="7" height="7" rx="1" fill="#2ec4b6" opacity=".5"/>
                    </svg>
                    Continue with Ecommerce SSO
                </a>

            </div>
        </div>

    </div>
</div>
@endsection
