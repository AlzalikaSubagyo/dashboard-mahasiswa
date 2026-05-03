@extends('layouts.app')
@section('title', 'Input Nilai')
@section('page-title', 'Input Nilai')
@section('content')
<div class="max-w-lg mx-auto">
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">

    <div class="mb-5 p-4 bg-indigo-50 rounded-xl">
        <p class="text-sm text-indigo-700 font-medium">📚 Semester {{ $mahasiswa->semester }} — {{ $mahasiswa->jurusan }}</p>
        <p class="text-xs text-indigo-500 mt-0.5">Mata kuliah otomatis sesuai semester Anda</p>
    </div>

    <form method="POST" action="{{ route('nilai.store') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Mata Kuliah</label>
            <select name="mata_kuliah_id"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm">
                <option value="">-- Pilih Mata Kuliah --</option>
                @foreach($mataKuliahs as $mk)
                <option value="{{ $mk->id }}" {{ old('mata_kuliah_id') == $mk->id ? 'selected' : '' }}>
                    {{ $mk->nama_matkul }}
                </option>
                @endforeach
            </select>
            @error('mata_kuliah_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Minggu Ke-</label>
                <input type="number" name="minggu" value="{{ old('minggu') }}" min="1" max="16"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm"
                    placeholder="1 - 16">
                @error('minggu')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Nilai (0-100)</label>
                <input type="number" name="nilai" value="{{ old('nilai') }}" min="0" max="100" step="0.01"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm"
                    placeholder="0 - 100">
                @error('nilai')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit"
                class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors">
                Simpan Nilai
            </button>
            <a href="{{ route('nilai.index') }}"
                class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-200 transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
</div>
@endsection