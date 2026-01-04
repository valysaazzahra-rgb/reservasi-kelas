<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Login' }} - Reservasi Kelas</title>

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
        body{
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
        }
        .navbar-clean{
            background: rgba(255,255,255,.90);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--line);
        }
        .auth-wrap{
            padding-top: 92px;
            padding-bottom: 40px;
        }
        .auth-card{
            border: 1px solid var(--line);
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 18px 40px rgba(17,24,39,.08);
        }
        .btn-primary-custom{
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            border: none;
        }
        .btn-primary-custom:hover{ filter: brightness(.95); }
        .subtext{ color: var(--muted); }
        .form-control{
            border-radius: 12px;
            border-color: var(--line);
            padding: .7rem .9rem;
        }
        .form-control:focus{
            border-color: rgba(37,99,235,.45);
            box-shadow: 0 0 0 .2rem rgba(37,99,235,.12);
        }
        .auth-side{
            border-left: 1px solid var(--line);
            background:
                radial-gradient(650px 300px at 80% 15%, rgba(37,99,235,.12), transparent 60%),
                radial-gradient(650px 300px at 10% 20%, rgba(11,58,117,.10), transparent 60%),
                linear-gradient(#ffffff, #f6f7fb);
            border-top-right-radius: 18px;
            border-bottom-right-radius: 18px;
        }
        @media (max-width: 991.98px){
            .auth-side{ border-left: 0; border-top: 1px solid var(--line); border-radius: 0 0 18px 18px; }
        }
        .badge-soft{
            display: inline-flex;
            gap: .5rem;
            align-items: center;
            padding: .35rem .65rem;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: rgba(255,255,255,.75);
            color: rgba(17,24,39,.85);
            font-size: .9rem;
        }
        .dot{
            width: 10px; height: 10px;
            border-radius: 999px;
            background: var(--primary2);
            display:inline-block;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-clean fixed-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('landing') }}">Reservasi Kelas</a>
        <div class="ms-auto d-flex gap-2">
            <a class="btn btn-sm btn-outline-secondary" href="{{ route('landing') }}">Kembali</a>
        </div>
    </div>
</nav>

<main class="auth-wrap">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9 col-xl-8">
                <div class="auth-card overflow-hidden">
                    <div class="row g-0">

                        {{-- KIRI: FORM --}}
                        <div class="col-lg-6 p-4 p-lg-5">
                            <div class="mb-3">
                                <span class="badge-soft">
                                    <span class="dot"></span>
                                    {{ $badge ?? 'Akses Sistem' }}
                                </span>
                            </div>

                            <h1 class="h3 fw-bold mb-1">{{ $heading ?? 'Login' }}</h1>
                            <p class="subtext mb-4">{{ $desc ?? 'Silakan masuk untuk melanjutkan.' }}</p>

                            {{-- area form --}}
                            @yield('content')
                        </div>

                        {{-- KANAN: INFO --}}
                        <div class="col-lg-6 auth-side p-4 p-lg-5 d-flex flex-column justify-content-between">
                            <div>
                                <h2 class="h5 fw-bold mb-2">Sistem Informasi Reservasi Ruang Kelas</h2>
                                <p class="subtext mb-4">
                                    Kelola reservasi ruang kelas secara efektif, transparan, dan terjadwal.
                                </p>

                                <ul class="subtext ps-3 mb-0">
                                    <li class="mb-2">Cek ketersediaan ruang & jadwal</li>
                                    <li class="mb-2">Ajukan reservasi (Mahasiswa)</li>
                                    <li>Verifikasi permohonan (Admin)</li>
                                </ul>
                            </div>

                            <div class="subtext small mt-4">
                                © {{ date('Y') }} Reservasi Kelas
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
