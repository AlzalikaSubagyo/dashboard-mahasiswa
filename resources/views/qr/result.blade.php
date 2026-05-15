<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-50 via-white to-purple-50 flex items-center justify-center p-4">
<div class="w-full max-w-sm">
    <div class="bg-white rounded-3xl shadow-xl p-8 text-center border border-slate-100">

        @if($status === 'success')
            <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-5">
                <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 mb-2">Berhasil! 🎉</h1>
            <p class="text-slate-500 mb-4">{{ $message }}</p>
            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 mb-5">
                <p class="text-sm font-semibold text-emerald-700">{{ $mahasiswa->nama }}</p>
                <p class="text-xs text-emerald-600 font-mono">{{ $mahasiswa->nim }}</p>
                <p class="text-xs text-emerald-500 mt-1">{{ now()->format('d M Y, H:i') }} WIB</p>
            </div>

        @elseif($status === 'sudah')
            <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-5">
                <svg class="w-10 h-10 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 mb-2">Info 📋</h1>
            <p class="text-slate-500 mb-4">{{ $message }}</p>
            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 mb-5">
                <p class="text-sm font-semibold text-blue-700">{{ $mahasiswa->nama }}</p>
                <p class="text-xs text-blue-600 font-mono">{{ $mahasiswa->nim }}</p>
                <p class="text-xs text-blue-500 mt-1">Absensi hari ini sudah tercatat</p>
            </div>

        @else
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-5">
                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 mb-2">QR Tidak Valid ❌</h1>
            <p class="text-slate-500 mb-5">{{ $message }}</p>
        @endif

        <p class="text-xs text-slate-300 mt-2">Dashboard Monitoring Mahasiswa</p>
        <p class="text-xs text-slate-300">{{ today()->format('d M Y') }}</p>
    </div>
</div>
</body>
</html>