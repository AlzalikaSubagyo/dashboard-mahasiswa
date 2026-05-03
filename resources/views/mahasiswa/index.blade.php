@extends('layouts.app')
@section('title', 'Data Mahasiswa')
@section('page-title', 'Data Mahasiswa')

@push('styles')
<style>
@media print {
    .no-print { display: none !important; }
    .print-only { display: block !important; }
    body { background: white !important; }
    .sidebar, header { display: none !important; }
    main { padding: 0 !important; }
    .rounded-2xl { border-radius: 0 !important; }
    .shadow-sm { box-shadow: none !important; }
}
.print-only { display: none; }
</style>
@endpush

@section('content')

<!-- Print Header (hanya muncul saat print) -->
<div class="print-only mb-6">
    <h1 class="text-2xl font-bold">Data Mahasiswa</h1>
    <p class="text-sm text-gray-500">Dashboard Monitoring Aktivitas Mahasiswa — Dicetak: {{ now()->format('d F Y, H:i') }}</p>
    <hr class="mt-2">
</div>

<!-- Filter & Search -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-4 no-print">
    <form method="GET" action="{{ route('mahasiswa.index') }}" class="flex flex-wrap gap-3">
        <div class="flex-1 min-w-48 relative">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama atau NIM..."
                class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
        </div>
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
            <option value="risiko" {{ request('status') == 'risiko' ? 'selected' : '' }}>🚨 Risiko</option>
        </select>
        <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-medium hover:bg-indigo-700">🔍 Cari</button>
        <a href="{{ route('mahasiswa.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-medium">Reset</a>
    </form>
</div>

<!-- Table -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
        <div>
            <h2 class="font-semibold text-slate-800">Daftar Mahasiswa</h2>
            <p class="text-xs text-slate-400 mt-0.5">Total: {{ $mahasiswas->total() }} mahasiswa</p>
        </div>
        <div class="flex items-center gap-2 no-print">
            <!-- Export CSV -->
            <a href="{{ route('mahasiswa.export') }}"
               class="flex items-center gap-1.5 px-3 py-2 bg-emerald-50 text-emerald-700 rounded-xl text-xs font-medium hover:bg-emerald-100 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Export CSV
            </a>
            <!-- Print -->
            <button onclick="window.print()"
               class="flex items-center gap-1.5 px-3 py-2 bg-slate-700 text-white rounded-xl text-xs font-medium hover:bg-slate-800 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print
            </button>
            <!-- Tambah -->
            <a href="{{ route('mahasiswa.create') }}"
               class="flex items-center gap-1.5 px-3 py-2 bg-indigo-600 text-white rounded-xl text-xs font-medium hover:bg-indigo-700 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah
            </a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm" id="tabelMahasiswa">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr>
                    <th class="px-5 py-3 text-left">#</th>
                    <th class="px-5 py-3 text-left">Nama</th>
                    <th class="px-5 py-3 text-left">NIM</th>
                    <th class="px-5 py-3 text-left">Jurusan</th>
                    <th class="px-5 py-3 text-center">Semester</th>
                    <th class="px-5 py-3 text-center">Kehadiran</th>
                    <th class="px-5 py-3 text-center">Nilai</th>
                    <th class="px-5 py-3 text-center">Aktif</th>
                    <th class="px-5 py-3 text-center">Status</th>
                    <th class="px-5 py-3 text-center no-print">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($mahasiswas as $m)
                @php
                    $s = $m->statusMonitoring();
                    $badge = match($s) {
                        'aman'    => 'bg-emerald-100 text-emerald-700',
                        'waspada' => 'bg-amber-100 text-amber-700',
                        'risiko'  => 'bg-red-100 text-red-700',
                    };
                    $label = match($s) {
                        'aman'    => 'Aman',
                        'waspada' => 'Waspada',
                        'risiko'  => 'Risiko',
                    };
                    // Cek aktif: ada aktivitas dalam 7 hari terakhir
                    $lastAktivitas = $m->aktivitas()->latest('waktu')->first();
                    $isAktif = $lastAktivitas && $lastAktivitas->waktu->diffInDays(now()) <= 7;
                @endphp
                <tr class="hover:bg-slate-50 transition-colors">
                    <td class="px-5 py-3 text-slate-400 text-xs">{{ $mahasiswas->firstItem() + $loop->index }}</td>
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white text-xs font-bold shrink-0">
                                {{ strtoupper(substr($m->nama, 0, 1)) }}
                            </div>
                            <div>
                                <a href="{{ route('mahasiswa.show', $m) }}" class="font-medium text-slate-800 hover:text-indigo-600 transition-colors">
                                    {{ $m->nama }}
                                </a>
                                <p class="text-xs text-slate-400">{{ $m->user?->email ?? '-' }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-slate-500 font-mono text-xs">{{ $m->nim }}</td>
                    <td class="px-5 py-3 text-slate-600 text-xs">{{ $m->jurusan }}</td>
                    <td class="px-5 py-3 text-center">
                        <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded-full text-xs font-semibold">Sem. {{ $m->semester }}</span>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <div class="flex flex-col items-center gap-1">
                            <span class="font-bold text-sm {{ $m->persentaseKehadiran() < 75 ? 'text-red-600' : 'text-emerald-600' }}">
                                {{ $m->persentaseKehadiran() }}%
                            </span>
                            <div class="w-16 bg-slate-100 rounded-full h-1.5">
                                <div class="h-1.5 rounded-full {{ $m->persentaseKehadiran() < 75 ? 'bg-red-400' : 'bg-emerald-400' }}"
                                     style="width: {{ min($m->persentaseKehadiran(), 100) }}%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-center">
                        <div class="flex flex-col items-center gap-1">
                            <span class="font-bold text-sm {{ $m->rataRataNilai() < 60 ? 'text-red-600' : 'text-emerald-600' }}">
                                {{ $m->rataRataNilai() }}
                            </span>
                            <div class="w-16 bg-slate-100 rounded-full h-1.5">
                                <div class="h-1.5 rounded-full {{ $m->rataRataNilai() < 60 ? 'bg-red-400' : 'bg-indigo-400' }}"
                                     style="width: {{ min($m->rataRataNilai(), 100) }}%"></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-center">
                        @if($isAktif)
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-slate-100 text-slate-500 rounded-full text-xs font-semibold">
                                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>
                                Tidak Aktif
                            </span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-center">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $label }}</span>
                    </td>
                    <td class="px-5 py-3 no-print">
                        <div class="flex items-center justify-center gap-1.5">
                            <a href="{{ route('mahasiswa.show', $m) }}"
                               class="px-2.5 py-1.5 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-medium hover:bg-indigo-100">Detail</a>
                            <a href="{{ route('mahasiswa.edit', $m) }}"
                               class="px-2.5 py-1.5 bg-amber-50 text-amber-600 rounded-lg text-xs font-medium hover:bg-amber-100">Edit</a>
                            <form method="POST" action="{{ route('mahasiswa.destroy', $m) }}"
                                  onsubmit="return confirm('Hapus {{ $m->nama }}?')">
                                @csrf @method('DELETE')
                                <button class="px-2.5 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-medium hover:bg-red-100">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="px-6 py-12 text-center">
                        <svg class="w-12 h-12 text-slate-200 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-slate-400 text-sm">Tidak ada data mahasiswa</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($mahasiswas->hasPages())
    <div class="px-6 py-4 border-t border-slate-100 no-print">{{ $mahasiswas->links() }}</div>
    @endif
</div>

<!-- Statistik Per Semester (bawah tabel) -->
<div class="mt-4 grid grid-cols-2 lg:grid-cols-4 gap-3 no-print">
    @for($i = 1; $i <= 7; $i++)
    @php $count = \App\Models\Mahasiswa::where('semester', $i)->count(); @endphp
    @if($count > 0)
    <div class="bg-white rounded-xl border border-slate-100 shadow-sm p-4 flex items-center justify-between">
        <div>
            <p class="text-xs text-slate-400">Semester {{ $i }}</p>
            <p class="text-2xl font-bold text-slate-800">{{ $count }}</p>
            <p class="text-xs text-slate-400">mahasiswa</p>
        </div>
        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center">
            <span class="font-bold text-indigo-600">{{ $i }}</span>
        </div>
    </div>
    @endif
    @endfor
</div>
@endsection