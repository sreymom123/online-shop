<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Online Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-body:    #f0f0e8;
            --bg-card:    #ffffff;
            --green-dark: #1e3a2b;
            --text-main:  #1a2e1f;
            --text-muted: #7a8c80;
            --border:     #e2e6de;
            --sidebar-w:  200px;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            margin: 0;
        }

        /* ── Topbar ── */
        .topbar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 200;
            height: 52px;
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 20px;
        }
        .topbar-brand {
            font-size: 14px; font-weight: 600;
            color: var(--text-main); text-decoration: none;
        }
        .topbar-right { display: flex; align-items: center; gap: 8px; }
        .tb-icon {
            width: 30px; height: 30px; border-radius: 7px;
            border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-muted); font-size: 13px; cursor: pointer;
            background: transparent; transition: background .15s;
        }
        .tb-icon:hover { background: var(--bg-body); }
        .tb-avatar {
            width: 30px; height: 30px; border-radius: 50%;
            background: var(--green-dark); color: #fff;
            font-size: 11px; font-weight: 600;
            display: flex; align-items: center; justify-content: center;
        }

        /* ── Sidebar ── */
        .sidebar {
            position: fixed; top: 52px; left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--bg-card);
            border-right: 1px solid var(--border);
            padding: 20px 10px;
            display: flex; flex-direction: column;
            z-index: 100; overflow-y: auto;
        }
        .sidebar-label {
            font-size: 9px; font-weight: 600;
            letter-spacing: 1.4px; text-transform: uppercase;
            color: var(--text-muted); padding: 0 10px; margin-bottom: 8px;
        }
        .sidebar .nav-link {
            display: flex; align-items: center; gap: 9px;
            padding: 8px 10px; border-radius: 8px;
            font-size: 13px; font-weight: 500;
            color: var(--text-muted); text-decoration: none;
            transition: background .15s, color .15s;
            margin-bottom: 2px;
        }
        .sidebar .nav-link:hover { background: #eef2ee; color: var(--green-dark); }
        .sidebar .nav-link.active { background: var(--green-dark); color: #fff; }
        .sidebar .nav-link i { font-size: 14px; width: 15px; text-align: center; }

        /* storage widget */
        .storage-box {
            margin-top: auto;
            background: var(--bg-body); border-radius: 10px;
            border: 1px solid var(--border); padding: 11px 12px;
        }
        .storage-box .s-lbl { font-size: 10.5px; font-weight: 600; color: var(--text-main); margin-bottom: 7px; }
        .s-track { height: 4px; border-radius: 99px; background: #d0d5ce; margin-bottom: 5px; }
        .s-fill  { height: 100%; width: 42%; background: #5a8a6a; border-radius: 99px; }
        .storage-box .s-sub { font-size: 10px; color: var(--text-muted); }

        /* ── Main content ── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            margin-top: 52px;
            padding: 28px 28px 60px;
            min-height: calc(100vh - 52px);
        }

        /* alert */
        .alert-success {
            background: #e6f4ec; border: 1px solid #b0d9bc;
            color: var(--green-dark); border-radius: 10px;
            font-size: 13.5px; padding: 10px 14px;
            display: flex; align-items: center; gap: 8px;
            margin-bottom: 22px;
        }

        /* ── Footer ── */
        .admin-footer {
            margin-left: var(--sidebar-w);
            background: var(--bg-card); border-top: 1px solid var(--border);
            padding: 14px 28px;
            display: flex; align-items: center; justify-content: space-between;
            font-size: 11px; color: var(--text-muted);
        }
        .admin-footer .footer-brand { font-size: 13px; font-weight: 700; color: var(--green-dark); }
        .footer-links a { color: var(--text-muted); text-decoration: none; margin-left: 16px; font-size: 11px; }
        .footer-links a:hover { color: var(--green-dark); }

        @media (max-width: 768px) {
            .sidebar { display: none; }
            .main-wrap, .admin-footer { margin-left: 0; }
        }
    </style>
</head>
<body>

<!-- Topbar -->
<nav class="topbar">
    <a class="topbar-brand" href="#">🌿 Admin Panel</a>
    <div class="topbar-right">
        <div class="tb-icon"><i class="bi bi-bell"></i></div>
        <div class="tb-icon"><i class="bi bi-gear"></i></div>
        <div class="tb-avatar">JD</div>
    </div>
</nav>

<!-- Sidebar -->
<nav class="sidebar">
    <div class="sidebar-label">Management</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
               href="{{ route('admin.categories.index') }}">
                <i class="bi bi-grid"></i> Categories
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
               href="{{ route('admin.products.index') }}">
                <i class="bi bi-box"></i> Products
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
               href="{{ route('admin.orders.index') }}">
                <i class="bi bi-cart"></i> Orders
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
               href="{{ route('admin.users.index') }}">
                <i class="bi bi-people"></i> Users
            </a>
        </li>
    </ul>

    <div class="storage-box">
        <div class="s-lbl">Storage Usage</div>
        <div class="s-track"><div class="s-fill"></div></div>
        <div class="s-sub">4.2 GB of 10 GB used</div>
    </div>
</nav>

<!-- Main Content -->
<main class="main-wrap">
    @if(session('success'))
        <div class="alert-success">
            <i class="bi bi-check-circle-fill"></i>
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
</main>

<!-- Footer -->
<footer class="admin-footer">
    <div>
        <span class="footer-brand">Organic Harvest</span>
        &nbsp;· © {{ date('Y') }} Sustaining life, one seed at a time.
    </div>
    <div class="footer-links">
        <a href="#">Sustainability</a>
        <a href="#">Farm Partners</a>
        <a href="#">Support</a>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
