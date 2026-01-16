<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'UMKM Nasi Bakar' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --sage: #8b978f;
            --mint: #a8c4c7;
            --ink: #1f1f1f;
            --soft: #f3f5f6;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #87938b;
            color: var(--ink);
            min-height: 100vh;
        }

        main {
            min-height: 100vh;
        }

        .page-shell {
            background: rgba(255, 255, 255, 0.92);
            border-radius: 24px;
            box-shadow: 0 18px 36px rgba(15, 20, 18, 0.18);
        }

        .admin-shell {
            background: #f7f8fa;
            border: 2px solid rgba(30, 40, 36, 0.35);
            box-shadow: 0 12px 24px rgba(15, 20, 18, 0.18);
        }

        .admin-topbar {
            background: #ffffff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        .stat-card {
            border-radius: 10px;
            border-left: 4px solid #2f6e4e;
            box-shadow: 0 6px 12px rgba(15, 20, 18, 0.08);
        }

        .stat-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #e6f2ea;
            color: #2f6e4e;
        }

        .sidebar {
            background: #0b3d1a;
            color: #e6f4ea;
        }

        .sidebar .nav .btn {
            background: transparent;
            color: #e6f4ea;
            border: 0;
            text-align: left;
        }

        .sidebar .nav .btn:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
        }

        .sidebar .nav .btn.active {
            background: #ffffff;
            color: #0b3d1a;
        }

        .sidebar-section {
            font-size: 0.7rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 12px;
        }

        .sidebar-divider {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin: 12px 0;
        }

        .sidebar .btn-logout {
            background: #ffffff;
            color: #0b3d1a;
            border: none;
        }

        .table-shell {
            border-radius: 12px;
            border: 1px solid #dfe3e8;
            box-shadow: 0 8px 16px rgba(15, 20, 18, 0.08);
        }

        .table-shell .card-header {
            background: #f7f8fa;
            border-bottom: 2px solid #2f6e4e;
            font-weight: 600;
        }

        .table-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.85rem;
            color: #6b7280;
            padding: 10px 16px;
            border-bottom: 1px solid #e5e7eb;
            background: #fff;
        }

        .table-shell table thead th {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #6b7280;
            border-bottom: 1px solid #e5e7eb;
        }

        .status-pill {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 999px;
            background: #5b5ce6;
            color: #fff;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .pagination {
            margin: 0;
        }

        .hero-title {
            font-size: clamp(2.5rem, 6vw, 4.5rem);
            font-weight: 800;
            letter-spacing: -0.02em;
        }

        .metric-card {
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-left: 6px solid #2c6e49;
            border-radius: 14px;
            box-shadow: 0 8px 18px rgba(18, 30, 22, 0.08);
        }

        .chart-card {
            border-radius: 24px;
            background: var(--mint);
            color: #0f2d2a;
            min-height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-weight: 600;
            padding: 24px;
        }

        .section-title {
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .login-card {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 18px 32px rgba(20, 24, 22, 0.2);
        }

        .login-side {
            background: linear-gradient(135deg, #2c6e49, #3c7a5b);
            color: #fff;
        }

        .badge-role {
            background: #2c6e49;
        }

        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .auth-page .login-card {
            max-width: 920px;
            width: 100%;
        }

        .nav .btn.active {
            background: #ffffff;
            color: #2c6e49;
            border-color: #ffffff;
        }
    </style>
</head>
<body>
    <main class="container-fluid p-0">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
