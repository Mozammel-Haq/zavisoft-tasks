<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Inventory') — ZaviSoft</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; overflow-x: hidden; }

        :root {
            --brand:          #6366f1;
            --brand-dark:     #4f46e5;
            --brand-light:    #eef2ff;
            --brand-text:     #4338ca;

            --teal:           #2ec4b6;
            --coral:          #e85d6a;
            --yellow:         #f5c842;
            --green:          #10b981;
            --green-bg:       #ecfdf5;
            --green-border:   #a7f3d0;

            --surface:        #ffffff;
            --bg:             #f4f6fb;
            --border:         #dfe5f2;
            --input-bg:       #f4f6f8;

            --text-primary:   #1e2433;
            --text-secondary: #64748b;
            --text-muted:     #a0aec0;

            --sidebar-w:      260px;
            --radius:         14px;
            --radius-sm:      8px;
            --radius-pill:    50px;

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

        /* ── App Shell ──────────────────────────────── */
        .app-shell {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* ── Sidebar ────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--brand);
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            overflow-y: auto;
            overflow-x: hidden
            position: relative;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            bottom: 80px;
            left: -45px;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(255,255,255,.08);
            pointer-events: none;
        }

        .sidebar::after {
            content: '';
            position: absolute;
            top: 140px;
            right: -35px;
            width: 100px;
            height: 100px;
            background: rgba(255,255,255,.06);
            transform: rotate(45deg);
            pointer-events: none;
        }

        .sidebar-brand {
            padding: 26px 22px 20px;
            border-bottom: 1px solid rgba(255,255,255,.12);
            position: relative;
            z-index: 1;
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
            background: rgba(255,255,255,.18);
            border: 1.5px solid rgba(255,255,255,.3);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .brand-name {
            font-size: 15px;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
        }

        .brand-tag {
            font-size: 10.5px;
            font-weight: 500;
            color: rgba(255,255,255,.6);
            letter-spacing: .3px;
        }

        .sidebar-nav {
            padding: 16px 12px;
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.2px;
            color: rgba(255,255,255,.45);
            text-transform: uppercase;
            padding: 0 10px;
            margin-bottom: 6px;
            margin-top: 20px;
        }

        .nav-section-label:first-child { margin-top: 4px; }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: var(--radius-sm);
            text-decoration: none;
            color: rgba(255,255,255,.72);
            font-size: 13.5px;
            font-weight: 500;
            transition: all .15s;
            margin-bottom: 2px;
        }

        .nav-item:hover {
            background: rgba(255,255,255,.12);
            color: #fff;
        }

        .nav-item.active {
            background: rgba(255,255,255,.18);
            color: #fff;
            font-weight: 600;
        }

        .nav-icon {
            width: 18px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255,255,255,.7);
        }

        .nav-item.active .nav-icon,
        .nav-item:hover .nav-icon { color: #fff; }

        .sidebar-footer {
            padding: 14px 16px 20px;
            border-top: 1px solid rgba(255,255,255,.12);
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
            background: rgba(255,255,255,.22);
            border: 1.5px solid rgba(255,255,255,.35);
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

        .user-role {
            font-size: 11px;
            color: rgba(255,255,255,.55);
        }

        .logout-btn {
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.2);
            cursor: pointer;
            color: rgba(255,255,255,.75);
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
            background: rgba(232,93,106,.3);
            border-color: rgba(232,93,106,.5);
            color: #fff;
        }

        /* ── Main Area ──────────────────────────────── */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .topbar {
            height: 62px;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 30px;
            gap: 14px;
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
            border: 1px solid #c7d2fe;
        }


        @keyframes blink {
            0%,100% { opacity: 1; }
            50%      { opacity: .3; }
        }

        .content {
            flex: 1;
            overflow-y: auto;
            padding: 30px;
        }

        /* ── Page Header ────────────────────────────── */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
            background-color: var(--brand);
            padding: 25px ;
            border-radius: 8px;
        }

        .page-header-text h1 {
            font-size: 20px;
            font-weight: 750;
            color: white;
            margin-bottom: 3px;
        }

        .page-header-text p {
            font-size: 13px;
            color: white;
        }

        /* ── Cards ──────────────────────────────────── */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .card-header-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .card-body { padding: 24px; }

        /* ── Stat Grid ──────────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(175px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 20px;
        }

        .stat-icon-box {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 14px;
        }

        .stat-icon-box.purple { background: var(--brand-light); color: var(--brand); }
        .stat-icon-box.teal   { background: #e8faf8; color: var(--teal); }
        .stat-icon-box.coral  { background: #fff0f1; color: var(--coral); }
        .stat-icon-box.yellow { background: #fffbeb; color: #b45309; }
        .stat-icon-box.green  { background: var(--green-bg); color: var(--green); }

        .stat-value {
            font-size: 22px;
            font-weight: 750;
            color: var(--text-primary);
            line-height: 1;
            margin-bottom: 5px;
            overflow: hidden
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-secondary);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        /* ── Table ──────────────────────────────────── */
        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            padding: 14px 18px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: var(--text-muted);
            background: var(--bg);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        tbody td {
            padding: 13px 16px;
            font-size: 13.5px;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        tbody tr:last-child td { border-bottom: none; }

        tbody tr:hover td { background: #fafbff; }

        tfoot td {
            padding: 12px 16px;
            font-size: 13px;
            font-weight: 700;
            background: var(--bg);
            border-top: 2px solid var(--border);
        }

        /* ── Badges ─────────────────────────────────── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 600;
        }

        .badge-paid    { background: var(--green-bg);   color: #065f46; border: 1px solid var(--green-border); }
        .badge-partial { background: #fffbeb;            color: #92400e; border: 1px solid #fde68a; }
        .badge-due     { background: #fff0f1;            color: #9f1239; border: 1px solid #fecdd3; }
        .badge-asset   { background: var(--brand-light); color: var(--brand-text); border: 1px solid #c7d2fe; }
        .badge-income  { background: var(--green-bg);   color: #065f46; border: 1px solid var(--green-border); }
        .badge-expense { background: #fff0f1;            color: #9f1239; border: 1px solid #fecdd3; }
        .badge-liability { background: #fffbeb;          color: #92400e; border: 1px solid #fde68a; }

        /* ── Buttons ────────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 20px;
            border-radius: var(--radius-pill);
            font-family: var(--font);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .3px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all .16s ease;
            white-space: nowrap;
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
            color: white;
            border: 1.5px solid white;
        }

        .btn-outline:hover { background: var(--brand-dark); }

        .btn-ghost {
            background: var(--bg);
            color: var(--text-secondary);
            border: 1px solid var(--border);
        }

        .btn-ghost:hover { background: var(--border); }

        .btn-sm {
            padding: 6px 14px;
            font-size: 12px;
        }

        /* ── Forms ──────────────────────────────────── */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 18px;
        }

        .form-group { margin-bottom: 0; }

        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            color: var(--text-secondary);
            margin-bottom: 7px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .input-wrap { position: relative; }

        .input-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            display: flex;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px 11px 40px;
            border: 1.5px solid var(--border);
            border-radius: var(--radius-sm);
            font-family: var(--font);
            font-size: 14px;
            color: var(--text-primary);
            background: var(--surface);
            transition: all .15s;
            outline: none;
        }

        .form-control.no-icon { padding-left: 14px; }

        .form-control:focus {
            border-color: var(--brand);
            background: #fff;
        }

        .form-control.is-invalid { border-color: var(--coral); }

        .form-error {
            font-size: 12px;
            color: var(--coral);
            margin-top: 5px;
            font-weight: 500;
        }

        /* ── Alerts ─────────────────────────────────── */
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
            background: var(--green-bg);
            color: #065f46;
            border: 1px solid var(--green-border);
        }

        .alert-danger {
            background: #fff0f1;
            color: #9f1239;
            border: 1px solid #fecdd3;
        }

        /* ── Pagination ─────────────────────────────── */
        .pagination-wrap {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13px;
            color: var(--text-secondary);
        }

        .pagination {
            display: flex;
            gap: 4px;
            list-style: none;
        }

        .pagination li a,
        .pagination li span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            color: var(--text-secondary);
            border: 1px solid var(--border);
            background: var(--surface);
            transition: all .15s;
        }

        .pagination li.active span,
        .pagination li a:hover {
            background: var(--brand);
            color: #fff;
            border-color: var(--brand);
        }
    </style>

    @yield('styles')
</head>
<body>
@yield('body')
</body>
</html>
