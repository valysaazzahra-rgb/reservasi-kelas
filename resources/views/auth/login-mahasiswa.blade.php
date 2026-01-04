@extends('layouts.auth', [
    'title'   => 'Login Mahasiswa',
    'badge'   => 'Mahasiswa',
    'heading' => 'Login Mahasiswa',
    'desc'    => 'Masuk menggunakan NIM dan tanggal lahir.'
])

@section('content')

    {{-- VALIDATION ERROR --}}
    @if ($errors->any())
        <div class="alert alert-danger py-2 mb-3 small">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- LOGIN ERROR (NIM / tanggal lahir salah) --}}
    @if (session('error'))
        <div class="alert alert-danger py-2 mb-3 small">
            <i class="fas fa-exclamation-circle me-1"></i>
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="/login-mahasiswa" class="d-grid gap-3">
        @csrf

        {{-- NIM --}}
        <div>
            <label class="form-label fw-semibold">NIM</label>
            <input
                type="text"
                name="nim"
                value="{{ old('nim') }}"
                class="form-control"
                placeholder="Masukkan NIM"
                required
            >
        </div>

        {{-- TANGGAL LAHIR --}}
        <div>
            <label class="form-label fw-semibold">Tanggal Lahir</label>
            <input
                type="date"
                name="tanggal_lahir"
                value="{{ old('tanggal_lahir') }}"
                class="form-control"
                required
            >
            <small class="text-muted">
                Format: YYYY-MM-DD
            </small>
        </div>

        <button type="submit" class="btn btn-primary-custom btn-lg mt-2">
            Login
        </button>
    </form>

@endsection