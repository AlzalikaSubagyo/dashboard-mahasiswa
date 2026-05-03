@extends('layouts.app')
@section('title', 'Edit Laporan PKL')
@section('page-title', 'Edit Laporan PKL')
@section('content')
<div class="max-w-2xl mx-auto">
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
<form method="POST" action="{{ route('pkl.update', $pkl) }}" class="space-y-5">
    @csrf @method('PUT')

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal</label>
        <input type="date" name="tanggal" value="{{ old('tanggal', $pkl->tanggal->format('Y-m-d')) }}"
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm">
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">Kegiatan</label>
        <textarea name="kegiatan" rows="6"
            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm resize-none">{{ old('kegiatan', $pkl->kegiatan) }}</textarea>
    </div>

    <div class="flex gap-3">
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700">Update</button>
        <a href="{{ route('pkl.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-semibold">Batal</a>
    </div>
</form>
</div>
</div>
@endsection