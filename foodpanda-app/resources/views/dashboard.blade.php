@extends('layouts.app')

@section('title', 'Dashboard — Foodpanda')
@section('page-title', 'Overview')

@section('sidebar')
    <aside class="sidebar">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}" class="brand-logo">
                <div class="brand-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                        <path d="M12 2C8 2 4 5 4 9c0 5.25 8 13 8 13s8-7.75 8-13c0-4-4-7-8-7z" fill="white" opacity=".9"/>
                        <circle cx="12" cy="9" r="2.5" fill="#e85d6a"/>
                    </svg>
                </div>
                <div>
                    <div class="brand-name">Foodpanda</div>
                    <div class="brand-tag">Customer Panel</div>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav" style="margin-bottom: auto;">
            <a href="{{ route('dashboard') }}" class="nav-item active">
                <span class="nav-icon">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                </span>
                Dashboard
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-card">
                <div class="user-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ $user->name }}</div>
                    <div class="user-email">{{ $user->email }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="logout-btn" title="Logout">
                        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- SSO source card --}}
    <div class="sso-source-card">
        <div class="sso-icon-wrap">
            <svg width="24" height="24" fill="none" viewBox="0 0 24 24">
                <rect x="3" y="3" width="7" height="7" rx="1" fill="#2ec4b6"/>
                <rect x="14" y="3" width="7" height="7" rx="1" fill="#2ec4b6" opacity=".7"/>
                <rect x="3" y="14" width="7" height="7" rx="1" fill="#2ec4b6" opacity=".7"/>
                <rect x="14" y="14" width="7" height="7" rx="1" fill="#2ec4b6" opacity=".5"/>
            </svg>
        </div>
        <div class="sso-source-text">
            <h4>Signed in via Ecommerce SSO</h4>
            <p>Your identity was verified by the Ecommerce platform using OAuth 2.0 Authorization Code flow.</p>
        </div>
        <span class="sso-badge">
            <span class="live-dot"></span> SSO Active
        </span>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon-box">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div class="stat-value">{{ $user->name }}</div>
            <div class="stat-label">Account Name</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-box">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </div>
            <div class="stat-value" style="font-size:13px;margin-top:4px">{{ $user->email }}</div>
            <div class="stat-label">Email</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-box">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <div class="stat-value" style="color:#e85d6a">
                {{ $user->sso_id ? 'SSO User' : 'Local User' }}
            </div>
            <div class="stat-label">Account Type</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-box">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="stat-value">{{ $user->created_at->diffForHumans() }}</div>
            <div class="stat-label">Account Created</div>
        </div>
    </div>
@endsection
