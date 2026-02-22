@extends('layouts.app')

@section('title', 'Sign In')

@section('styles')
<style>
    body { background: #f0f2f5; }

    /* Page wrapper */
    .auth-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        position: relative;
        overflow: hidden;
    }

    /* Corner decorative shapes — exactly like reference */
    .shape-coral {
        position: fixed;
        top: -40px;
        right: -40px;
        width: 130px;
        height: 130px;
        background: #e85d6a;
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

    /* The card */
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

    /* Left colored panel */
    .auth-panel {
        width: 310px;
        flex-shrink: 0;
        background: #2ec4b6;
        display: flex;
        flex-direction: column;
        padding: 32px 28px;
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    /* Panel decorative shapes */
    .panel-shape-circle {
        position: absolute;
        bottom: 50px;
        left: -50px;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        background: rgba(255,255,255,.12);
    }

    .panel-shape-diamond {
        position: absolute;
        top: 50%;
        right: 24px;
        width: 36px;
        height: 36px;
        background: rgba(255,255,255,.22);
        transform: translateY(-50%) rotate(45deg);
    }

    .panel-shape-diamond-sm {
        position: absolute;
        top: 36%;
        right: 60px;
        width: 16px;
        height: 16px;
        background: rgba(255,255,255,.18);
        transform: rotate(45deg);
    }

    /* Panel brand */
    .panel-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 90px;
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

    /* Panel content */
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
        margin-bottom: 32px;
    }

    .btn-panel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 28px;
        border-radius: 50px;
        border: 2px solid rgba(255,255,255,.6);
        background: transparent;
        color: #fff;
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        cursor: pointer;
        text-decoration: none;
        transition: all .2s;
    }

    .btn-panel:hover {
        background: rgba(255,255,255,.18);
        border-color: #fff;
    }

    /* Right form panel */
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
        color: #2ec4b6;
        text-align: center;
        margin-bottom: 28px;
    }

    .divider-text {
        text-align: center;
        color: #a0aec0;
        font-size: 12.5px;
        margin: 18px 0;
        position: relative;
    }

    .divider-text::before,
    .divider-text::after {
        content: '';
        position: absolute;
        top: 50%;
        width: 28%;
        height: 1px;
        background: #e8ecf0;
    }

    .divider-text::before { left: 0; }
    .divider-text::after  { right: 0; }

    /* Demo fill */
    .demo-fill {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        padding: 9px;
        border: 1.5px dashed #b2ede9;
        border-radius: 8px;
        background: #f0fdfb;
        color: #1a8f85;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        margin-bottom: 20px;
        font-family: 'Inter', sans-serif;
        transition: all .15s;
    }

    .demo-fill:hover { background: #e0f9f5; }

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
        background: #edf9f8;
        box-shadow: 0 0 0 2px #2ec4b6;
    }

    .form-control-auth.is-invalid {
        box-shadow: 0 0 0 2px #e85d6a;
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

    .check-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 22px;
    }

    .check-row input { accent-color: #2ec4b6; width: 15px; height: 15px; }

    .check-row label {
        font-size: 13px;
        color: #718096;
        font-weight: 500;
        cursor: pointer;
    }

    .btn-submit {
        width: 100%;
        padding: 13px;
        border-radius: 50px;
        border: none;
        background: #2ec4b6;
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
        background: #25a99d;
        transform: translateY(-1px);
    }

    .form-err-msg {
        font-size: 12px;
        color: #e85d6a;
        margin-top: -8px;
        margin-bottom: 10px;
        font-weight: 500;
        padding-left: 4px;
    }
</style>
@endsection

@section('body')
<div class="auth-page">

    {{-- Corner shapes --}}
    <div class="shape-coral"></div>
    <div class="shape-yellow"></div>

    <div class="auth-card">

        {{-- Left Panel --}}
        <div class="auth-panel">
            <div class="panel-shape-circle"></div>
            <div class="panel-shape-diamond"></div>
            <div class="panel-shape-diamond-sm"></div>

            {{-- Brand --}}
            <div class="panel-brand">
                <div class="panel-brand-icon">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7" rx="1" fill="white" opacity=".9"/>
                        <rect x="14" y="3" width="7" height="7" rx="1" fill="white" opacity=".7"/>
                        <rect x="3" y="14" width="7" height="7" rx="1" fill="white" opacity=".7"/>
                        <rect x="14" y="14" width="7" height="7" rx="1" fill="white" opacity=".5"/>
                    </svg>
                </div>
                <span class="panel-brand-name">Ecommerce</span>
            </div>

            {{-- Content --}}
            <div class="panel-content">
                <div class="panel-heading">Welcome Back!</div>
                <p class="panel-text">
                    Sign in to your account and access the Foodpanda platform instantly through SSO.
                </p>
                <a href="#" class="btn-panel">Learn More</a>
            </div>
        </div>

        {{-- Right Form --}}
        <div class="auth-form-wrap">
            <div class="auth-form-inner">

                <div class="auth-title">Sign In</div>

                @if($errors->any())
                    <div style="background:#fff5f5;border:1px solid #fed7d7;color:#c53030;padding:11px 14px;border-radius:8px;font-size:13px;font-weight:500;margin-bottom:16px;display:flex;align-items:center;gap:8px">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Demo fill button --}}
                <button class="demo-fill" type="button" onclick="fillDemo()">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    Fill Demo Credentials
                </button>

                <form method="POST" action="{{ route('login.post') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="input-group">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        </span>
                        <input
                            type="email"
                            id="email"
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

                    {{-- Password --}}
                    <div class="input-group">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <input
                            type="password"
                            id="password"
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

            </div>
        </div>

    </div>
</div>

<script>
function fillDemo() {
    document.getElementById('email').value    = '{{ config("mail.demo_email", "hmojammel29@gmail.com") }}';
    document.getElementById('password').value = 'admin';
}
</script>
@endsection
