@extends('layouts.admin')

@section('title','History Reservasi')

@section('content')

<div class="mb-4">
    <h1 class="h3 fw-bold mb-1">History Reservasi</h1>
    <p class="subtext mb-0">Riwayat reservasi yang sudah diproses (disetujui / ditolak).</p>
</div>

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
                            @if(($r->status ?? '') === 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif(($r->status ?? '') === 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-secondary">{{ $r->status }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center subtext py-4">
                            Belum ada data history.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection