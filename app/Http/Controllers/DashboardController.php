<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Aktivitas;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'mahasiswa') {
            $mahasiswa = $user->mahasiswa;
            if (!$mahasiswa) abort(404, 'Data mahasiswa tidak ditemukan.');

            $kehadirans   = $mahasiswa->kehadirans()->latest('tanggal')->take(5)->get();
            $nilais       = $mahasiswa->nilais()->with('mataKuliah')->latest()->take(5)->get();
            $aktivitas    = $mahasiswa->aktivitas()->latest('waktu')->take(5)->get();
            $persentase   = $mahasiswa->persentaseKehadiran();
            $rataRata     = $mahasiswa->rataRataNilai();
            $status       = $mahasiswa->statusMonitoring();
            $totalPkl     = $mahasiswa->semester == 7 ? $mahasiswa->pklLapora()->count() : 0;
            $pklDisetujui = $mahasiswa->semester == 7 ? $mahasiswa->pklLapora()->where('status_validasi', 'disetujui')->count() : 0;

            return view('mahasiswa.dashboard', compact(
                'mahasiswa', 'kehadirans', 'nilais', 'aktivitas',
                'persentase', 'rataRata', 'status', 'totalPkl', 'pklDisetujui'
            ));
        }

        // ADMIN
        $totalMahasiswa   = Mahasiswa::count();
        $mahasiswas       = Mahasiswa::with(['kehadirans', 'nilais'])->get();
        $rataRataNilai    = $mahasiswas->count() > 0 ? $mahasiswas->avg(fn($m) => $m->rataRataNilai()) : 0;
        $rataKehadiran    = $mahasiswas->count() > 0 ? $mahasiswas->avg(fn($m) => $m->persentaseKehadiran()) : 0;
        $mahasiswaRisiko  = $mahasiswas->filter(fn($m) => $m->statusMonitoring() === 'risiko')->count();
        $aktivitasTerbaru = Aktivitas::with('mahasiswa')->latest('waktu')->take(8)->get();

        // Mahasiswa tidak aktif (tidak ada aktivitas dalam 7 hari)
$mahasiswaTidakAktif = $mahasiswas->filter(function($m) {
    $last = $m->aktivitas()->latest('waktu')->first();
    return !$last || $last->waktu->diffInDays(now()) > 7;
})->count();

return view('dashboard', compact(
    'totalMahasiswa', 'rataRataNilai', 'rataKehadiran',
    'mahasiswaRisiko', 'mahasiswaTidakAktif', 'mahasiswas', 'aktivitasTerbaru'
));

        return view('dashboard', compact(
            'totalMahasiswa', 'rataRataNilai', 'rataKehadiran',
            'mahasiswaRisiko', 'mahasiswas', 'aktivitasTerbaru'
        ));
    }

    public function monitoring(Request $request)
    {
        $query = Mahasiswa::with(['kehadirans', 'nilais']);

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->jurusan);
        }

        $mahasiswas = $query->get();

        if ($request->filled('status')) {
            $mahasiswas = $mahasiswas->filter(
                fn($m) => $m->statusMonitoring() === $request->status
            );
        }

        return view('admin.monitoring', compact('mahasiswas'));
    }

    
}