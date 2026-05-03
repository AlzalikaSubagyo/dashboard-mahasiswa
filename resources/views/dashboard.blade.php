@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Monitoring')
@section('content')

@if($mahasiswaRisiko > 0)
<div class="mb-5 bg-red-50 border border-red-200 rounded-2xl px-5 py-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-red-800">⚠️ Perhatian! Ada {{ $mahasiswaRisiko }} mahasiswa dengan status Risiko Tinggi</p>
            <p class="text-sm text-red-600 mt-0.5">Segera lakukan tindakan — kehadiran di bawah 75% atau nilai di bawah 60</p>
        </div>
    </div>
    <a href="{{ route('admin.monitoring') }}?status=risiko"
       class="px-4 py-2 bg-red-600 text-white rounded-xl text-sm font-medium hover:bg-red-700 transition-colors shrink-0">
        Lihat Detail
    </a>
</div>
@endif

@if($mahasiswaTidakAktif > 0)
<div class="mb-5 bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="font-semibold text-amber-800">🕐 {{ $mahasiswaTidakAktif }} mahasiswa tidak aktif lebih dari 7 hari</p>
            <p class="text-sm text-amber-600 mt-0.5">Mahasiswa ini belum login atau mengisi data dalam seminggu terakhir</p>
        </div>
    </div>
    <a href="{{ route('admin.aktivitas') }}"
       class="px-4 py-2 bg-amber-600 text-white rounded-xl text-sm font-medium hover:bg-amber-700 transition-colors shrink-0">
        Cek Aktivitas
    </a>
</div>
@endif

<!-- Stats Cards -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Total Mahasiswa</p>
            <div class="w-9 h-9 bg-indigo-50 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $totalMahasiswa }}</p>
        <p class="text-xs text-slate-400 mt-1">Terdaftar di sistem</p>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Rata-rata Nilai</p>
            <div class="w-9 h-9 bg-emerald-50 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ number_format($rataRataNilai, 1) }}</p>
        <p class="text-xs {{ $rataRataNilai >= 60 ? 'text-emerald-500' : 'text-red-500' }} mt-1">
            {{ $rataRataNilai >= 60 ? '✓ Di atas standar' : '✗ Di bawah standar' }}
        </p>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Rata-rata Kehadiran</p>
            <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ number_format($rataKehadiran, 1) }}%</p>
        <p class="text-xs {{ $rataKehadiran >= 75 ? 'text-emerald-500' : 'text-red-500' }} mt-1">
            {{ $rataKehadiran >= 75 ? '✓ Di atas standar' : '✗ Di bawah standar' }}
        </p>
    </div>

    <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs text-slate-500 font-medium uppercase tracking-wide">Mahasiswa Risiko</p>
            <div class="w-9 h-9 bg-red-50 rounded-xl flex items-center justify-center">
                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-slate-800">{{ $mahasiswaRisiko }}</p>
        <p class="text-xs text-slate-400 mt-1">Perlu perhatian segera</p>
    </div>
</div>

<!-- Grafik Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
    <!-- Grafik Nilai -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <h3 class="font-semibold text-slate-800 mb-4">📊 Grafik Rata-rata Nilai per Mahasiswa</h3>
        <canvas id="chartNilai" height="200"></canvas>
    </div>

    <!-- Grafik Kehadiran -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <h3 class="font-semibold text-slate-800 mb-4">📅 Grafik Kehadiran per Mahasiswa</h3>
        <canvas id="chartKehadiran" height="200"></canvas>
    </div>
</div>

<!-- Grafik Distribusi Status -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <h3 class="font-semibold text-slate-800 mb-4">🎯 Distribusi Status Mahasiswa</h3>
        <canvas id="chartStatus" height="220"></canvas>
    </div>

    <!-- Monitoring Risiko -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-semibold text-slate-800">🚨 Daftar Mahasiswa Bermasalah</h3>
            <span class="text-xs bg-red-100 text-red-700 px-2.5 py-1 rounded-full font-semibold">
                {{ $mahasiswaRisiko }} risiko
            </span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                    <tr>
                        <th class="px-5 py-3 text-left">Mahasiswa</th>
                        <th class="px-5 py-3 text-center">Kehadiran</th>
                        <th class="px-5 py-3 text-center">Nilai</th>
                        <th class="px-5 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($mahasiswas->filter(fn($m) => $m->statusMonitoring() !== 'aman')->sortBy(fn($m) => $m->statusMonitoring()) as $m)
                    @php
                        $s = $m->statusMonitoring();
                        $badge = match($s) { 'waspada'=>'bg-amber-100 text-amber-700', 'risiko'=>'bg-red-100 text-red-700', default=>'bg-slate-100 text-slate-700' };
                        $label = match($s) { 'waspada'=>'⚠️ Waspada', 'risiko'=>'🚨 Risiko Tinggi', default=>'Aman' };
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3">
                            <p class="font-medium text-slate-800">{{ $m->nama }}</p>
                            <p class="text-xs text-slate-400 font-mono">{{ $m->nim }} · Sem. {{ $m->semester }}</p>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <span class="{{ $m->persentaseKehadiran() < 75 ? 'text-red-600 font-bold' : 'text-slate-600' }}">
                                {{ $m->persentaseKehadiran() }}%
                            </span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <span class="{{ $m->rataRataNilai() < 60 ? 'text-red-600 font-bold' : 'text-slate-600' }}">
                                {{ $m->rataRataNilai() }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $label }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-5 py-8 text-center text-slate-400">🎉 Semua mahasiswa dalam kondisi baik!</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Status Semua Mahasiswa -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
        <h3 class="font-semibold text-slate-800">📋 Status Semua Mahasiswa</h3>
        <a href="{{ route('mahasiswa.index') }}" class="text-xs text-indigo-600 hover:underline">Kelola mahasiswa →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr>
                    <th class="px-5 py-3 text-left">Nama</th>
                    <th class="px-5 py-3 text-left">NIM</th>
                    <th class="px-5 py-3 text-center">Semester</th>
                    <th class="px-5 py-3 text-center">Kehadiran</th>
                    <th class="px-5 py-3 text-center">Nilai</th>
                    <th class="px-5 py-3 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($mahasiswas as $m)
                @php
                    $s = $m->statusMonitoring();
                    $badge = match($s) { 'aman'=>'bg-emerald-100 text-emerald-700', 'waspada'=>'bg-amber-100 text-amber-700', 'risiko'=>'bg-red-100 text-red-700' };
                    $label = match($s) { 'aman'=>'Aman', 'waspada'=>'Waspada', 'risiko'=>'Risiko' };
                @endphp
                <tr class="hover:bg-slate-50">
                    <td class="px-5 py-3 font-medium text-slate-800">{{ $m->nama }}</td>
                    <td class="px-5 py-3 text-slate-500 font-mono text-xs">{{ $m->nim }}</td>
                    <td class="px-5 py-3 text-center"><span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 rounded-full text-xs font-semibold">Sem. {{ $m->semester }}</span></td>
                    <td class="px-5 py-3 text-center {{ $m->persentaseKehadiran() < 75 ? 'text-red-600 font-bold' : 'text-slate-600' }}">{{ $m->persentaseKehadiran() }}%</td>
                    <td class="px-5 py-3 text-center {{ $m->rataRataNilai() < 60 ? 'text-red-600 font-bold' : 'text-slate-600' }}">{{ $m->rataRataNilai() }}</td>
                    <td class="px-5 py-3 text-center"><span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $label }}</span></td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400">Belum ada data mahasiswa</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
// Data dari Laravel
const namaMahasiswa = @json($mahasiswas->pluck('nama')->map(fn($n) => strlen($n) > 12 ? substr($n, 0, 12).'...' : $n)->values());
const dataNilai     = @json($mahasiswas->map(fn($m) => $m->rataRataNilai())->values());
const dataKehadiran = @json($mahasiswas->map(fn($m) => $m->persentaseKehadiran())->values());
const jumlahAman    = {{ $mahasiswas->filter(fn($m) => $m->statusMonitoring() === 'aman')->count() }};
const jumlahWaspada = {{ $mahasiswas->filter(fn($m) => $m->statusMonitoring() === 'waspada')->count() }};
const jumlahRisiko  = {{ $mahasiswaRisiko }};

// Grafik Nilai
new Chart(document.getElementById('chartNilai'), {
    type: 'bar',
    data: {
        labels: namaMahasiswa,
        datasets: [{
            label: 'Rata-rata Nilai',
            data: dataNilai,
            backgroundColor: dataNilai.map(v => v >= 75 ? 'rgba(16,185,129,0.7)' : v >= 60 ? 'rgba(245,158,11,0.7)' : 'rgba(239,68,68,0.7)'),
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, max: 100, grid: { color: '#f1f5f9' } },
            x: { grid: { display: false } }
        }
    }
});

// Grafik Kehadiran
new Chart(document.getElementById('chartKehadiran'), {
    type: 'bar',
    data: {
        labels: namaMahasiswa,
        datasets: [{
            label: 'Kehadiran (%)',
            data: dataKehadiran,
            backgroundColor: dataKehadiran.map(v => v >= 75 ? 'rgba(99,102,241,0.7)' : 'rgba(239,68,68,0.7)'),
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, max: 100, grid: { color: '#f1f5f9' } },
            x: { grid: { display: false } }
        }
    }
});

// Grafik Donut Status
new Chart(document.getElementById('chartStatus'), {
    type: 'doughnut',
    data: {
        labels: ['Aman', 'Waspada', 'Risiko Tinggi'],
        datasets: [{
            data: [jumlahAman, jumlahWaspada, jumlahRisiko],
            backgroundColor: ['rgba(16,185,129,0.8)', 'rgba(245,158,11,0.8)', 'rgba(239,68,68,0.8)'],
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        cutout: '65%',
        plugins: {
            legend: { position: 'bottom', labels: { padding: 15, font: { size: 12 } } }
        }
    }
});
</script>
@endsection