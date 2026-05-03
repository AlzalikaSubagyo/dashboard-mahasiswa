@extends('layouts.app')
@section('title', 'Monitoring Nilai')
@section('page-title', 'Monitoring Nilai')
@section('content')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-4">
    <form method="GET" class="flex flex-wrap gap-3">
        <select name="mahasiswa_id" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            <option value="">Semua Mahasiswa</option>
            @foreach($mahasiswas as $m)
            <option value="{{ $m->id }}" {{ request('mahasiswa_id') == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>
            @endforeach
        </select>
        <button class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-medium">Filter</button>
        <a href="{{ route('admin.nilai') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-medium">Reset</a>
    </form>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
            <tr>
                <th class="px-6 py-3 text-left">Mahasiswa</th>
                <th class="px-6 py-3 text-left">Mata Kuliah</th>
                <th class="px-6 py-3 text-center">Minggu</th>
                <th class="px-6 py-3 text-center">Nilai</th>
                <th class="px-6 py-3 text-center">Status</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($nilais as $n)
            <tr class="hover:bg-slate-50">
                <td class="px-6 py-4 font-medium">{{ $n->mahasiswa->nama }}<br><span class="text-xs text-slate-400 font-mono">{{ $n->mahasiswa->nim }}</span></td>
                <td class="px-6 py-4 text-slate-600">{{ $n->mataKuliah->nama_matkul }}</td>
                <td class="px-6 py-4 text-center text-slate-500">{{ $n->minggu }}</td>
                <td class="px-6 py-4 text-center font-bold {{ $n->nilai >= 75 ? 'text-emerald-600' : ($n->nilai >= 60 ? 'text-amber-600' : 'text-red-600') }}">{{ $n->nilai }}</td>
                <td class="px-6 py-4 text-center">
                    @if($n->nilai >= 75) <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">Baik</span>
                    @elseif($n->nilai >= 60) <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">Cukup</span>
                    @else <span class="px-2.5 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Risiko</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-10 text-center text-slate-400">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($nilais->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $nilais->links() }}</div>
    @endif
</div>
@endsection