<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // =========================
    // FORM LOGIN ADMIN
    // =========================
    public function adminForm()
    {
        return view('auth.login-admin');
    }

    // =========================
    // PROSES LOGIN ADMIN
    // =========================
    public function adminLogin(Request $request)
    {
        $request->validate([
            'nip' => 'required',
            'password' => 'required'
        ]);

        $admin = DB::table('users')
            ->where('nip', $request->nip)
            ->where('role', 'admin')
            ->first();

        if (!$admin) {
            return back()->with('error', 'NIP tidak terdaftar');
        }

        if (!Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Password salah');
        }

        // SIMPAN SESSION ADMIN
        session([
            'login'   => true,
            'user_id' => $admin->id,
            'nama'    => $admin->name,
            'role'    => 'admin'
        ]);

        return redirect('/admin');
    }

    // =========================
    // FORM LOGIN MAHASISWA
    // =========================
    public function mahasiswaForm()
    {
        return view('auth.login-mahasiswa');
    }

    // =========================
    // PROSES LOGIN MAHASISWA
    // =========================
    public function mahasiswaLogin(Request $request)
    {
        $request->validate([
            'nim'            => 'required',
            'tanggal_lahir'  => 'required|date'
        ]);

        $mahasiswa = DB::table('users')
            ->where('nim', $request->nim)
            ->where('tanggal_lahir', $request->tanggal_lahir)
            ->where('role', 'mahasiswa')
            ->first();

        if (!$mahasiswa) {
            return back()->with('error', 'NIM atau tanggal lahir salah');
        }

        // 🔑 SIMPAN SEMUA DATA YANG DIPERLUKAN RESERVASI
        session([
            'login'   => true,
            'user_id' => $mahasiswa->id,
            'nim'     => $mahasiswa->nim,      // ⚠️ INI YANG TADI KURANG
            'nama'    => $mahasiswa->name,
            'role'    => 'mahasiswa'
        ]);

        return redirect('/mahasiswa/dashboard');
    }

    // =========================
    // LOGOUT
    // =========================
    public function logout()
    {
        session()->flush();
        return redirect('/');
    }
}