<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Mahasiswa::with(['user', 'kehadirans', 'nilais']);

        if ($request->filled('search')) {
            $query->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('nim', 'like', "%{$request->search}%");
        }
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }
        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->jurusan);
        }

        $mahasiswas = $query->latest()->paginate(10)->withQueryString();
        return view('mahasiswa.index', compact('mahasiswas'));
    }

    public function create()
    {
        return view('mahasiswa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'nim'      => 'required|string|unique:mahasiswas,nim',
            'jurusan'  => 'required|string',
            'semester' => 'required|integer|between:1,7',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // Buat user account
        $user = User::create([
            'name'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'mahasiswa',
        ]);

        // Buat data mahasiswa
        Mahasiswa::create([
            'user_id'  => $user->id,
            'nama'     => $request->nama,
            'nim'      => $request->nim,
            'jurusan'  => $request->jurusan,
            'semester' => $request->semester,
        ]);

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa & akun login berhasil dibuat!');
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'nim'      => "required|string|unique:mahasiswas,nim,{$mahasiswa->id}",
            'jurusan'  => 'required|string',
            'semester' => 'required|integer|between:1,7',
        ]);

        $mahasiswa->update($request->only('nama', 'nim', 'jurusan', 'semester'));

        // Update nama di user juga
        if ($mahasiswa->user) {
            $mahasiswa->user->update(['name' => $request->nama]);
        }

        return redirect()->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui!');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        // Hapus user juga
        if ($mahasiswa->user) {
            $mahasiswa->user->delete();
        }
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil dihapus!');
    }
    public function show(Mahasiswa $mahasiswa)
{
    $kehadirans = $mahasiswa->kehadirans()->latest('tanggal')->take(10)->get();
    $nilais     = $mahasiswa->nilais()->with('mataKuliah')->get();
    return view('mahasiswa.show', compact('mahasiswa', 'kehadirans', 'nilais'));
}

public function export()
{
    $mahasiswas = Mahasiswa::with(['kehadirans', 'nilais'])->get();

    $headers = [
        'Content-Type'        => 'text/csv',
        'Content-Disposition' => 'attachment; filename="data-mahasiswa-' . date('Y-m-d') . '.csv"',
    ];

    $callback = function () use ($mahasiswas) {
        $file = fopen('php://output', 'w');

        // Header CSV
        fputcsv($file, ['No', 'Nama', 'NIM', 'Jurusan', 'Semester', 'Email', 'Kehadiran (%)', 'Rata-rata Nilai', 'Status']);

        foreach ($mahasiswas as $i => $m) {
            fputcsv($file, [
                $i + 1,
                $m->nama,
                $m->nim,
                $m->jurusan,
                'Semester ' . $m->semester,
                $m->user?->email ?? '-',
                $m->persentaseKehadiran() . '%',
                $m->rataRataNilai(),
                ucfirst($m->statusMonitoring()),
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}