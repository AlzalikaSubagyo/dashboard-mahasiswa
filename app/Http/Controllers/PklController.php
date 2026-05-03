<?php

namespace App\Http\Controllers;

use App\Models\PklLapora;
use App\Models\Mahasiswa;
use App\Models\Aktivitas;
use Illuminate\Http\Request;

class PklController extends Controller
{
    // Mahasiswa: lihat laporan PKL sendiri
    public function index()
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if ($mahasiswa->semester != 7) {
            return redirect()->route('dashboard')
                ->with('error', 'Fitur PKL hanya untuk mahasiswa Semester 7.');
        }

        $lapora = PklLapora::where('mahasiswa_id', $mahasiswa->id)
            ->latest('tanggal')->paginate(15);

        return view('pkl.index', compact('lapora', 'mahasiswa'));
    }

    public function create()
    {
        $mahasiswa = auth()->user()->mahasiswa;

        if ($mahasiswa->semester != 7) {
            return redirect()->route('dashboard')
                ->with('error', 'Fitur PKL hanya untuk mahasiswa Semester 7.');
        }

        return view('pkl.create', compact('mahasiswa'));
    }

    public function store(Request $request)
    {
        $mahasiswa = auth()->user()->mahasiswa;

        $request->validate([
            'tanggal'  => 'required|date',
            'kegiatan' => 'required|string|min:10',
        ]);

        // Cek duplikat tanggal
        $exists = PklLapora::where('mahasiswa_id', $mahasiswa->id)
            ->where('tanggal', $request->tanggal)->exists();

        if ($exists) {
            return back()->with('error', 'Laporan untuk tanggal ini sudah ada!');
        }

        PklLapora::create([
            'mahasiswa_id'   => $mahasiswa->id,
            'tanggal'        => $request->tanggal,
            'kegiatan'       => $request->kegiatan,
            'status_validasi' => 'pending',
        ]);

        Aktivitas::create([
            'mahasiswa_id' => $mahasiswa->id,
            'aktivitas'    => 'Mengisi laporan PKL tanggal ' . $request->tanggal,
            'waktu'        => now(),
        ]);

        return redirect()->route('pkl.index')
            ->with('success', 'Laporan PKL berhasil dikirim!');
    }

    public function edit(PklLapora $pkl)
    {
        $mahasiswa = auth()->user()->mahasiswa;
        if ($pkl->mahasiswa_id !== $mahasiswa->id) abort(403);
        if ($pkl->status_validasi !== 'pending') {
            return back()->with('error', 'Laporan yang sudah divalidasi tidak bisa diedit.');
        }
        return view('pkl.edit', compact('pkl'));
    }

    public function update(Request $request, PklLapora $pkl)
    {
        $mahasiswa = auth()->user()->mahasiswa;
        if ($pkl->mahasiswa_id !== $mahasiswa->id) abort(403);

        $request->validate([
            'tanggal'  => 'required|date',
            'kegiatan' => 'required|string|min:10',
        ]);

        $pkl->update([
            'tanggal'  => $request->tanggal,
            'kegiatan' => $request->kegiatan,
        ]);

        return redirect()->route('pkl.index')
            ->with('success', 'Laporan PKL berhasil diperbarui!');
    }

    public function destroy(PklLapora $pkl)
    {
        $mahasiswa = auth()->user()->mahasiswa;
        if ($pkl->mahasiswa_id !== $mahasiswa->id) abort(403);
        $pkl->delete();
        return redirect()->route('pkl.index')
            ->with('success', 'Laporan dihapus!');
    }

    // Admin: lihat semua laporan PKL
    public function adminIndex(Request $request)
    {
        $query = PklLapora::with('mahasiswa');

        if ($request->filled('mahasiswa_id')) {
            $query->where('mahasiswa_id', $request->mahasiswa_id);
        }
        if ($request->filled('status')) {
            $query->where('status_validasi', $request->status);
        }

        $lapora    = $query->latest('tanggal')->paginate(20)->withQueryString();
        $mahasiswas = Mahasiswa::where('semester', 7)->orderBy('nama')->get();

        return view('admin.pkl', compact('lapora', 'mahasiswas'));
    }

    // Admin: validasi laporan
    public function validasi(Request $request, PklLapora $pkl)
    {
        $request->validate([
            'status_validasi'    => 'required|in:disetujui,ditolak',
            'catatan_pembimbing' => 'nullable|string',
        ]);

        $pkl->update([
            'status_validasi'    => $request->status_validasi,
            'catatan_pembimbing' => $request->catatan_pembimbing,
        ]);

        return back()->with('success', 'Laporan PKL berhasil divalidasi!');
    }
}