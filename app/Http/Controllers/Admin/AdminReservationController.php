<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReservationController extends Controller
{
    public function dashboard()
    {
        $pending = DB::table('reservasi')
            ->where('status', 'pending')
            ->count();

        $approved = DB::table('reservasi')
            ->where('status', 'disetujui')
            ->count();

        return view('admin.dashboard', compact('pending', 'approved'));
    }

    public function index()
    {
        $reservasi = DB::table('reservasi')
            ->where('status', 'pending')
            ->orderBy('tanggal', 'asc')
            ->orderBy('jam_mulai', 'asc')
            ->get();

        return view('admin.verifikasi', compact('reservasi'));
    }

    public function approve($id)
    {
        DB::beginTransaction();

        try {
            $reservasi = DB::table('reservasi')->where('id', $id)->first();

            if (!$reservasi) {
                return back()->with('error', 'Data reservasi tidak ditemukan');
            }

            DB::table('reservasi')
                ->where('id', $id)
                ->update([
                    'status' => 'disetujui',
                    'updated_at' => now()
                ]);

            DB::table('jadwal_kelas')->updateOrInsert(
                [
                    'kelas_id'    => $reservasi->kelas_id,
                    'tanggal'     => $reservasi->tanggal,
                    'jam_mulai'   => $reservasi->jam_mulai,
                    'jam_selesai' => $reservasi->jam_selesai,
                ],
                [
                    'status'      => 'penuh',
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]
            );

            DB::commit();
            return back()->with('success', 'Reservasi berhasil disetujui');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan');
        }
    }

    public function reject($id)
    {
        DB::table('reservasi')
            ->where('id', $id)
            ->update([
                'status' => 'ditolak',
                'updated_at' => now()
            ]);

        return back()->with('success', 'Reservasi ditolak');
    }

    public function history()
    {
        $reservasi = DB::table('reservasi')
            ->whereIn('status', ['disetujui', 'ditolak'])
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai', 'desc')
            ->get();

        return view('admin.history', compact('reservasi'));
    }
}