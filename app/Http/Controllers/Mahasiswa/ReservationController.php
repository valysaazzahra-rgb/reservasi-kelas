<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * DASHBOARD MAHASISWA
     * Menampilkan 10 reservasi terbaru milik mahasiswa yang login
     */
    public function dashboard()
    {
        $nim = session('nim');

        $reservasiTerbaru = DB::table('reservasi')
            ->join('kelas', 'kelas.id', '=', 'reservasi.kelas_id')
            ->where('reservasi.nim', $nim)
            ->select(
                'kelas.nama_kelas as ruang',
                'reservasi.tanggal',
                'reservasi.jam_mulai',
                'reservasi.jam_selesai',
                'reservasi.status',
                'reservasi.created_at'
            )
            ->orderBy('reservasi.created_at', 'desc')
            ->limit(10)
            ->get();

        return view('mahasiswa.dashboard', compact('reservasiTerbaru'));
    }

    /**
     * FORM RESERVASI
     */
    public function create()
    {
        $kelas = DB::table('kelas')->orderBy('nama_kelas', 'asc')->get();
        return view('mahasiswa.reservasi', compact('kelas'));
    }

    /**
     * SIMPAN RESERVASI
     * Aturan:
     * - Tidak boleh tanggal lampau
     * - Tidak boleh Sabtu/Minggu
     * - Jam hanya 06:30 - 18:00
     * - Minimal durasi 45 menit
     * - Cek bentrok jadwal (pending & disetujui)
     */
    public function store(Request $request)
    {
        // ================= VALIDASI FORM =================
        $request->validate([
            'kelas'       => 'required|exists:kelas,id',
            'tanggal'     => 'required|date',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'tujuan'      => 'required|string',
        ]);

        // ================= VALIDASI TANGGAL =================
        $tanggal  = Carbon::parse($request->tanggal)->startOfDay();
        $hariIni  = Carbon::today();

        // ❌ Tidak boleh tanggal lampau
        if ($tanggal->lt($hariIni)) {
            return back()
                ->withInput()
                ->with('error', 'Tidak dapat melakukan reservasi pada tanggal yang sudah berlalu.');
        }

        // ❌ Tidak boleh Sabtu/Minggu
        if ($tanggal->isWeekend()) {
            return back()
                ->withInput()
                ->with('error', 'Reservasi hanya bisa dilakukan pada hari Senin–Jumat.');
        }

        // ================= VALIDASI JAM =================
        $mulai        = Carbon::createFromFormat('H:i', $request->jam_mulai);
        $selesai      = Carbon::createFromFormat('H:i', $request->jam_selesai);
        $batasMulai   = Carbon::createFromFormat('H:i', '06:30');
        $batasSelesai = Carbon::createFromFormat('H:i', '18:00');

        if ($mulai->lt($batasMulai) || $selesai->gt($batasSelesai)) {
            return back()
                ->withInput()
                ->with('error', 'Jam peminjaman hanya diperbolehkan pukul 06:30 – 18:00.');
        }

        // ================= VALIDASI DURASI =================
        $durasiMenit = $mulai->diffInMinutes($selesai);

        if ($durasiMenit < 45) {
            return back()
                ->withInput()
                ->with('error', 'Durasi peminjaman minimal 45 menit.');
        }

        // ================= CEK BENTROK JADWAL =================
        $bentrok = DB::table('reservasi')
            ->where('kelas_id', $request->kelas)
            ->where('tanggal', $request->tanggal)
            ->whereIn('status', ['pending', 'disetujui'])
            ->where(function ($q) use ($request) {
                $q->where('jam_mulai', '<', $request->jam_selesai)
                  ->where('jam_selesai', '>', $request->jam_mulai);
            })
            ->exists();

        if ($bentrok) {
            return back()
                ->withInput()
                ->with('error', 'Jadwal bentrok, kelas sudah digunakan pada jam tersebut.');
        }

        // ================= SIMPAN RESERVASI =================
        DB::table('reservasi')->insert([
            'nim'               => session('nim'),
            'nama_mahasiswa'    => session('nama'),
            'kelas_id'          => $request->kelas,
            'tanggal'           => $request->tanggal,
            'jam_mulai'         => $request->jam_mulai,
            'jam_selesai'       => $request->jam_selesai,
            'tujuan_peminjaman' => $request->tujuan,
            'status'            => 'pending',
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);

        return redirect('/mahasiswa/dashboard')
            ->with('success', 'Reservasi berhasil diajukan dan menunggu verifikasi admin.');
    }

    /**
     * HALAMAN KALENDER
     */
    public function kalender(Request $request)
    {
        $kelas = DB::table('kelas')->orderBy('nama_kelas', 'asc')->get();

        $kelasId = $request->query('kelas_id');

        $bookingQuery = DB::table('jadwal_kelas')
            ->join('kelas', 'kelas.id', '=', 'jadwal_kelas.kelas_id')
            ->select(
                'kelas.id as kelas_id',
                'kelas.nama_kelas',
                'jadwal_kelas.tanggal',
                'jadwal_kelas.jam_mulai',
                'jadwal_kelas.jam_selesai',
                'jadwal_kelas.status'
            )
            ->where('jadwal_kelas.status', 'penuh')
            ->orderBy('jadwal_kelas.tanggal', 'asc')
            ->orderBy('jadwal_kelas.jam_mulai', 'asc');

        if (!empty($kelasId)) {
            $bookingQuery->where('jadwal_kelas.kelas_id', $kelasId);
        }

        $booking = $bookingQuery->limit(20)->get();

        return view('mahasiswa.kalender', compact('kelas', 'booking'));
    }

    /**
     * JSON EVENT KALENDER
     */
    public function kalenderEvents(Request $request)
    {
        $start   = $request->query('start');
        $end     = $request->query('end');
        $kelasId = $request->query('kelas_id');

        $q = DB::table('jadwal_kelas')
            ->join('kelas', 'kelas.id', '=', 'jadwal_kelas.kelas_id')
            ->select(
                'kelas.id as kelas_id',
                'kelas.nama_kelas',
                'jadwal_kelas.tanggal',
                'jadwal_kelas.jam_mulai',
                'jadwal_kelas.jam_selesai',
                'jadwal_kelas.status'
            )
            ->where('jadwal_kelas.status', 'penuh');

        if (!empty($kelasId)) {
            $q->where('jadwal_kelas.kelas_id', $kelasId);
        }

        if ($start && $end) {
            $q->whereBetween('jadwal_kelas.tanggal', [
                substr($start, 0, 10),
                substr($end, 0, 10),
            ]);
        }

        $events = $q->get()->map(function ($j) {
            return [
                'title' => $j->nama_kelas . ' (PENUH)',
                'start' => $j->tanggal . 'T' . $j->jam_mulai,
                'end'   => $j->tanggal . 'T' . $j->jam_selesai,
                'color' => '#dc3545',
            ];
        });

        return response()->json($events);
    }
}