<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class AktivitasController extends Controller
{
    public function adminIndex(Request $request)
    {
        $query = Aktivitas::with('mahasiswa');

        if ($request->filled('mahasiswa_id')) {
            $query->where('mahasiswa_id', $request->mahasiswa_id);
        }

        $aktivitas = $query->latest('waktu')->paginate(20)->withQueryString();
        $mahasiswas = Mahasiswa::orderBy('nama')->get();

        return view('admin.aktivitas', compact('aktivitas', 'mahasiswas'));
    }
}