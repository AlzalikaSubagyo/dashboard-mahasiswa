@extends('layouts.app')
@section('title', 'QR Absensi Saya')
@section('page-title', 'QR Absensi')
@section('content')

<div class="max-w-md mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 text-center">

        <div class="w-16 h-16 bg-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-md">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.24M16.24 12l-.01.01M12 12v.01M12 16h.01M8 12H4m4 0v4m0-4V8m0 0H4m4 0h4"/>
            </svg>
        </div>

        <h2 class="font-bold text-slate-800 text-xl mb-1">QR Absensi Harian</h2>
        <p class="text-slate-400 text-sm mb-2">{{ $mahasiswa->nama }} — {{ $mahasiswa->nim }}</p>
        <p class="text-xs text-indigo-500 font-medium mb-5">📅 {{ today()->translatedFormat('d F Y') }}</p>

        @if($sudahAbsen)
            <!-- Sudah absen -->
            <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 mb-5">
                <div class="w-14 h-14 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-7 h-7 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <p class="font-semibold text-emerald-700">✅ Sudah Absen Hari Ini!</p>
                <p class="text-xs text-emerald-500 mt-1">QR baru akan tersedia besok</p>
            </div>
        @else
            <!-- QR Code -->
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 mb-5 inline-block w-full">
                <div id="qrcode" class="flex justify-center mb-3"></div>
                <p class="text-xs text-slate-500">Tunjukkan QR ini ke scanner atau scan sendiri</p>
                <p class="text-xs text-amber-500 mt-1 font-medium">⚠️ QR berubah setiap hari</p>
            </div>

            <!-- URL untuk scan manual -->
            <div class="bg-indigo-50 border border-indigo-100 rounded-xl px-4 py-3 mb-5">
                <p class="text-xs text-indigo-500 mb-1">Link scan manual:</p>
                <a href="{{ $scanUrl }}" class="text-xs text-indigo-700 font-medium break-all hover:underline">
                    {{ $scanUrl }}
                </a>
            </div>

            <a href="{{ $scanUrl }}"
               class="block w-full px-4 py-3 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors">
                📲 Tap untuk Absen Sekarang
            </a>
        @endif

        <p class="text-xs text-slate-300 mt-5">QR hanya berlaku untuk {{ today()->translatedFormat('d F Y') }}</p>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
@if(!$sudahAbsen)
<script>
new QRCode(document.getElementById('qrcode'), {
    text: "{{ $scanUrl }}",
    width: 220,
    height: 220,
    colorDark: '#1e1b4b',
    colorLight: '#f8fafc',
    correctLevel: QRCode.CorrectLevel.H
});
</script>
@endif
@endsection