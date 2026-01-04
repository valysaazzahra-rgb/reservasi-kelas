@extends('mahasiswa.layout')

@section('title', 'Kalender Kelas')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
<style>
  .fc .fc-toolbar-title{ font-size: 1.1rem; font-weight: 700; }
  .fc .fc-button{ border-radius: 10px; }
  .fc .fc-scrollgrid{ border-radius: 14px; overflow:hidden; }

  /* biar tabel & filter rapi */
  .table thead th { white-space: nowrap; }
  .table td, .table th { vertical-align: middle; }
</style>
@endpush

@section('content')

@php
    $selectedKelas = request('kelas_id');
@endphp

{{-- ✅ TABLE BOOKING + FILTER --}}
<div class="card-clean p-0 overflow-hidden mb-3">
    <div class="p-3 border-bottom">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h2 class="h6 fw-bold mb-0">Daftar Booking (Kelas Terpakai)</h2>
                <div class="subtext small">
                    Menampilkan jadwal yang sudah dibooking (status <span class="fw-semibold">penuh</span>).
                </div>
            </div>

            <div class="d-flex gap-2 align-items-center flex-wrap">
                {{-- FILTER KELAS --}}
                <form id="formFilter" method="GET" action="/mahasiswa/kalender" class="d-flex gap-2 align-items-center">
                    <select name="kelas_id" id="kelasFilter" class="form-select form-select-sm" style="min-width:220px;">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ (string)$selectedKelas === (string)$k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                        Terapkan
                    </button>
                </form>

                <button id="btnRefreshAll" class="btn btn-sm btn-outline-secondary">
                    Refresh
                </button>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kelas</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th class="text-end">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($booking as $b)
                    <tr>
                        <td class="fw-semibold">{{ $b->nama_kelas }}</td>
                        <td>{{ $b->tanggal }}</td>
                        <td>{{ $b->jam_mulai }} - {{ $b->jam_selesai }}</td>
                        <td class="text-end">
                            <span class="badge bg-danger">Penuh</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center subtext py-4">
                            Belum ada booking yang disetujui.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


{{-- ✅ CALENDAR --}}
<div class="card-clean p-4">
    <div class="d-flex align-items-start justify-content-between flex-wrap gap-2 mb-3">
        <div>
            <h1 class="h5 fw-bold mb-1">Kalender Ketersediaan Kelas</h1>
            <div class="subtext">
                Event otomatis ter-update dari database (booking yang sudah penuh).
            </div>
        </div>

        <button id="btnRefreshCalendar" class="btn btn-sm btn-outline-secondary">
            Refresh Kalender
        </button>
    </div>

    <div id="calendar"></div>
</div>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const calendarEl = document.getElementById('calendar');
    const kelasFilter = document.getElementById('kelasFilter');

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'timeGridWeek',
        height: "auto",
        nowIndicator: true,
        allDaySlot: false,
        slotMinTime: "07:00:00",
        slotMaxTime: "21:00:00",
        firstDay: 1, // Senin

        events: {
            url: '/mahasiswa/kalender/events',
            method: 'GET',

            // ✅ kirim kelas_id ke endpoint events untuk filter
            extraParams: function () {
                return {
                    kelas_id: kelasFilter ? kelasFilter.value : ''
                };
            },

            failure: function () {
                alert('Gagal memuat data kalender. Cek route/controller.');
            }
        },

        eventTimeFormat: {
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
        }
    });

    calendar.render();

    // refresh kalender saja
    document.getElementById('btnRefreshCalendar').addEventListener('click', function(){
        calendar.refetchEvents();
    });

    // refresh semua (tabel+kalender) -> reload halaman
    document.getElementById('btnRefreshAll').addEventListener('click', function(){
        window.location.reload();
    });

    // ✅ optional: kalau dropdown diganti, langsung refresh event kalender (tanpa submit)
    // tabel tetap butuh submit (karena datanya server-side)
    if (kelasFilter) {
        kelasFilter.addEventListener('change', function(){
            calendar.refetchEvents();
        });
    }
});
</script>
@endpush