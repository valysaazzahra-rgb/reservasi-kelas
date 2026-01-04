@extends('mahasiswa.layout')

@section('title','Dashboard Mahasiswa')

@section('content')

<div class="mb-4">
    <h1 class="h3 fw-bold mb-1">Dashboard Mahasiswa</h1>
    <p class="subtext mb-0">
        Selamat datang, <span class="fw-semibold">{{ session('nama') }}</span>.
    </p>
</div>

<div class="row g-3">

    {{-- PROFIL --}}
    <div class="col-lg-4">
        <div class="card-clean p-4 h-100">
            <div class="subtext small">Profil Mahasiswa</div>
            <div class="h5 fw-bold mb-0">{{ session('nama') }}</div>
            <div class="subtext mb-3">{{ session('nim') }}</div>

            <hr class="my-3">

            <div class="d-flex justify-content-between">
                <div>
                    <div class="subtext small">Status</div>
                    <div class="fw-semibold">Aktif</div>
                </div>
                <div class="text-end">
                    <div class="subtext small">Peran</div>
                    <div class="fw-semibold">Mahasiswa</div>
                </div>
            </div>
        </div>
    </div>

    {{-- KALENDER --}}
    <div class="col-lg-4">
        <div class="card-clean p-4 h-100 d-flex flex-column">
            <div class="subtext small">Kalender</div>
            <div class="h5 fw-bold mb-2">Jadwal Kelas</div>
            <div class="subtext mb-3">
                Cek ketersediaan ruang & waktu sebelum mengajukan reservasi.
            </div>

            <div class="mt-auto">
                <a href="/mahasiswa/kalender" class="btn btn-outline-primary w-100">
                    Buka Kalender
                </a>
            </div>
        </div>
    </div>

    {{-- RESERVASI --}}
    <div class="col-lg-4">
        <div class="card-clean p-4 h-100 d-flex flex-column">
            <div class="subtext small">Reservasi</div>
            <div class="h5 fw-bold mb-2">Ajukan Peminjaman</div>
            <div class="subtext mb-3">
                Buat permohonan reservasi ruang kelas sesuai kebutuhan.
            </div>

            <div class="mt-auto">
                <a href="/mahasiswa/reservasi" class="btn btn-primary-custom w-100">
                    Ajukan Reservasi
                </a>
            </div>
        </div>
    </div>

</div>

{{-- RINGKASAN RESERVASI --}}
<div class="mt-4">
    <div class="d-flex align-items-end justify-content-between flex-wrap gap-2 mb-2">
        <div>
            <h2 class="h5 fw-bold mb-0">Ringkasan Reservasi</h2>
            <div class="subtext small">Menampilkan 10 reservasi terbaru kamu.</div>
        </div>
        <a href="/mahasiswa/reservasi" class="btn btn-sm btn-outline-secondary">
            Buat Reservasi
        </a>
    </div>

    <div class="card-clean p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Ruang</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th class="text-end">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($reservasiTerbaru as $r)
                        <tr>
                            <td class="fw-semibold">{{ $r->ruang }}</td>
                            <td>{{ $r->tanggal }}</td>
                            <td>{{ $r->jam_mulai }} - {{ $r->jam_selesai }}</td>
                            <td class="text-end">
                                @if($r->status === 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($r->status === 'disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($r->status === 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">{{ $r->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center subtext py-4">
                                Belum ada data reservasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</div>

@endsection