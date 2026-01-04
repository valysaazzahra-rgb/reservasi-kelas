<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Admin') - Reservasi Kelas</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root{
            --text:#111827;
            --muted:#6b7280;
            --line:#e5e7eb;
            --bg:#f6f7fb;
            --primary:#0b3a75;
            --primary2:#2563eb;
        }
        body{ background: var(--bg); color: var(--text); }

        .navbar-clean{
            background: rgba(255,255,255,.90);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--line);
        }
        .brand{
            font-weight: 800;
            letter-spacing: -0.02em;
        }
        .subtext{ color: var(--muted); }

        .app{
            display:grid;
            grid-template-columns: 280px 1fr;
            min-height: calc(100vh - 72px);
        }
        .sidebar{
            background:#fff;
            border-right: 1px solid var(--line);
            padding: 18px;
        }
        .content{ padding: 22px; }

        .nav-pill{
            display:flex;
            align-items:center;
            gap:.65rem;
            padding:.65rem .8rem;
            border-radius: 12px;
            color: rgba(17,24,39,.86);
            text-decoration:none;
            border:1px solid transparent;
        }
        .nav-pill:hover{
            background: rgba(37,99,235,.06);
            border-color: rgba(37,99,235,.12);
            color: rgba(17,24,39,1);
        }
        .nav-pill.active{
            background: rgba(37,99,235,.10);
            border-color: rgba(37,99,235,.22);
            color: rgba(17,24,39,1);
            font-weight: 600;
        }

        .card-clean{
            border: 1px solid var(--line);
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 12px 30px rgba(17,24,39,.06);
        }

        .btn-primary-custom{
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            border: none;
            color:#fff;
        }
        .btn-primary-custom:hover{ filter: brightness(.95); color:#fff; }

        @media (max-width: 992px){
            .app{ grid-template-columns: 1fr; }
            .sidebar{ border-right:0; border-bottom:1px solid var(--line); }
        }
    </style>

    @stack('css')
</head>

<body>

<nav class="navbar navbar-clean py-3">
    <div class="container-fluid px-4">
        <a class="navbar-brand brand mb-0" href="{{ url('/admin') }}">Admin Akademik</a>

        <div class="ms-auto d-flex align-items-center gap-2">
            <a href="/logout" class="btn btn-outline-secondary btn-sm"
            onclick="return confirm('Yakin logout?');">
            Logout
            </a>
        </div>
    </div>
</nav>

<div class="app">

    <aside class="sidebar">
        <div class="mb-3">
            <div class="fw-bold">Menu Admin</div>
            <div class="subtext small">Kelola reservasi kelas</div>
        </div>

        @php
            $path = request()->path();
            $active = fn($p) => str_starts_with($path, ltrim($p,'/')) ? 'active' : '';
        @endphp

        <div class="d-grid gap-2">
            <a class="nav-pill {{ $active('admin') }}" href="{{ url('/admin') }}">🏠 Dashboard</a>
            <a class="nav-pill {{ $active('admin/verifikasi') }}" href="{{ url('/admin/verifikasi') }}">✅ Verifikasi Reservasi</a>
            <a class="nav-pill {{ $active('admin/reservasi/history') }}" href="{{ url('/admin/reservasi/history') }}">🕘 History Reservasi</a>
        </div>

        <hr class="my-4">

        <div class="card-clean p-3">
            <div class="fw-semibold">Catatan</div>
            <div class="subtext small mt-1">
                Verifikasi permohonan untuk menghindari bentrok jadwal dan penggunaan ruang.
            </div>
        </div>
    </aside>

    <main class="content">
        @yield('content')
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('js')
</body>
</html>