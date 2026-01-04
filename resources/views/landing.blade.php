<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Informasi Reservasi Kelas</title>

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

        html { scroll-behavior: smooth; }
        section { scroll-margin-top: 90px; }

        body{
            background: var(--bg);
            color: var(--text);
        }

        /* NAVBAR */
        .navbar-clean{
            background: rgba(255,255,255,.90);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--line);
        }
        .nav-link{
            color: rgba(17,24,39,.80) !important;
            font-weight: 500;
        }
        .nav-link:hover{
            color: rgba(17,24,39,1) !important;
        }

        /* HERO */
        .hero{
            padding: 96px 0 56px;
            background:
                radial-gradient(650px 300px at 82% 15%, rgba(37,99,235,.12), transparent 60%),
                radial-gradient(650px 300px at 10% 20%, rgba(11,58,117,.10), transparent 60%),
                linear-gradient(#ffffff, #f6f7fb);
            border-bottom: 1px solid var(--line);
        }
        .hero-badge{
            display:inline-flex;
            gap:.5rem;
            align-items:center;
            padding: .45rem .75rem;
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
        .hero-title{
            letter-spacing: -0.035em;
            line-height: 1.05;
            font-weight: 800;
        }
        .hero-desc{
            color: var(--muted);
            font-size: 1.1rem;
        }

        /* BUTTON */
        .btn-primary-custom{
            background: linear-gradient(135deg, var(--primary), var(--primary2));
            border: none;
        }
        .btn-primary-custom:hover{
            filter: brightness(.95);
        }

        /* CARDS */
        .card-clean{
            border: 1px solid var(--line);
            border-radius: 16px;
            background: #fff;
            transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
        }
        .card-clean:hover{
            transform: translateY(-4px);
            border-color: rgba(37,99,235,.25);
            box-shadow: 0 14px 35px rgba(17,24,39,.10);
        }

        .section{
            padding: 64px 0;
        }
        .section-title{
            font-weight: 800;
            letter-spacing: -0.02em;
        }
        .subtext{
            color: var(--muted);
        }

        /* SLIDER / CAROUSEL */
        .hero-media{
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid var(--line);
            box-shadow: 0 18px 40px rgba(0,0,0,.10);
            background: #fff;
        }
        .hero-media .carousel-item img{
            width: 100%;
            height: 380px;      /* ubah kalau mau: 320 / 360 / 420 */
            object-fit: cover;  /* biar tidak gepeng */
        }
        .carousel-caption{
            background: rgba(0,0,0,.55);
            border-radius: 12px;
            padding: 10px 14px;
        }
        .carousel-caption h6{
            margin-bottom: 2px;
            font-weight: 600;
        }
        .carousel-caption p{
            margin-bottom: 0;
            font-size: .9rem;
        }

        /* FOOTER */
        footer{
            border-top: 1px solid var(--line);
            background: #fff;
        }
    </style>
</head>

<body>

{{-- NAVBAR --}}
<nav class="navbar navbar-expand-lg navbar-clean fixed-top py-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('landing') }}">
            Reservasi Kelas
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="nav" class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">

                <li class="nav-item dropdown">
                    <a class="btn btn-sm btn-outline-primary dropdown-toggle px-3"
                       href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        Login
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ url('/login-mahasiswa') }}">Login Mahasiswa</a></li>
                        <li><a class="dropdown-item" href="{{ url('/login-admin') }}">Login Admin</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- HERO --}}
<header class="hero">
    <div class="container">
        <div class="row align-items-center g-4 g-lg-5">

            {{-- KIRI: TEXT --}}
            <div class="col-lg-7">
                <div class="hero-badge mb-3">
                    <span class="dot"></span>
                    Sistem Informasi Akademik • Reservasi Ruang Kelas
                </div>

                <h1 class="display-4 hero-title mb-3">
                    Sistem Informasi<br class="d-none d-md-block">
                    Reservasi Ruang Kelas
                </h1>

                <p class="hero-desc mb-4">
                    Kelola peminjaman ruang kelas secara efektif, transparan, dan terjadwal.
                    Mahasiswa dapat mengajukan reservasi, admin memverifikasi permohonan.
                </p>

                <div class="d-flex flex-wrap gap-2">
                    <a href="#fitur" class="btn btn-primary-custom btn-lg px-4">Lihat Fitur</a>
                    <a href="#alur" class="btn btn-outline-dark btn-lg px-4">Cara Kerja</a>
                </div>

                <div class="mt-3 subtext small">
                    *Untuk mengakses dashboard, silakan login sesuai peran.
                </div>
            </div>

            {{-- KANAN: SLIDER --}}
            <div class="col-lg-5">
                <div class="hero-media">
                    <div id="heroCarousel" class="carousel slide"
                         data-bs-ride="carousel"
                         data-bs-interval="3500">

                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
                            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
                        </div>

                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('images/slides/stmi0.jpg') }}" alt="Tampilan Sistem 1">
                                <div class="carousel-caption d-none d-md-block">
                                    <h6>Tampilan Sistem</h6>
                                    <p>Ringkasan fitur reservasi kelas</p>
                                </div>
                            </div>

                            <div class="carousel-item">
                                <img src="{{ asset('images/slides/stmi1.jpg') }}" alt="Tampilan Sistem 2">
                                <div class="carousel-caption d-none d-md-block">
                                    <h6>Kalender & Jadwal</h6>
                                    <p>Cek ketersediaan ruang dan waktu</p>
                                </div>
                            </div>

                            <div class="carousel-item">
                                <img src="{{ asset('images/slides/stmi3.jpg') }}" alt="Tampilan Sistem 3">
                                <div class="carousel-caption d-none d-md-block">
                                    <h6>Verifikasi Admin</h6>
                                    <p>Persetujuan permohonan reservasi</p>
                                </div>
                            </div>
                        </div>

                        <button class="carousel-control-prev" type="button"
                                data-bs-target="#heroCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>

                        <button class="carousel-control-next" type="button"
                                data-bs-target="#heroCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>

                    </div>
                </div>

                <div class="mt-3 d-flex justify-content-between subtext small">
                    <div><strong class="text-dark">Terjadwal</strong><br>Minim bentrok jadwal</div>
                    <div class="text-end"><strong class="text-dark">Transparan</strong><br>Status permohonan jelas</div>
                </div>
            </div>

        </div>
    </div>
</header>

{{-- FITUR --}}
<section id="fitur" class="section">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-title mb-2">Fitur Utama</h2>
            <p class="subtext mb-0">Fitur inti untuk mendukung proses reservasi ruang kelas.</p>
        </div>

        <div class="row g-3 g-lg-4">
            <div class="col-md-4">
                <div class="card card-clean p-4 h-100">
                    <h5 class="fw-bold mb-2">Cek Ketersediaan</h5>
                    <p class="subtext mb-0">
                        Menampilkan jadwal ruang kelas dan slot waktu yang tersedia.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-clean p-4 h-100">
                    <h5 class="fw-bold mb-2">Ajukan Reservasi</h5>
                    <p class="subtext mb-0">
                        Mahasiswa mengajukan peminjaman ruang sesuai kebutuhan dan waktu.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-clean p-4 h-100">
                    <h5 class="fw-bold mb-2">Persetujuan Admin</h5>
                    <p class="subtext mb-0">
                        Admin memverifikasi dan memberikan keputusan terhadap permohonan.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ALUR --}}
<section id="alur" class="section pt-0">
    <div class="container">
        <div class="card card-clean p-4 p-lg-5">
            <h2 class="section-title mb-3">Alur Sistem</h2>
            <ol class="fs-5 subtext mb-0">
                <li class="mb-2">Mahasiswa login → cek jadwal → ajukan reservasi.</li>
                <li class="mb-2">Admin login → verifikasi permohonan → setujui / tolak.</li>
                <li>Mahasiswa memantau status dan riwayat reservasi.</li>
            </ol>
        </div>
    </div>
</section>

<footer class="py-4">
    <div class="container d-flex flex-wrap justify-content-between gap-2 subtext small">
        <div>© {{ date('Y') }} Sistem Informasi Reservasi Kelas</div>
        <div>Dibangun dengan Laravel</div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>