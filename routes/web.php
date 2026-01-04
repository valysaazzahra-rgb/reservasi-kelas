<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Mahasiswa\ReservationController;
use App\Http\Controllers\Admin\AdminReservationController;

/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
})->name('landing');

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/
// LOGIN ADMIN
Route::get('/login-admin', [LoginController::class, 'adminForm']);
Route::post('/login-admin', [LoginController::class, 'adminLogin']);

// LOGIN MAHASISWA
Route::get('/login-mahasiswa', [LoginController::class, 'mahasiswaForm']);
Route::post('/login-mahasiswa', [LoginController::class, 'mahasiswaLogin']);

// LOGOUT
Route::get('/logout', [LoginController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| MAHASISWA
|--------------------------------------------------------------------------
*/
Route::middleware('role:mahasiswa')->group(function () {

    Route::get('/mahasiswa/dashboard', [ReservationController::class, 'dashboard']);

    Route::get('/mahasiswa/reservasi', [ReservationController::class, 'create']);
    Route::post('/mahasiswa/reservasi', [ReservationController::class, 'store']);

    Route::get('/mahasiswa/kalender', [ReservationController::class, 'kalender']);
    Route::get('/mahasiswa/kalender/events', [ReservationController::class, 'kalenderEvents']);
});

/*
|--------------------------------------------------------------------------
| ADMIN AKADEMIK
|--------------------------------------------------------------------------
*/
Route::middleware('role:admin')->group(function () {

    Route::get('/admin', [AdminReservationController::class, 'dashboard']);

    Route::get('/admin/verifikasi', [AdminReservationController::class, 'index']);
    Route::post('/admin/reservasi/{id}/approve', [AdminReservationController::class, 'approve']);
    Route::post('/admin/reservasi/{id}/reject', [AdminReservationController::class, 'reject']);

    Route::get('/admin/reservasi/history', [AdminReservationController::class, 'history']);
});