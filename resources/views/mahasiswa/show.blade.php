@extends('layouts.app')
@section('title', 'Detail Mahasiswa')
@section('page-title', 'Detail Mahasiswa')
@section('content')

@php
$s = $mahasiswa->statusMonitoring();
$statusColor = match($s) {
    'aman'    => 'bg-emerald-50 border-emerald-200 text-emerald-700',
    'waspada' => 'bg-amber-50 border-amber-200 text-amber-700',
    'risiko'  => 'bg-red-50 border-red-200 text-red-700',
};
$statusLabel = match($s) {
    'aman'    => '✅ Status Aman',
    'waspada' => '⚠️ Perlu Perhatian',
    'risiko'  => '🚨 Risiko Tinggi',
};
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4">

    <!-- Profile Card -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <div class="text-center mb-5">
            <div class="w-20 h-20 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-3">
                {{ strtoupper(substr($mahasiswa->nama, 0, 1)) }}
            </div>
            <h2 class="font-bold text-slate-800 text-lg">{{ $mahasiswa->nama }}</h2>
            <p class="text-slate-400 text-sm font-mono">{{ $mahasiswa->nim }}</p>
        </div>

        <div class="{{ $statusColor }} border rounded-xl px-4 py-3 text-center mb-4">
            <p class="font-semibold text-sm">{{ $statusLabel }}</p>
        </div>

        <div class="space-y-3">
            <div class="flex justify-between items-center py-2 border-b border-slate-50">
                <span class="text-xs text-slate-400">Jurusan</span>
                <span class="text-xs font-medium text-slate-700">{{ $mahasiswa->jurusan }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-slate-50">
                <span class="text-xs text-slate-400">Semester</span>
                <span class="text-xs font-medium text-slate-700">Semester {{ $mahasiswa->semester }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-slate-50">
                <span class="text-xs text-slate-400">Email</span>
                <span class="text-xs font-medium text-slate-700 truncate">{{ $mahasiswa->user?->email ?? '-' }}</span>
            </div>
            <div class="flex justify-between items-center py-2 border-b border-slate-50">
                <span class="text-xs text-slate-400">Kehadiran</span>
                <span class="text-xs font-bold {{ $mahasiswa->persentaseKehadiran() < 75 ? 'text-red-600' : 'text-emerald-600' }}">
                    {{ $mahasiswa->persentaseKehadiran() }}%
                </span>
            </div>
            <div class="flex justify-between items-center py-2">
                <span class="text-xs text-slate-400">Rata-rata Nilai</span>
                <span class="text-xs font-bold {{ $mahasiswa->rataRataNilai() < 60 ? 'text-red-600' : 'text-emerald-600' }}">
                    {{ $mahasiswa->rataRataNilai() }}
                </span>
            </div>
        </div>

        <div class="mt-5 flex gap-2">
            <a href="{{ route('mahasiswa.edit', $mahasiswa) }}"
               class="flex-1 text-center px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-medium hover:bg-indigo-700 transition-colors">
                Edit
            </a>
            <a href="{{ route('mahasiswa.index') }}"
               class="flex-1 text-center px-4 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-medium hover:bg-slate-200 transition-colors">
                Kembali
            </a>
        </div>
    </div>

    <!-- Kanan -->
    <div class="lg:col-span-2 space-y-4">

        <!-- Line Chart Nilai -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <h3 class="font-semibold text-slate-800 mb-1">📈 Grafik Nilai per Mata Kuliah</h3>
            <p class="text-xs text-slate-400 mb-4">Perkembangan nilai {{ $mahasiswa->nama }}</p>
            @if($nilais->count() > 0)
                <canvas id="chartNilaiDetail" height="130"></canvas>
                <div class="flex items-center gap-4 mt-4 justify-center">
                    <div class="flex items-center gap-1.5">
                        <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                        <span class="text-xs text-slate-500">Baik (≥75)</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                        <span class="text-xs text-slate-500">Cukup (60–74)</span>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <span class="text-xs text-slate-500">Kurang (&lt;60)</span>
                    </div>
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-10 text-slate-300">
                    <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <p class="text-sm">Belum ada data nilai</p>
                </div>
            @endif
        </div>

        <!-- Statistik Kehadiran -->
        <div class="grid grid-cols-4 gap-3">
            @php
                $totalHadir = $mahasiswa->kehadirans()->where('status', 'hadir')->count();
                $totalIzin  = $mahasiswa->kehadirans()->where('status', 'izin')->count();
                $totalSakit = $mahasiswa->kehadirans()->where('status', 'sakit')->count();
                $totalAlpha = $mahasiswa->kehadirans()->where('status', 'alpha')->count();
            @endphp
            <div class="bg-emerald-50 border border-emerald-100 rounded-2xl p-4 text-center">
                <p class="text-2xl font-bold text-emerald-600">{{ $totalHadir }}</p>
                <p class="text-xs text-emerald-500 mt-1">Hadir</p>
            </div>
            <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 text-center">
                <p class="text-2xl font-bold text-blue-600">{{ $totalIzin }}</p>
                <p class="text-xs text-blue-500 mt-1">Izin</p>
            </div>
            <div class="bg-amber-50 border border-amber-100 rounded-2xl p-4 text-center">
                <p class="text-2xl font-bold text-amber-600">{{ $totalSakit }}</p>
                <p class="text-xs text-amber-500 mt-1">Sakit</p>
            </div>
            <div class="bg-red-50 border border-red-100 rounded-2xl p-4 text-center">
                <p class="text-2xl font-bold text-red-600">{{ $totalAlpha }}</p>
                <p class="text-xs text-red-500 mt-1">Alpha</p>
            </div>
        </div>

        <!-- Riwayat Kehadiran -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800">📋 Riwayat Kehadiran</h3>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                    <tr>
                        <th class="px-5 py-3 text-left">Tanggal</th>
                        <th class="px-5 py-3 text-center">Status</th>
                        <th class="px-5 py-3 text-left">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($kehadirans as $k)
                    @php
                    $badge = match($k->status) {
                        'hadir' => 'bg-emerald-100 text-emerald-700',
                        'izin'  => 'bg-blue-100 text-blue-700',
                        'sakit' => 'bg-amber-100 text-amber-700',
                        'alpha' => 'bg-red-100 text-red-700',
                        default => 'bg-slate-100 text-slate-700',
                    };
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 text-slate-600">{{ $k->tanggal->format('d M Y') }}</td>
                        <td class="px-5 py-3 text-center">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ ucfirst($k->status) }}</span>
                        </td>
                        <td class="px-5 py-3 text-slate-400 text-xs">{{ $k->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-5 py-6 text-center text-slate-400">Belum ada data kehadiran</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Daftar Nilai -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800">📚 Daftar Nilai</h3>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                    <tr>
                        <th class="px-5 py-3 text-left">Mata Kuliah</th>
                        <th class="px-5 py-3 text-center">Minggu</th>
                        <th class="px-5 py-3 text-center">Nilai</th>
                        <th class="px-5 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($nilais as $n)
                    @php
                        $nv = $n->nilai;
                        $nc = $nv >= 75 ? 'text-emerald-600' : ($nv >= 60 ? 'text-amber-600' : 'text-red-600');
                        $nl = $nv >= 75 ? 'Baik' : ($nv >= 60 ? 'Cukup' : 'Kurang');
                        $nb = $nv >= 75 ? 'bg-emerald-100 text-emerald-700' : ($nv >= 60 ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700');
                    @endphp
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 font-medium text-slate-700">{{ $n->mataKuliah->nama_matkul ?? '-' }}</td>
                        <td class="px-5 py-3 text-center text-slate-500">Minggu {{ $n->minggu }}</td>
                        <td class="px-5 py-3 text-center font-bold {{ $nc }}">{{ number_format($n->nilai, 1) }}</td>
                        <td class="px-5 py-3 text-center">
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $nb }}">{{ $nl }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-5 py-6 text-center text-slate-400">Belum ada data nilai</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
@if($nilais->count() > 0)
const nilaiData = @json($nilais->map(fn($n) => [
    'label' => ($n->mataKuliah->nama_matkul ?? 'N/A') . ' (Mgg ' . $n->minggu . ')',
    'nilai' => (float) $n->nilai,
])->values());

const pointColors = nilaiData.map(n =>
    n.nilai >= 75 ? 'rgb(16,185,129)' :
    n.nilai >= 60 ? 'rgb(245,158,11)' :
    'rgb(239,68,68)'
);

new Chart(document.getElementById('chartNilaiDetail'), {
    type: 'line',
    data: {
        labels: nilaiData.map(n => n.label),
        datasets: [{
            label: 'Nilai',
            data: nilaiData.map(n => n.nilai),
            borderColor: 'rgb(99,102,241)',
            backgroundColor: 'rgba(99,102,241,0.07)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: pointColors,
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 7,
            pointHoverRadius: 9,
            borderWidth: 2.5,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ' Nilai: ' + ctx.parsed.y
                }
            }
        },
        scales: {
            y: {
                min: 0,
                max: 100,
                grid: { color: '#f1f5f9' },
                ticks: { font: { size: 11 } }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 10 }, maxRotation: 30 }
            }
        }
    }
});
@endif
</script>
@endsection