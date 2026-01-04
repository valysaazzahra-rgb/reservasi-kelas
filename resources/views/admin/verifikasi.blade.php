@extends('layouts.admin')

@section('title','Verifikasi Reservasi')

@section('content')

<div class="mb-4">
    <h1 class="h3 fw-bold mb-1">Verifikasi Reservasi</h1>
    <p class="subtext mb-0">Daftar reservasi berstatus <b>pending</b> untuk diverifikasi.</p>
</div>

{{-- Flash message --}}
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card-clean p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Status</th>
                    <th class="text-center" style="width:220px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservasi as $i => $r)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $r->kelas_id ?? '-' }}</td>
                        <td>{{ $r->tanggal ?? '-' }}</td>
                        <td>{{ $r->jam_mulai ?? '-' }} - {{ $r->jam_selesai ?? '-' }}</td>
                        <td>
                            <span class="badge bg-warning text-dark">Pending</span>
                        </td>
                        <td class="text-center">
                            <form action="/admin/reservasi/{{ $r->id }}/approve" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success">
                                    Setujui
                                </button>
                            </form>

                            <form action="/admin/reservasi/{{ $r->id }}/reject" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    Tolak
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center subtext py-4">
                            Tidak ada reservasi pending.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection