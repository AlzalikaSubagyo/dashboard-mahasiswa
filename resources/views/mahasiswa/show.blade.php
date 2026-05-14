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

        <!-- QR Absensi -->
        <div class="mt-5 border-t border-slate-100 pt-5">
            <h3 class="font-semibold text-slate-800 text-sm mb-3 text-center">📱 QR Absensi</h3>
            <p class="text-xs text-slate-400 text-center mb-3">Generate QR untuk mahasiswa ini scan dan absen otomatis. Berlaku 5 menit.</p>

            <button onclick="generateQR()" id="btn-generate"
                class="w-full px-4 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-medium hover:bg-emerald-700 transition-colors flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.24M16.24 12l-.01.01M12 12v.01M12 16h.01M8 12H4m4 0v4m0-4V8m0 0H4m4 0h4"/>
                </svg>
                Generate QR Code
            </button>

            <!-- QR Display -->
            <div id="qr-container" class="hidden mt-4">
                <div class="bg-slate-50 rounded-2xl p-4 text-center border border-slate-200">
                    <div id="qr-code" class="flex justify-center mb-3"></div>
                    <p class="text-xs text-slate-500 mb-1">Scan QR ini untuk absen</p>
                    <div id="qr-timer" class="text-sm font-bold text-indigo-600"></div>
                    <p class="text-xs text-red-400 mt-1">QR kadaluarsa dalam 5 menit</p>
                </div>
                <button onclick="generateQR()" class="w-full mt-2 px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-sm font-medium hover:bg-slate-200 transition-colors">
                    🔄 Refresh QR
                </button>
            </div>
        </div>
    </div>

    <!-- Detail Data -->
    <div class="lg:col-span-2 space-y-4">

        <!-- Grafik Nilai Line Chart -->
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
            <h3 class="font-semibold text-slate-800 mb-1">📈 Grafik Nilai per Mata Kuliah</h3>
            <p class="text-xs text-slate-400 mb-4">Perkembangan nilai {{ $mahasiswa->nama }}</p>
            @if($nilais->count() > 0)
                <canvas id="chartNilaiDetail" height="130"></canvas>
            @else
                <div class="flex flex-col items-center justify-center py-10 text-slate-400">
                    <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <p class="text-sm">Belum ada data nilai</p>
                </div>
            @endif
        </div>

        <!-- Statistik Kehadiran -->
        <div class="grid grid-cols-2 gap-4">
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
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($nilais as $n)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-3 font-medium text-slate-700">{{ $n->mataKuliah->nama_matkul ?? '-' }}</td>
                        <td class="px-5 py-3 text-center text-slate-500">Minggu {{ $n->minggu }}</td>
                        <td class="px-5 py-3 text-center">
                            <span class="font-bold {{ $n->nilai < 60 ? 'text-red-600' : ($n->nilai < 75 ? 'text-amber-600' : 'text-emerald-600') }}">
                                {{ $n->nilai }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-5 py-6 text-center text-slate-400">Belum ada data nilai</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- QR JS Library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
// Line Chart Nilai
@if($nilais->count() > 0)
const nilaiData = @json($nilais->map(fn($n) => [
    'matkul' => $n->mataKuliah->nama_matkul ?? 'N/A',
    'nilai'  => $n->nilai,
    'minggu' => $n->minggu,
])->values());

new Chart(document.getElementById('chartNilaiDetail'), {
    type: 'line',
    data: {
        labels: nilaiData.map(n => (n.matkul.length > 15 ? n.matkul.substr(0, 15) + '...' : n.matkul) + ' (Mgg ' + n.minggu + ')'),
        datasets: [{
            label: 'Nilai',
            data: nilaiData.map(n => n.nilai),
            borderColor: 'rgb(99,102,241)',
            backgroundColor: 'rgba(99,102,241,0.08)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: nilaiData.map(n => n.nilai >= 75 ? 'rgb(16,185,129)' : n.nilai >= 60 ? 'rgb(245,158,11)' : 'rgb(239,68,68)'),
            pointRadius: 6,
            pointHoverRadius: 8,
            borderWidth: 2,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => 'Nilai: ' + ctx.parsed.y
                }
            }
        },
        scales: {
            y: {
                beginAtZero: false,
                min: 0,
                max: 100,
                grid: { color: '#f1f5f9' },
                ticks: {
                    callback: val => val
                }
            },
            x: { grid: { display: false }, ticks: { font: { size: 10 } } }
        }
    }
});
@endif

// QR Code Generator
let timerInterval = null;

async function generateQR() {
    const btn = document.getElementById('btn-generate');
    btn.disabled = true;
    btn.innerHTML = '⏳ Generating...';

    try {
        const response = await fetch('{{ route("qr.generate", $mahasiswa) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        const data = await response.json();

        // Tampilkan QR
        document.getElementById('qr-container').classList.remove('hidden');
        document.getElementById('qr-code').innerHTML = '';

        new QRCode(document.getElementById('qr-code'), {
            text: data.scan_url,
            width: 200,
            height: 200,
            colorDark: '#1e1b4b',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.H
        });

        // Timer countdown
        if (timerInterval) clearInterval(timerInterval);
        const expiresAt = new Date(data.expires_at);

        timerInterval = setInterval(() => {
            const now = new Date();
            const diff = Math.max(0, Math.floor((expiresAt - now) / 1000));
            const mnt = Math.floor(diff / 60);
            const det = diff % 60;
            document.getElementById('qr-timer').textContent = `⏱ ${mnt}:${String(det).padStart(2, '0')} tersisa`;

            if (diff <= 0) {
                clearInterval(timerInterval);
                document.getElementById('qr-timer').textContent = '❌ QR Kadaluarsa';
                document.getElementById('qr-timer').className = 'text-sm font-bold text-red-500';
            }
        }, 1000);

        btn.disabled = false;
        btn.innerHTML = '✅ QR Aktif — Generate Ulang';

    } catch (e) {
        btn.disabled = false;
        btn.innerHTML = '⚠️ Gagal, Coba Lagi';
    }
}
</script>
@endsection