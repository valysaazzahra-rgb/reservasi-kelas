@extends('mahasiswa.layout')

@section('title','Ajukan Reservasi')

@section('content')

<div class="mb-4">
    <h1 class="h3 fw-bold mb-1">Ajukan Reservasi</h1>
    <p class="subtext mb-0">Isi form berikut untuk mengajukan peminjaman ruang kelas.</p>
</div>

{{-- Flash message --}}
@if(session('success'))
    <div class="alert alert-success mb-3">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger mb-3">{{ session('error') }}</div>
@endif

{{-- Validation errors --}}
@if($errors->any())
    <div class="alert alert-danger mb-3">
        <div class="fw-semibold mb-1">Periksa kembali input kamu:</div>
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card-clean p-4">
    <form method="POST" action="/mahasiswa/reservasi" class="row g-3">
        @csrf

        {{-- DROPDOWN KELAS --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Kelas / Ruang</label>
            <select name="kelas" class="form-select" required>
                <option value="">-- Pilih Kelas / Ruang --</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ old('kelas') == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas ?? ('Kelas ID: '.$k->id) }}
                    </option>
                @endforeach
            </select>
            <div class="subtext small mt-1">Pilih ruang/kelas yang ingin dipinjam.</div>
        </div>

        {{-- TANGGAL --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Tanggal</label>
            <input
                id="tanggal"
                type="date"
                name="tanggal"
                value="{{ old('tanggal') }}"
                class="form-control"
                required
                min="{{ date('Y-m-d') }}"
            >
            <div class="subtext small mt-1">Hanya Senin–Jumat dan tidak boleh tanggal lampau.</div>
        </div>

        {{-- JAM --}}
        <div class="col-md-6">
            <label class="form-label fw-semibold">Jam Mulai</label>
            <input
                id="jam_mulai"
                type="time"
                name="jam_mulai"
                value="{{ old('jam_mulai') }}"
                class="form-control"
                required
                min="06:30"
                max="18:00"
            >
            <div class="subtext small mt-1">
                Rentang waktu: 06:30 – 18:00 (minimal durasi 45 menit).
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label fw-semibold">Jam Selesai</label>
            <input
                id="jam_selesai"
                type="time"
                name="jam_selesai"
                value="{{ old('jam_selesai') }}"
                class="form-control"
                required
                min="06:30"
                max="18:00"
            >
        </div>

        {{-- TUJUAN --}}
        <div class="col-12">
            <label class="form-label fw-semibold">Tujuan Peminjaman</label>
            <textarea
                name="tujuan"
                class="form-control"
                rows="3"
                placeholder="Contoh: Praktikum mata kuliah Basis Data"
                required
            >{{ old('tujuan') }}</textarea>
        </div>

        <div class="col-12 d-flex justify-content-end gap-2 mt-3">
            <a href="/mahasiswa/dashboard" class="btn btn-outline-secondary">Batal</a>
            <button type="submit" class="btn btn-primary-custom">Ajukan Reservasi</button>
        </div>
    </form>
</div>

{{-- Frontend guard: blok tanggal lampau, weekend, & helper durasi --}}
<script>
(function(){
    const tanggal   = document.getElementById('tanggal');
    const jamMulai  = document.getElementById('jam_mulai');
    const jamSeles  = document.getElementById('jam_selesai');

    // ===== blok weekend =====
    tanggal?.addEventListener('change', function(){
        const d = new Date(this.value + 'T00:00:00');
        const day = d.getDay(); // 0 = Minggu, 6 = Sabtu

        if(day === 0 || day === 6){
            alert('Reservasi hanya bisa dilakukan pada hari Senin–Jumat.');
            this.value = '';
        }
    });

    // ===== helper durasi minimal 45 menit =====
    function timeToMinutes(t){
        if(!t) return null;
        const [h, m] = t.split(':').map(Number);
        return (h * 60) + m;
    }

    function validateDuration(){
        const start = timeToMinutes(jamMulai?.value);
        const end   = timeToMinutes(jamSeles?.value);
        if(start === null || end === null) return;

        const diff = end - start;

        if(diff < 45){
            jamSeles.setCustomValidity('Durasi minimal 45 menit.');
        } else {
            jamSeles.setCustomValidity('');
        }
    }

    jamMulai?.addEventListener('change', validateDuration);
    jamSeles?.addEventListener('change', validateDuration);
})();
</script>

@endsection