@extends('layouts.admin')

@section('title','Dashboard Admin')

@section('content')

<div class="mb-4">
    <h1 class="h3 fw-bold mb-1">Dashboard Admin</h1>
    <p class="subtext mb-0">Ringkasan data reservasi kelas</p>
</div>

<div class="row g-3">

    <div class="col-lg-6">
        <div class="card-clean p-4 h-100">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="subtext small">Reservasi Pending</div>
                    <div class="display-6 fw-bold mb-0">
                        {{ $pending ?? 0 }}
                    </div>
                    <div class="subtext">Menunggu verifikasi admin</div>
                </div>
                <div class="fs-1">⏳</div>
            </div>
            <div class="mt-3">
                <a href="{{ url('/admin/verifikasi') }}" class="btn btn-outline-primary w-100">
                    Buka Verifikasi
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card-clean p-4 h-100">
            <div class="d-flex align-items-start justify-content-between">
                <div>
                    <div class="subtext small">Reservasi Disetujui</div>
                    <div class="display-6 fw-bold mb-0">
                        {{ $approved ?? 0 }}
                    </div>
                    <div class="subtext">Permohonan yang sudah disetujui</div>
                </div>
                <div class="fs-1">✅</div>
            </div>
            <div class="mt-3">
                <a href="{{ url('/admin/reservasi/history') }}" class="btn btn-primary-custom w-100">
                    Lihat History
                </a>
            </div>
        </div>
    </div>

</div>

{{-- Opsional: ringkasan tabel (boleh kamu hapus kalau belum ada datanya) --}}
@if(isset($latest) && count($latest))
    <div class="mt-4">
        <div class="d-flex align-items-end justify-content-between mb-2">
            <div>
                <h2 class="h5 fw-bold mb-0">Reservasi Terbaru</h2>
                <div class="subtext small">Daftar singkat permohonan terbaru</div>
            </div>
            <a href="{{ url('/admin/verifikasi') }}" class="btn btn-sm btn-outline-secondary">Kelola</a>
        </div>

        <div class="card-clean p-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Mahasiswa</th>
                            <th>Ruang</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latest as $r)
                            <tr>
                                <td>{{ $r->nama ?? '-' }} ({{ $r->nim ?? '-' }})</td>
                                <td>{{ $r->ruang ?? '-' }}</td>
                                <td>{{ $r->tanggal ?? '-' }}</td>
                                <td>{{ ($r->waktu_mulai ?? '-') }} - {{ ($r->waktu_selesai ?? '-') }}</td>
                                <td>
                                    @php $st = strtolower($r->status ?? 'pending'); @endphp
                                    @if($st == 'approved' || $st == 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif($st == 'rejected' || $st == 'ditolak')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

@endsection