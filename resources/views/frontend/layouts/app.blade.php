<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'IMS') — Intern Management System</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@3.9.0/dist/tabler-icons.min.css">

    <style>
        /* =====================================================
           RESET & BASE
        ===================================================== */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            /* Brand */
            --brand:           #185FA5;
            --brand-hover:     #0C447C;
            --brand-light:     #E6F1FB;
            --brand-text:      #185FA5;

            /* Layout sizes */
            --sidebar-width:   240px;
            --header-height:   56px;
            --footer-height:   48px;

            /* Surfaces */
            --surface:         #ffffff;
            --surface-2:       #F4F6F9;
            --border:          rgba(0, 0, 0, 0.08);
            --border-strong:   rgba(0, 0, 0, 0.14);

            /* Text */
            --text-primary:    #111827;
            --text-secondary:  #6B7280;
            --text-muted:      #9CA3AF;

            /* Semantic */
            --success:         #0F6E56;
            --success-bg:      #E1F5EE;
            --warning:         #854F0B;
            --warning-bg:      #FAEEDA;
            --danger:          #A32D2D;
            --danger-bg:       #FCEBEB;
            --info:            #185FA5;
            --info-bg:         #E6F1FB;

            /* Misc */
            --radius:          8px;
            --radius-lg:       12px;
            --shadow-sm:       0 1px 3px rgba(0,0,0,0.06);
            --transition:      0.15s ease;
        }

        html, body { height: 100%; }

        body {
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: var(--text-primary);
            background: var(--surface-2);
        }

        a { color: inherit; text-decoration: none; }
        button { font-family: inherit; cursor: pointer; }

        /* =====================================================
           LAYOUT SHELL
           sidebar fixed left | main-wrap fills rest
        ===================================================== */
        .layout {
            display: flex;
            min-height: 100vh;
        }

        /* =====================================================
           SIDEBAR
        ===================================================== */
        .sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            z-index: 200;
            overflow-y: auto;
            overflow-x: hidden;
            transition: transform var(--transition);
        }

        /* Logo */
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            height: var(--header-height);
            padding: 0 20px;
            border-bottom: 1px solid var(--border);
            flex-shrink: 0;
        }

        .sidebar-logo-icon {
            width: 32px; height: 32px;
            background: var(--brand);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #fff;
            font-size: 17px;
            flex-shrink: 0;
        }

        .sidebar-logo-name {
            display: block;
            font-size: 15px;
            font-weight: 600;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .sidebar-logo-sub {
            display: block;
            font-size: 10.5px;
            font-weight: 400;
            color: var(--text-muted);
            letter-spacing: 0.2px;
        }

        /* Nav */
        .sidebar-nav {
            flex: 1;
            padding: 8px 0;
        }

        /* section group: label + list */
        .nav-group {
            padding: 12px 12px 4px;
        }

        .nav-group-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.7px;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 0 8px;
            margin-bottom: 4px;
        }

        .nav-list {
            list-style: none;
        }

        .nav-list a {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 8px 10px;
            border-radius: var(--radius);
            color: var(--text-secondary);
            font-size: 13.5px;
            transition: background var(--transition), color var(--transition);
        }

        .nav-list a:hover {
            background: var(--surface-2);
            color: var(--text-primary);
        }

        .nav-list a.active {
            background: var(--brand-light);
            color: var(--brand);
            font-weight: 500;
        }

        .nav-list a i {
            font-size: 18px;
            flex-shrink: 0;
        }

        .nav-badge {
            margin-left: auto;
            background: var(--danger-bg);
            color: var(--danger);
            font-size: 10px;
            font-weight: 600;
            padding: 1px 6px;
            border-radius: 20px;
            line-height: 1.6;
        }

        /* Footer */
        .sidebar-footer {
            border-top: 1px solid var(--border);
            padding: 10px 12px;
            flex-shrink: 0;
        }

        .sidebar-user-card {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 7px 8px;
            border-radius: var(--radius);
            transition: background var(--transition);
        }

        .sidebar-user-card:hover { background: var(--surface-2); }

        .sidebar-user-info {
            flex: 1;
            min-width: 0;
        }

        .sidebar-user-name {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            display: block;
            font-size: 11px;
            color: var(--text-muted);
        }

        .sidebar-logout-btn {
            width: 28px; height: 28px;
            border: none;
            background: transparent;
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-muted);
            transition: background var(--transition), color var(--transition);
            flex-shrink: 0;
        }

        .sidebar-logout-btn:hover {
            background: var(--danger-bg);
            color: var(--danger);
        }

        .sidebar-logout-btn i { font-size: 16px; }

        /* =====================================================
           AVATAR (shared)
        ===================================================== */
        .avatar {
            border-radius: 50%;
            background: var(--brand-light);
            color: var(--brand);
            display: flex; align-items: center; justify-content: center;
            font-weight: 600;
            flex-shrink: 0;
        }

        .avatar-sm  { width: 32px; height: 32px; font-size: 12px; }
        .avatar-md  { width: 38px; height: 38px; font-size: 14px; }
        .avatar-lg  { width: 44px; height: 44px; font-size: 15px; }

        /* =====================================================
           MAIN WRAPPER (header + page + footer)
        ===================================================== */
        .main-wrap {
            margin-left: var(--sidebar-width);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* =====================================================
           HEADER
        ===================================================== */
        .header {
            position: sticky;
            top: 0;
            z-index: 100;
            height: var(--header-height);
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 12px;
        }

        .header-left {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .sidebar-toggle {
            width: 32px; height: 32px;
            border: none;
            background: transparent;
            border-radius: var(--radius);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-secondary);
            transition: background var(--transition);
            display: none; /* hiện trên mobile */
        }

        .sidebar-toggle:hover { background: var(--surface-2); }
        .sidebar-toggle i { font-size: 20px; }

        /* Breadcrumb */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--text-muted);
        }

        .breadcrumb a { color: var(--text-muted); }
        .breadcrumb a:hover { color: var(--text-primary); }
        .breadcrumb .crumb-sep { font-size: 10px; color: var(--text-muted); }
        .breadcrumb .crumb-current { color: var(--text-primary); font-weight: 500; }

        /* Header icon button */
        .header-icon-btn {
            position: relative;
            width: 34px; height: 34px;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            background: transparent;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-secondary);
            transition: background var(--transition), color var(--transition);
        }

        .header-icon-btn:hover { background: var(--surface-2); color: var(--text-primary); }
        .header-icon-btn i { font-size: 18px; }

        .notif-badge {
            position: absolute;
            top: 5px; right: 5px;
            min-width: 7px; height: 7px;
            background: var(--danger);
            border-radius: 50%;
            border: 1.5px solid var(--surface);
        }

        .header-user {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px 10px 4px 4px;
            border: 1px solid var(--border);
            border-radius: 20px;
            cursor: pointer;
            transition: background var(--transition);
        }

        .header-user:hover { background: var(--surface-2); }

        .header-user-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
        }

        /* =====================================================
           PAGE CONTENT AREA
        ===================================================== */
        .page-wrapper {
            flex: 1;
            padding: 28px;
        }

        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
        }

        .page-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-primary);
            line-height: 1.3;
        }

        .page-subtitle {
            font-size: 13px;
            color: var(--text-secondary);
            margin-top: 3px;
        }

        .page-actions {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        /* =====================================================
           FOOTER
        ===================================================== */
        .footer {
            height: var(--footer-height);
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 8px;
            font-size: 12px;
            color: var(--text-muted);
        }

        .footer-sep { color: var(--border-strong); }

        .footer-link {
            color: var(--text-muted);
            transition: color var(--transition);
        }

        .footer-link:hover { color: var(--brand); }

        /* =====================================================
           FLASH MESSAGES
        ===================================================== */
        .flash {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 11px 16px;
            border-radius: var(--radius);
            font-size: 13.5px;
            margin-bottom: 20px;
        }

        .flash i { font-size: 16px; flex-shrink: 0; }
        .flash-success { background: var(--success-bg); color: var(--success); }
        .flash-error   { background: var(--danger-bg);  color: var(--danger); }
        .flash-info    { background: var(--info-bg);    color: var(--info); }

        /* =====================================================
           SHARED UI — Buttons
        ===================================================== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: var(--radius);
            font-size: 13.5px;
            font-weight: 500;
            font-family: inherit;
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            line-height: 1;
            transition: all var(--transition);
        }

        .btn i { font-size: 16px; }

        .btn-sm { padding: 5px 12px; font-size: 12.5px; }
        .btn-sm i { font-size: 14px; }

        .btn-primary {
            background: var(--brand);
            color: #fff;
            border-color: var(--brand);
        }
        .btn-primary:hover { background: var(--brand-hover); border-color: var(--brand-hover); }

        .btn-outline {
            background: transparent;
            color: var(--text-primary);
            border-color: var(--border-strong);
        }
        .btn-outline:hover { background: var(--surface-2); }

        .btn-danger {
            background: var(--danger);
            color: #fff;
            border-color: var(--danger);
        }

        .btn-danger-outline {
            background: transparent;
            color: var(--danger);
            border-color: rgba(163,45,45,.25);
        }
        .btn-danger-outline:hover { background: var(--danger-bg); }

        /* =====================================================
           SHARED UI — Cards
        ===================================================== */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-bottom: 1px solid var(--border);
        }

        .card-title { font-size: 14px; font-weight: 600; }
        .card-body  { padding: 20px; }

        /* =====================================================
           SHARED UI — Stat cards
        ===================================================== */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 16px 18px;
        }

        .stat-label {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 11.5px;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 8px;
        }

        .stat-label i { font-size: 14px; }
        .stat-value { font-size: 28px; font-weight: 600; line-height: 1; }
        .stat-sub   { font-size: 11.5px; color: var(--text-muted); margin-top: 4px; }

        /* =====================================================
           SHARED UI — Table
        ===================================================== */
        .table-wrap { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; }

        thead th {
            text-align: left;
            font-size: 11.5px;
            font-weight: 600;
            letter-spacing: 0.3px;
            color: var(--text-muted);
            padding: 10px 16px;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        tbody td {
            padding: 12px 16px;
            font-size: 13.5px;
            border-bottom: 1px solid var(--border);
        }

        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover td { background: var(--surface-2); }

        /* =====================================================
           SHARED UI — Form
        ===================================================== */
        .form-group { margin-bottom: 18px; }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .form-required { color: var(--danger); }

        .form-control {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid var(--border-strong);
            border-radius: var(--radius);
            font-size: 13.5px;
            font-family: inherit;
            color: var(--text-primary);
            background: var(--surface);
            outline: none;
            transition: border-color var(--transition), box-shadow var(--transition);
        }

        .form-control:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 3px rgba(24, 95, 165, .1);
        }

        .form-control.is-invalid { border-color: var(--danger); }
        textarea.form-control { resize: vertical; min-height: 88px; }

        .form-hint  { font-size: 12px; color: var(--text-muted); margin-top: 4px; }
        .form-error { font-size: 12px; color: var(--danger); margin-top: 4px; }

        .form-row   { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-row-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }

        .form-footer {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
            padding-top: 16px;
            margin-top: 8px;
            border-top: 1px solid var(--border);
        }

        /* =====================================================
           SHARED UI — Badges
        ===================================================== */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 11.5px;
            font-weight: 500;
            white-space: nowrap;
        }

        .badge-todo    { background: #F1EFE8; color: #5F5E5A; }
        .badge-doing   { background: var(--info-bg);    color: var(--info); }
        .badge-review  { background: var(--warning-bg); color: var(--warning); }
        .badge-done    { background: var(--success-bg); color: var(--success); }
        .badge-danger  { background: var(--danger-bg);  color: var(--danger); }

        /* =====================================================
           SHARED UI — Priority
        ===================================================== */
        .priority {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
        }

        .priority-dot {
            width: 7px; height: 7px;
            border-radius: 50%;
        }

        .priority-high   .priority-dot { background: var(--danger); }
        .priority-medium .priority-dot { background: #EF9F27; }
        .priority-low    .priority-dot { background: var(--success); }

        /* =====================================================
           SHARED UI — Empty state
        ===================================================== */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }

        .empty-state i {
            display: block;
            font-size: 38px;
            color: var(--text-muted);
            margin-bottom: 10px;
        }

        .empty-state-title {
            font-size: 14px;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .empty-state-sub {
            font-size: 13px;
            color: var(--text-muted);
        }

        /* =====================================================
           RESPONSIVE — mobile sidebar toggle
        ===================================================== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
                box-shadow: 4px 0 20px rgba(0,0,0,.15);
            }

            .main-wrap {
                margin-left: 0;
            }

            .sidebar-toggle {
                display: flex;
            }

            .page-wrapper {
                padding: 16px;
            }

            .form-row, .form-row-3 {
                grid-template-columns: 1fr;
            }
        }

        /* =====================================================
           UTILITY
        ===================================================== */
        .d-flex         { display: flex; }
        .align-center   { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-4  { gap: 4px; }
        .gap-8  { gap: 8px; }
        .gap-12 { gap: 12px; }
        .gap-16 { gap: 16px; }
        .mt-4   { margin-top: 4px; }
        .mt-8   { margin-top: 8px; }
        .mt-16  { margin-top: 16px; }
        .mt-20  { margin-top: 20px; }
        .mb-16  { margin-bottom: 16px; }
        .mb-20  { margin-bottom: 20px; }
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }
        .text-muted   { color: var(--text-muted); }
        .text-sm      { font-size: 12px; }
        .text-danger  { color: var(--danger); }
        .text-success { color: var(--success); }
        .font-medium  { font-weight: 500; }
        .font-semibold { font-weight: 600; }
        .truncate     { overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
        .w-full       { width: 100%; }
    </style>

    @stack('styles')
</head>
<body>
<div class="layout">

    {{-- Sidebar partial —— nav được override bởi layout con --}}
    @include('components._sidebar')

    {{-- Main wrapper --}}
    <div class="main-wrap">

        {{-- Header partial --}}
        @include('components._header')

        {{-- Page content --}}
        <main class="page-wrapper">

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="flash flash-success">
                    <i class="ti ti-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="flash flash-error">
                    <i class="ti ti-alert-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            @if(session('info'))
                <div class="flash flash-info">
                    <i class="ti ti-info-circle"></i>
                    {{ session('info') }}
                </div>
            @endif

            @yield('content')

        </main>

        {{-- Footer partial --}}
        @include('components._footer')

    </div>{{-- /.main-wrap --}}

</div>{{-- /.layout --}}

<script>
    // Mobile sidebar toggle
    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    if (toggle && sidebar) {
        toggle.addEventListener('click', () => sidebar.classList.toggle('open'));
        document.addEventListener('click', (e) => {
            if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        });
    }
</script>

@stack('scripts')
</body>
</html>
