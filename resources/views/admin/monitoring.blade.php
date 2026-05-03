@extends('layouts.app')
@section('title', 'Monitoring Risiko')
@section('page-title', 'Monitoring Risiko Mahasiswa')
@section('content')

<!-- di bagian atas sebelum form filter -->
<div class="flex items-center justify-between mb-4">
    <h2 class="font-bold text-slate-800">Monitoring Risiko Mahasiswa</h2>
    <button onclick="window.print()"
        class="flex items-center gap-2 px-4 py-2.5 bg-slate-700 text-white rounded-xl text-sm font-medium hover:bg-slate-800 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
        </svg>
        Print / Export
    </button>
</div>

<!-- Filter -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-4">
    <form method="GET" class="flex flex-wrap gap-3">
        <select name="semester" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            <option value="">Semua Semester</option>
            @for($i = 1; $i <= 7; $i++)
            <option value="{{ $i }}" {{ request('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
            @endfor
        </select>
        <select name="jurusan" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            <option value="">Semua Jurusan</option>
            <option value="Teknik Informatika" {{ request('jurusan') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
            <option value="Sistem Informasi" {{ request('jurusan') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
        </select>
        <select name="status" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            <option value="">Semua Status</option>
            <option value="aman" {{ request('status') == 'aman' ? 'selected' : '' }}>✅ Aman</option>
            <option value="waspada" {{ request('status') == 'waspada' ? 'selected' : '' }}>⚠️ Waspada</option>
            <option value="risiko" {{ request('status') == 'risiko' ? 'selected' : '' }}>🚨 Risiko Tinggi</option>
        </select>
        <button class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-medium">Filter</button>
        <a href="{{ route('admin.monitoring') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-medium">Reset</a>
    </form>
</div>

<!-- Summary cards -->
<div class="grid grid-cols-3 gap-4 mb-4">
    <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 text-center">
        <p class="text-2xl font-bold text-emerald-700">{{ $mahasiswas->filter(fn($m) => $m->statusMonitoring() === 'aman')->count() }}</p>
        <p class="text-sm text-emerald-600 font-medium">✅ Aman</p>
    </div>
    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-center">
        <p class="text-2xl font-bold text-amber-700">{{ $mahasiswas->filter(fn($m) => $m->statusMonitoring() === 'waspada')->count() }}</p>
        <p class="text-sm text-amber-600 font-medium">⚠️ Waspada</p>
    </div>
    <div class="bg-red-50 border border-red-200 rounded-2xl p-4 text-center">
        <p class="text-2xl font-bold text-red-700">{{ $mahasiswas->filter(fn($m) => $m->statusMonitoring() === 'risiko')->count() }}</p>
        <p class="text-sm text-red-600 font-medium">🚨 Risiko Tinggi</p>
    </div>
</div>

<!-- Tabel -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100">
        <h3 class="font-semibold text-slate-800">Detail Monitoring — {{ $mahasiswas->count() }} mahasiswa</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr>
                    <th class="px-5 py-3 text-left">Mahasiswa</th>
                    <th class="px-5 py-3 text-center">Semester</th>
                    <th class="px-5 py-3 text-center">Kehadiran</th>
                    <th class="px-5 py-3 text-center">Nilai</th>
                    <th class="px-5 py-3 text-center">Total Hadir</th>
                    <th class="px-5 py-3 text-center">Total Nilai</th>
                    <th class="px-5 py-3 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($mahasiswas->sortBy(fn($m) => $m->statusMonitoring()) as $m)
                @php
                    $s = $m->statusMonitoring();
                    $badge = match($s) { 'aman'=>'bg-emerald-100 text-emerald-700', 'waspada'=>'bg-amber-100 text-amber-700', 'risiko'=>'bg-red-100 text-red-700' };
                    $label = match($s) { 'aman'=>'✅ Aman', 'waspada'=>'⚠️ Waspada', 'risiko'=>'🚨 Risiko' };
                @endphp
                <tr class="hover:bg-slate-50 {{ $s === 'risiko' ? 'bg-red-50/30' : '' }}">
                    <td class="px-5 py-4">
                        <p class="font-medium text-slate-800">{{ $m->nama }}</p>
                        <p class="text-xs text-slate-400 font-mono">{{ $m->nim }} · {{ $m->jurusan }}</p>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded-full text-xs font-semibold">Sem. {{ $m->semester }}</span>
                    </td>
                    <td class="px-5 py-4 text-center font-bold {{ $m->persentaseKehadiran() < 75 ? 'text-red-600' : 'text-emerald-600' }}">
                        {{ $m->persentaseKehadiran() }}%
                    </td>
                    <td class="px-5 py-4 text-center font-bold {{ $m->rataRataNilai() < 60 ? 'text-red-600' : 'text-emerald-600' }}">
                        {{ $m->rataRataNilai() }}
                    </td>
                    <td class="px-5 py-4 text-center text-slate-500">
                        {{ $m->kehadirans()->where('status','hadir')->count() }} / {{ $m->kehadirans()->count() }} hari
                    </td>
                    <td class="px-5 py-4 text-center text-slate-500">
                        {{ $m->nilais()->count() }} entri
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $label }}</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-10 text-center text-slate-400">Tidak ada data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection