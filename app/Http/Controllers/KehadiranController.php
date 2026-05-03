<?php

namespace App\Http\Controllers;

use App\Models\Kehadiran;
use App\Models\Mahasiswa;
use App\Models\Aktivitas;
use Illuminate\Http\Request;

class KehadiranController extends Controller
{
    // Mahasiswa: lihat kehadiran sendiri
    public function index()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $kehadirans = Kehadiran::where('mahasiswa_id', $mahasiswa->id)
            ->latest('tanggal')->paginate(15);
        $persentase = $mahasiswa->persentaseKehadiran();

        return view('kehadiran.index', compact('kehadirans', 'mahasiswa', 'persentase'));
    }

    public function create()
    {
        $mahasiswa = auth()->user()->mahasiswa;

        // Cek sudah absen hari ini belum
        $sudahAbsen = Kehadiran::where('mahasiswa_id', $mahasiswa->id)
            ->where('tanggal', today())->exists();

        return view('kehadiran.create', compact('mahasiswa', 'sudahAbsen'));
    }

    public function store(Request $request)
    {
        $mahasiswa = auth()->user()->mahasiswa;

        // Validasi tidak bisa absen 2x sehari
        $sudahAbsen = Kehadiran::where('mahasiswa_id', $mahasiswa->id)
            ->where('tanggal', today())->exists();

        if ($sudahAbsen) {
            return back()->with('error', 'Anda sudah mengisi kehadiran hari ini!');
        }

        $request->validate([
            'status'     => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Kehadiran::create([
            'mahasiswa_id' => $mahasiswa->id,
            'tanggal'      => today(),
            'status'       => $request->status,
            'keterangan'   => $request->keterangan,
        ]);

        // Catat aktivitas
        Aktivitas::create([
            'mahasiswa_id' => $mahasiswa->id,
            'aktivitas'    => 'Mengisi kehadiran: ' . ucfirst($request->status),
            'waktu'        => now(),
        ]);

        return redirect()->route('kehadiran.index')
            ->with('success', 'Kehadiran berhasil dicatat!');
    }

    public function edit(Kehadiran $kehadiran)
    {
        $this->authorize_own($kehadiran);
        return view('kehadiran.edit', compact('kehadiran'));
    }

    public function update(Request $request, Kehadiran $kehadiran)
    {
        $this->authorize_own($kehadiran);

        $request->validate([
            'status'     => 'required|in:hadir,izin,sakit,alpha',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $kehadiran->update($request->only('status', 'keterangan'));

        return redirect()->route('kehadiran.index')
            ->with('success', 'Kehadiran berhasil diperbarui!');
    }

    public function destroy(Kehadiran $kehadiran)
    {
        $this->authorize_own($kehadiran);
        $kehadiran->delete();
        return redirect()->route('kehadiran.index')
            ->with('success', 'Data kehadiran dihapus!');
    }

    // Admin: lihat semua kehadiran
    public function adminIndex(Request $request)
    {
        $query = Kehadiran::with('mahasiswa');

        if ($request->filled('mahasiswa_id')) {
            $query->where('mahasiswa_id', $request->mahasiswa_id);
        }
        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kehadirans = $query->latest('tanggal')->paginate(20)->withQueryString();
        $mahasiswas = Mahasiswa::orderBy('nama')->get();

        return view('admin.kehadiran', compact('kehadirans', 'mahasiswas'));
    }

    private function authorize_own(Kehadiran $kehadiran)
    {
        $mahasiswa = auth()->user()->mahasiswa;
        if ($kehadiran->mahasiswa_id !== $mahasiswa->id) {
            abort(403);
        }
    }
}