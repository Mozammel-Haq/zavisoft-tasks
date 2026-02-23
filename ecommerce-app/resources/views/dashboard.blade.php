@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Overview')

@section('styles')
<style>
    .page-header {
        margin-bottom: 28px;
    }

    .page-header h1 {
        font-size: 22px;
        font-weight: 750;
        color: white;
        margin-bottom: 4px;
    }

    .page-header p {
        font-size: 13.5px;
        color: var(--text-secondary);
    }

    /* SSO Launch Card */
    .sso-card {
        background: #2ec4b6;
        border-radius: var(--radius);
        padding: 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }

    .sso-card::before {
        content: '';
        position: absolute;
        right: -40px;
        top: -40px;
        width: 160px;
        height: 160px;
        border-radius: 50%;
        background: rgba(255,255,255,.1);
    }

    .sso-card::after {
        content: '';
        position: absolute;
        right: 80px;
        bottom: -30px;
        width: 100px;
        height: 100px;
        transform: rotate(45deg);
        background: rgba(255,255,255,.07);
    }

    .sso-card-text { position: relative; z-index: 1; }

    .sso-card-text h3 {
        font-size: 18px;
        font-weight: 750;
        color: #fff;
        margin-bottom: 6px;
    }

    .sso-card-text p {
        font-size: 13.5px;
        color: rgba(255,255,255,.8);
        line-height: 1.5;
    }

    .btn-sso-launch {
        position: relative;
        z-index: 1;
        flex-shrink: 0;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 26px;
        border-radius: 50px;
        border: 2px solid rgba(255,255,255,.6);
        background: transparent;
        color: #fff;
        font-family: 'Inter', sans-serif;
        font-size: 12.5px;
        font-weight: 700;
        letter-spacing: .6px;
        text-transform: uppercase;
        text-decoration: none;
        transition: all .2s;
        white-space: nowrap;
    }

    .btn-sso-launch:hover {
        background: rgba(255,255,255,.2);
        border-color: #fff;
        transform: translateY(-1px);
    }

    /* Stat cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 22px;
    }

    .stat-icon-box {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: var(--brand-light);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        color: var(--brand-text);
    }

    .stat-value {
        font-size: 18px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 4px;
        word-break: break-all;
    }

    .stat-label {
        font-size: 12px;
        color: var(--text-secondary);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    /* Token box */
    .token-box {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 24px 28px;
    }

    .token-box-title {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .token-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
        background: var(--brand-light);
        color: var(--brand-text);
        border: 1px solid #b2ede9;
    }

    .token-val {
        font-family: 'Courier New', monospace;
        font-size: 12px;
        color: var(--text-secondary);
        background: var(--input-bg);
        padding: 10px 14px;
        border-radius: var(--radius-sm);
        word-break: break-all;
        line-height: 1.6;
    }
</style>
@endsection

@section('body')
<div class="app-shell">

    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="sidebar-brand" style="padding-bottom:20px;border-bottom:1px solid rgba(255,255,255,.15)">
            <a href="{{ route('dashboard') }}" class="brand-logo">
                <div class="brand-icon">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7" rx="1" fill="white" opacity=".9"/>
                        <rect x="14" y="3" width="7" height="7" rx="1" fill="white" opacity=".7"/>
                        <rect x="3" y="14" width="7" height="7" rx="1" fill="white" opacity=".7"/>
                        <rect x="14" y="14" width="7" height="7" rx="1" fill="white" opacity=".5"/>
                    </svg>
                </div>
                <div>
                    <div class="brand-name">Ecommerce</div>
                    <div class="brand-tag">Admin Panel</div>
                </div>
            </a>
        </div>
{{--
        <div class="sidebar-welcome">
            <h2>Hello,<br>{{ explode(' ', $user->name)[0] }}!</h2>
            <p>You are logged in and your SSO session is active.</p>
        </div> --}}

        <nav class="sidebar-nav" style="padding-top:30px">
            <a href="{{ route('dashboard') }}" class="nav-item active">
                <span class="nav-icon">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                </span>
                Dashboard
            </a>
        </nav>

        <div class="sidebar-action">
            <a href="{{ config('app.foodpanda_url', 'http://127.0.0.1:8001') }}/auth/redirect"
               class="btn-sidebar-action">
                Launch Foodpanda
            </a>
        </div>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ $user->name }}</div>
                    <div class="user-email">{{ $user->email }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button class="logout-btn" title="Logout">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Main --}}
    <div class="main">
        <header class="topbar">
            <span class="topbar-title">Overview</span>
        </header>

        <div class="content">

            @if(session('success'))
                <div class="alert alert-success">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ session('success') }}
                </div>
            @endif



            {{-- SSO Card --}}
            <div class="sso-card">

                <div class="sso-card-text">
                                               <div class="page-header">
                <h1>Welcome back, {{ explode(' ', $user->name)[0] }}</h1>
                <p>Your ecommerce session is active. Launch Foodpanda with one click using SSO.</p>
            </div>
                </div>
                <a href="{{ config('app.foodpanda_url', 'http://127.0.0.1:8001') }}/auth/redirect"
                   class="btn-sso-launch">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    Open Foodpanda
                </a>
            </div>

            {{-- Stats --}}
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon-box">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    </div>
                    <div class="stat-value">{{ explode(' ', $user->name)[0] }}</div>
                    <div class="stat-label">Logged in as</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-box">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    </div>
                    <div class="stat-value" style="font-size:13px;margin-top:4px">{{ $user->email }}</div>
                    <div class="stat-label">Account Email</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-box">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    </div>
                    <div class="stat-value" style="color:#2ec4b6">Active</div>
                    <div class="stat-label">SSO Token</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-box">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div class="stat-value">OAuth 2.0</div>
                    <div class="stat-label">Protocol</div>
                </div>
            </div>

            {{-- Token info --}}
            @if($ssoToken)
            <div class="token-box">
                <div class="token-box-title">
                    Active SSO Token
                </div>
                <div class="token-val">{{ Str::limit($ssoToken, 80) }}...</div>
            </div>
            @endif

        </div>
    </div>

</div>
@endsection
