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
                <span class="text-xs font-medium text-slate-700">{{ $mahasiswa->user?->email ?? '-' }}</span>
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

    <!-- Detail Data -->
    <div class="lg:col-span-2 space-y-4">

        <!-- Grafik Mini -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <h3 class="font-semibold text-slate-800 mb-4">📊 Progress Nilai</h3>
            <canvas id="chartNilaiDetail" height="120"></canvas>
        </div>

        <!-- Kehadiran Terakhir -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800">Riwayat Kehadiran</h3>
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
    </div>
</div>

<script>
const nilaiData = @json($nilais->map(fn($n) => ['matkul' => $n->mataKuliah->nama_matkul, 'nilai' => $n->nilai])->values());
new Chart(document.getElementById('chartNilaiDetail'), {
    type: 'line',
    data: {
        labels: nilaiData.map(n => n.matkul.length > 15 ? n.matkul.substr(0, 15) + '...' : n.matkul),
        datasets: [{
            label: 'Nilai',
            data: nilaiData.map(n => n.nilai),
            borderColor: 'rgb(99,102,241)',
            backgroundColor: 'rgba(99,102,241,0.1)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: 'rgb(99,102,241)',
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
</script>
@endsection