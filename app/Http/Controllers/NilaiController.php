<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Mahasiswa;
use App\Models\MataKuliah;
use App\Models\Aktivitas;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    // Mahasiswa: lihat nilai sendiri
    public function index()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $nilais = Nilai::with('mataKuliah')
            ->where('mahasiswa_id', $mahasiswa->id)
            ->orderBy('minggu')->paginate(15);
        $rataRata = $mahasiswa->rataRataNilai();

        return view('nilai.index', compact('nilais', 'mahasiswa', 'rataRata'));
    }

    public function create()
    {
        $mahasiswa = auth()->user()->mahasiswa;
        $mataKuliahs = MataKuliah::where('semester', $mahasiswa->semester)->get();

        return view('nilai.create', compact('mahasiswa', 'mataKuliahs'));
    }

    public function store(Request $request)
    {
        $mahasiswa = auth()->user()->mahasiswa;

        $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'minggu'         => 'required|integer|min:1|max:16',
            'nilai'          => 'required|numeric|min:0|max:100',
        ]);

        // Cek duplikat matkul + minggu
        $exists = Nilai::where('mahasiswa_id', $mahasiswa->id)
            ->where('mata_kuliah_id', $request->mata_kuliah_id)
            ->where('minggu', $request->minggu)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Nilai untuk mata kuliah dan minggu ini sudah ada!');
        }

        Nilai::create([
            'mahasiswa_id'   => $mahasiswa->id,
            'mata_kuliah_id' => $request->mata_kuliah_id,
            'minggu'         => $request->minggu,
            'nilai'          => $request->nilai,
        ]);

        // Catat aktivitas
        Aktivitas::create([
            'mahasiswa_id' => $mahasiswa->id,
            'aktivitas'    => 'Menginput nilai minggu ke-' . $request->minggu,
            'waktu'        => now(),
        ]);

        return redirect()->route('nilai.index')
            ->with('success', 'Nilai berhasil disimpan!');
    }

    public function edit(Nilai $nilai)
    {
        $mahasiswa = auth()->user()->mahasiswa;
        if ($nilai->mahasiswa_id !== $mahasiswa->id) abort(403);

        $mataKuliahs = MataKuliah::where('semester', $mahasiswa->semester)->get();
        return view('nilai.edit', compact('nilai', 'mataKuliahs'));
    }

    public function update(Request $request, Nilai $nilai)
    {
        $mahasiswa = auth()->user()->mahasiswa;
        if ($nilai->mahasiswa_id !== $mahasiswa->id) abort(403);

        $request->validate([
            'mata_kuliah_id' => 'required|exists:mata_kuliahs,id',
            'minggu'         => 'required|integer|min:1|max:16',
            'nilai'          => 'required|numeric|min:0|max:100',
        ]);

        $nilai->update($request->only('mata_kuliah_id', 'minggu', 'nilai'));

        return redirect()->route('nilai.index')
            ->with('success', 'Nilai berhasil diperbarui!');
    }

    public function destroy(Nilai $nilai)
    {
        $mahasiswa = auth()->user()->mahasiswa;
        if ($nilai->mahasiswa_id !== $mahasiswa->id) abort(403);
        $nilai->delete();
        return redirect()->route('nilai.index')
            ->with('success', 'Nilai dihapus!');
    }

    // Admin: lihat semua nilai
    public function adminIndex(Request $request)
    {
        $query = Nilai::with(['mahasiswa', 'mataKuliah']);

        if ($request->filled('mahasiswa_id')) {
            $query->where('mahasiswa_id', $request->mahasiswa_id);
        }

        $nilais = $query->latest()->paginate(20)->withQueryString();
        $mahasiswas = Mahasiswa::orderBy('nama')->get();

        return view('admin.nilai', compact('nilais', 'mahasiswas'));
    }
}