@extends('layouts.auth', [
    'title'   => 'Login Admin',
    'badge'   => 'Admin Akademik',
    'heading' => 'Login Admin',
    'desc'    => 'Masuk menggunakan NIP dan password.'
])

@section('content')

    {{-- VALIDATION ERROR (required, dll) --}}
    @if ($errors->any())
        <div class="alert alert-danger py-2 mb-3 small">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- LOGIN ERROR (NIP / password salah) --}}
    @if (session('error'))
        <div class="alert alert-danger py-2 mb-3 small">
            <i class="fas fa-exclamation-circle me-1"></i>
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="/login-admin" class="d-grid gap-3">
        @csrf

        <div>
            <label class="form-label fw-semibold">NIP</label>
            <input
                type="text"
                name="nip"
                value="{{ old('nip') }}"
                class="form-control"
                placeholder="Masukkan NIP"
                required
            >
        </div>

        <div>
            <label class="form-label fw-semibold">Password</label>
            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Masukkan password"
                required
            >
        </div>

        <button type="submit" class="btn btn-primary-custom btn-lg mt-2">
            Login
        </button>
    </form>

@endsection