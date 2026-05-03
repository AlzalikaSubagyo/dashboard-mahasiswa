@extends('layouts.app')
@section('title', 'Tambah Laporan PKL')
@section('page-title', 'Tambah Laporan PKL')
@section('content')
<div class="max-w-2xl mx-auto">
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">

    <div class="mb-5 p-4 bg-indigo-50 rounded-xl">
        <p class="text-sm font-semibold text-indigo-800">📍 {{ $mahasiswa->nama }} — Semester 7 PKL/Magang</p>
        <p class="text-xs text-indigo-500 mt-0.5">Isi laporan harian kegiatan PKL Anda</p>
    </div>

    <form method="POST" action="{{ route('pkl.store') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Kegiatan</label>
            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}"
                max="{{ date('Y-m-d') }}"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm">
            @error('tanggal')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kegiatan Hari Ini</label>
            <textarea name="kegiatan" rows="6"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm resize-none"
                placeholder="Deskripsikan kegiatan PKL yang Anda lakukan hari ini secara detail...">{{ old('kegiatan') }}</textarea>
            @error('kegiatan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors">
                Kirim Laporan
            </button>
            <a href="{{ route('pkl.index') }}"
                class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-200">
                Batal
            </a>
        </div>
    </form>
</div>
</div>
@endsection