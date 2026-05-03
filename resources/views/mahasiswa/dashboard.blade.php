@extends('layouts.app')
@section('title', 'Dashboard Saya')
@section('page-title', 'Dashboard Saya')
@section('content')

@php
$statusColor = 'bg-emerald-50 text-emerald-700 border-emerald-200';
$statusLabel = '✅ Status Aman';

if ($status === 'waspada') {
    $statusColor = 'bg-amber-50 text-amber-700 border-amber-200';
    $statusLabel = '⚠️ Perlu Perhatian';
} elseif ($status === 'risiko') {
    $statusColor = 'bg-red-50 text-red-700 border-red-200';
    $statusLabel = '🚨 Risiko Tinggi';
}
@endphp

<!-- Status Banner -->
<div class="mb-5 px-5 py-4 rounded-2xl border {{ $statusColor }} flex items-center justify-between">
    <div>
        <p class="font-bold text-base">{{ $statusLabel }}</p>
        <p class="text-sm opacity-75 mt-0.5">
            Halo, {{ $mahasiswa->nama }} — Semester {{ $mahasiswa->semester }} | {{ $mahasiswa->jurusan }}
        </p>
    </div>
    <div class="text-right">
        <p class="text-xs opacity-60">NIM</p>
        <p class="font-mono font-bold">{{ $mahasiswa->nim }}</p>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 gap-4 mb-5">
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <p class="text-sm text-slate-500 mb-1">Kehadiran Saya</p>
        <p class="text-3xl font-bold {{ $persentase >= 75 ? 'text-emerald-600' : 'text-red-600' }}">
            {{ $persentase }}%
        </p>
        <div class="mt-2 bg-slate-100 rounded-full h-2">
            <div class="h-2 rounded-full {{ $persentase >= 75 ? 'bg-emerald-500' : 'bg-red-500' }}"
                 style="width: {{ min($persentase, 100) }}%"></div>
        </div>
        <p class="text-xs text-slate-400 mt-1">Min. 75% untuk lulus</p>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <p class="text-sm text-slate-500 mb-1">Rata-rata Nilai</p>
        <p class="text-3xl font-bold {{ $rataRata >= 60 ? 'text-indigo-600' : 'text-red-600' }}">
            {{ $rataRata }}
        </p>
        <div class="mt-2 bg-slate-100 rounded-full h-2">
            <div class="h-2 rounded-full {{ $rataRata >= 60 ? 'bg-indigo-500' : 'bg-red-500' }}"
                 style="width: {{ min($rataRata, 100) }}%"></div>
        </div>
        <p class="text-xs text-slate-400 mt-1">Min. 60 untuk lulus</p>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-2 gap-4 mb-5">
    <a href="{{ route('kehadiran.create') }}"
       class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl p-5 flex items-center gap-3 transition-colors">
        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold">Isi Kehadiran</p>
            <p class="text-xs opacity-75">Catat kehadiran hari ini</p>
        </div>
    </a>

    <a href="{{ route('nilai.create') }}"
       class="bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl p-5 flex items-center gap-3 transition-colors">
        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold">Input Nilai</p>
            <p class="text-xs opacity-75">Tambah nilai mingguan</p>
        </div>
    </a>
</div>

<!-- Tabel -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <p class="font-semibold text-sm text-slate-800">Kehadiran Terakhir</p>
            <a href="{{ route('kehadiran.index') }}" class="text-xs text-indigo-600 hover:underline">Lihat semua</a>
        </div>
        <div class="divide-y divide-slate-50">
            @forelse($kehadirans as $k)
            @php
            $badge = 'bg-slate-100 text-slate-700';
            if ($k->status === 'hadir') $badge = 'bg-emerald-100 text-emerald-700';
            elseif ($k->status === 'izin') $badge = 'bg-blue-100 text-blue-700';
            elseif ($k->status === 'sakit') $badge = 'bg-amber-100 text-amber-700';
            elseif ($k->status === 'alpha') $badge = 'bg-red-100 text-red-700';
            @endphp
            <div class="px-5 py-3 flex items-center justify-between">
                <p class="text-sm text-slate-600">{{ $k->tanggal->format('d M Y') }}</p>
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">
                    {{ ucfirst($k->status) }}
                </span>
            </div>
            @empty
            <p class="px-5 py-6 text-sm text-slate-400 text-center">Belum ada data kehadiran</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <p class="font-semibold text-sm text-slate-800">Nilai Terakhir</p>
            <a href="{{ route('nilai.index') }}" class="text-xs text-indigo-600 hover:underline">Lihat semua</a>
        </div>
        <div class="divide-y divide-slate-50">
            @forelse($nilais as $n)
            <div class="px-5 py-3 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-700">{{ $n->mataKuliah->nama_matkul }}</p>
                    <p class="text-xs text-slate-400">Minggu ke-{{ $n->minggu }}</p>
                </div>
                <span class="font-bold text-sm {{ $n->nilai >= 60 ? 'text-emerald-600' : 'text-red-600' }}">
                    {{ $n->nilai }}
                </span>
            </div>
            @empty
            <p class="px-5 py-6 text-sm text-slate-400 text-center">Belum ada data nilai</p>
            @endforelse
        </div>
    </div>
</div>

@endsection