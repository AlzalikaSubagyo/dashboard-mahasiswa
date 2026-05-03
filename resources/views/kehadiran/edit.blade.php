@extends('layouts.app')
@section('title', 'Edit Kehadiran')
@section('page-title', 'Edit Kehadiran')
@section('content')
<div class="max-w-lg mx-auto">
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
<form method="POST" action="{{ route('kehadiran.update', $kehadiran) }}" class="space-y-5">
    @csrf @method('PUT')
    <p class="text-sm text-slate-500">Tanggal: <strong>{{ $kehadiran->tanggal->format('d F Y') }}</strong></p>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">Status</label>
        <select name="status" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm">
            @foreach(['hadir','izin','sakit','alpha'] as $s)
            <option value="{{ $s }}" {{ $kehadiran->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1.5">Keterangan</label>
        <textarea name="keterangan" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm">{{ old('keterangan', $kehadiran->keterangan) }}</textarea>
    </div>

    <div class="flex gap-3">
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700">Update</button>
        <a href="{{ route('kehadiran.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-semibold">Batal</a>
    </div>
</form>
</div>
</div>
@endsection