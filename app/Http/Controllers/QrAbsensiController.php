<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Kehadiran;

class QrAbsensiController extends Controller
{
    // Generate token harian otomatis: NIM + tanggal + app key
    public static function generateToken(Mahasiswa $mahasiswa): string
    {
        $raw = $mahasiswa->nim . '-' . today()->format('Y-m-d') . '-' . config('app.key');
        return hash('sha256', $raw);
    }

    // Halaman QR mahasiswa (mahasiswa lihat QR miliknya)
    public function show()
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if (!$mahasiswa) {
            abort(403, 'Data mahasiswa tidak ditemukan.');
        }

        $token      = self::generateToken($mahasiswa);
        $scanUrl    = route('qr.scan', $token);
        $sudahAbsen = Kehadiran::where('mahasiswa_id', $mahasiswa->id)
            ->whereDate('tanggal', today())
            ->exists();

        return view('qr.show', compact('mahasiswa', 'token', 'scanUrl', 'sudahAbsen'));
    }

    // Proses scan QR → catat hadir
    public function scan($token)
    {
        // Cari mahasiswa yang token hariannya cocok
        $mahasiswa = null;
        foreach (Mahasiswa::all() as $m) {
            if (self::generateToken($m) === $token) {
                $mahasiswa = $m;
                break;
            }
        }

        if (!$mahasiswa) {
            return view('qr.result', [
                'status'  => 'invalid',
                'message' => 'QR Code tidak valid atau sudah kadaluarsa.',
            ]);
        }

        // Cek sudah absen hari ini
        $sudahAbsen = Kehadiran::where('mahasiswa_id', $mahasiswa->id)
            ->whereDate('tanggal', today())
            ->exists();

        if ($sudahAbsen) {
            return view('qr.result', [
                'status'    => 'sudah',
                'message'   => 'Anda sudah absen hari ini!',
                'mahasiswa' => $mahasiswa,
            ]);
        }

        // Catat kehadiran
        Kehadiran::create([
            'mahasiswa_id' => $mahasiswa->id,
            'tanggal'      => today(),
            'status'       => 'hadir',
            'keterangan'   => 'Absen via QR Code',
        ]);

        return view('qr.result', [
            'status'    => 'success',
            'message'   => 'Absensi berhasil dicatat!',
            'mahasiswa' => $mahasiswa,
        ]);
    }
}