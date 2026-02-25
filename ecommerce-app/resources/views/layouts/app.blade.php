<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ecommerce') — ZaviSoft</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        *::-webkit-scrollbar { width: 6px; height: 6px; }
        *::-webkit-scrollbar-track { background: transparent; }
        *::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

        :root {
            --brand:         #2ec4b6;
            --brand-dark:    #25a99d;
            --brand-light:   #e8faf8;
            --brand-text:    #1a8f85;

            --coral:         #e85d6a;
            --yellow:        #f5c842;

            --surface:       #ffffff;
            --bg:            #f4f6fb;
            --border:        #dfe5f2;
            --input-bg:      #f4f6f8;

            --text-primary:   #1e2433;
            --text-secondary: #64748b;
            --text-muted:     #a0aec0;

            --sidebar-w:     260px;
            --radius:        14px;
            --radius-sm:     8px;
            --radius-pill:   50px;

            --font: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        html, body {
            height: 100%;
            font-family: var(--font);
            font-size: 14px;
            color: var(--text-primary);
            background: var(--bg);
            -webkit-font-smoothing: antialiased;
        }


        /* Shell */
        .app-shell {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--brand);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            overflow-y: auto;
            position: relative;
        }

        /* Decorative shapes inside sidebar */
        .sidebar::before {
            content: '';
            position: absolute;
            bottom: 60px;
            left: -40px;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: rgba(255,255,255,.1);
            pointer-events: none;
        }

        .sidebar::after {
            content: '';
            position: absolute;
            top: 120px;
            right: -30px;
            width: 90px;
            height: 90px;
            background: rgba(255,255,255,.08);
            transform: rotate(45deg);
            pointer-events: none;
        }

        .sidebar-brand {
            padding: 28px 24px 24px;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .brand-icon {
            width: 38px;
            height: 38px;
            background: rgba(255,255,255,.2);
            border: 1.5px solid rgba(255,255,255,.35);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-name {
            font-size: 16px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -.2px;
        }

        .brand-tag {
            font-size: 10.5px;
            font-weight: 500;
            color: rgba(255,255,255,.65);
            letter-spacing: .3px;
        }

        /* Sidebar welcome block */
        .sidebar-welcome {
            padding: 20px 24px 28px;
            border-top: 1px solid rgba(255,255,255,.15);
        }

        .sidebar-welcome h2 {
            font-size: 22px;
            font-weight: 800;
            color: #fff;
            line-height: 1.25;
            margin-bottom: 10px;
        }

        .sidebar-welcome p {
            font-size: 13px;
            color: rgba(255,255,255,.72);
            line-height: 1.6;
        }

        /* Nav */
        .sidebar-nav {
            padding: 8px 16px;
            flex: 1;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: var(--radius-sm);
            text-decoration: none;
            color: rgba(255,255,255,.78);
            font-size: 13.5px;
            font-weight: 500;
            transition: all .15s;
            margin-bottom: 2px;
        }

        .nav-item:hover, .nav-item.active {
            background: rgba(255,255,255,.15);
            color: #fff;
        }

        .nav-icon {
            width: 18px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Sidebar action button */
        .sidebar-action {
            padding: 20px 24px 24px;
            position: relative;
            z-index: 1;
        }

        .btn-sidebar-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            padding: 12px 20px;
            background: transparent;
            border: 2px solid rgba(255,255,255,.5);
            border-radius: var(--radius-pill);
            color: #fff;
            font-family: var(--font);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .5px;
            text-transform: uppercase;
            text-decoration: none;
            cursor: pointer;
            transition: all .2s;
        }

        .btn-sidebar-action:hover {
            background: rgba(255,255,255,.15);
            border-color: rgba(255,255,255,.8);
        }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 16px 24px 20px;
            border-top: 1px solid rgba(255,255,255,.15);
            position: relative;
            z-index: 1;
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255,255,255,.25);
            border: 1.5px solid rgba(255,255,255,.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .user-info { flex: 1; min-width: 0; }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: #fff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-email {
            font-size: 11px;
            color: rgba(255,255,255,.6);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .logout-form { margin: 0; }

        .logout-btn {
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.25);
            cursor: pointer;
            color: rgba(255,255,255,.8);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .15s;
            flex-shrink: 0;
        }

        .logout-btn:hover {
            background: rgba(255,255,255,.25);
            color: #fff;
        }

        /* ── Main Content ─────────────────────────── */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
        }

        .topbar {
            height: 62px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 32px;
            gap: 12px;
            flex-shrink: 0;
        }

        .topbar-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-primary);
            flex: 1;
        }

        .topbar-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 14px;
            border-radius: var(--radius-pill);
            font-size: 12px;
            font-weight: 600;
            background: var(--brand-light);
            color: var(--brand-text);
            border: 1px solid #b2ede9;
        }

        .live-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--brand);
            animation: blink 2s infinite;
        }

        @keyframes blink {
            0%,100% { opacity: 1; }
            50%      { opacity: .3; }
        }

        .content {
            flex: 1;
            overflow-y: auto;
            padding: 32px;
            scroll-behavior: smooth;
        }

        .main-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 32px;
            min-height: 100%;
        }

        /* ── Mobile Toggle ────────────────────────── */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--text-primary);
            cursor: pointer;
            padding: 8px;
            margin-left: -8px;
        }

        /* ── Overlay ──────────────────────────────── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(2px);
            z-index: 40;
        }

        /* ── Responsive ───────────────────────────── */
        @media (max-width: 1024px) {
            .sidebar {
                position: fixed;
                left: -100%;
                top: 0;
                bottom: 0;
                z-index: 50;
                transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .sidebar.active {
                left: 0;
            }

            .sidebar-overlay.active {
                display: block;
            }

            .mobile-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .topbar {
                padding: 0 20px;
            }

            .content {
                padding: 20px;
            }

            .main-card {
                padding: 24px;
            }
        }

        @media (max-width: 640px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .sso-card {
                flex-direction: column;
                align-items: flex-start;
                padding: 24px;
            }

            .btn-sso-launch {
                width: 100%;
                justify-content: center;
            }
        }

        /* ── Cards ────────────────────────────────── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
        }

        .card-body { padding: 28px; }

        .card-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .card-subtitle {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* ── Stat Grid ────────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 22px;
        }

        .stat-icon-wrap {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            background: var(--brand-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }

        .stat-value {
            font-size: 22px;
            font-weight: 750;
            color: var(--text-primary);
            line-height: 1;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 12.5px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        /* ── Alerts ───────────────────────────────── */
        .alert {
            padding: 13px 16px;
            border-radius: var(--radius-sm);
            font-size: 13.5px;
            font-weight: 500;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: var(--brand-light);
            color: var(--brand-text);
            border: 1px solid #b2ede9;
        }

        .alert-danger {
            background: #fff5f5;
            color: #c53030;
            border: 1px solid #fed7d7;
        }

        /* ── Buttons ──────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 10px 22px;
            border-radius: var(--radius-pill);
            font-family: var(--font);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .3px;
            text-transform: uppercase;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all .18s ease;
        }

        .btn-primary {
            background: var(--brand);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--brand-dark);
            transform: translateY(-1px);
        }

        .btn-outline {
            background: transparent;
            color: var(--brand-text);
            border: 1.5px solid var(--brand);
        }

        .btn-outline:hover {
            background: var(--brand-light);
        }

        .btn-full { width: 100%; justify-content: center; }

        /* ── Forms ────────────────────────────────── */
        .form-group { margin-bottom: 16px; }

        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            display: flex;
            align-items: center;
        }

        .form-control {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1.5px solid transparent;
            border-radius: var(--radius-sm);
            font-family: var(--font);
            font-size: 14px;
            color: var(--text-primary);
            background: var(--input-bg);
            transition: all .15s;
            outline: none;
        }

        .form-control:focus {
            background: #fff;
            border-color: var(--brand);
        }

        .form-control.is-invalid {
            border-color: var(--coral);
            background: #fff;
        }

        .form-error {
            font-size: 12px;
            color: var(--coral);
            margin-top: 5px;
            font-weight: 500;
        }
    </style>

    @yield('styles')
</head>
<body>

@section('body')
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<div class="app-shell">
    @yield('sidebar')

    <div class="main">
        <header class="topbar">
            <button class="mobile-toggle" id="mobileToggle">
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>
            <span class="topbar-title">@yield('page-title')</span>
            @yield('topbar-actions')
        </header>

        <div class="content">
            <div class="main-card">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script>
    const mobileToggle = document.getElementById('mobileToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const sidebar = document.querySelector('.sidebar');

    if (mobileToggle && sidebar) {
        mobileToggle.addEventListener('click', () => {
            sidebar.classList.add('active');
            sidebarOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', () => {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
</script>
@show

</body>
</html>
