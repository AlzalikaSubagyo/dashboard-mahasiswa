@extends('layouts.app')
@section('title', 'Edit Nilai')
@section('page-title', 'Edit Nilai')
@section('content')
<div class="max-w-lg mx-auto">
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
<form method="POST" action="{{ route('nilai.update', $nilai) }}" class="space-y-5">
    @csrf @method('PUT')

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">Mata Kuliah</label>
        <select name="mata_kuliah_id"
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm">
            @foreach($mataKuliahs as $mk)
            <option value="{{ $mk->id }}" {{ $nilai->mata_kuliah_id == $mk->id ? 'selected' : '' }}>
                {{ $mk->nama_matkul }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Minggu Ke-</label>
            <input type="number" name="minggu" value="{{ old('minggu', $nilai->minggu) }}" min="1" max="16"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nilai</label>
            <input type="number" name="nilai" value="{{ old('nilai', $nilai->nilai) }}" min="0" max="100" step="0.01"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm">
        </div>
    </div>

    <div class="flex gap-3">
        <button type="submit"
            class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors">
            Update Nilai
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