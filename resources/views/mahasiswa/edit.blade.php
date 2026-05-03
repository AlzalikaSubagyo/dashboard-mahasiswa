@extends('layouts.app')
@section('title', 'Edit Mahasiswa')
@section('page-title', 'Edit Mahasiswa')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <form method="POST" action="{{ route('mahasiswa.update', $mahasiswa) }}" class="space-y-5">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama', $mahasiswa->nama) }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm">
                @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">NIM</label>
                <input type="text" name="nim" value="{{ old('nim', $mahasiswa->nim) }}"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm font-mono">
                @error('nim')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Jurusan</label>
                <select name="jurusan" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm">
                    <option value="Teknik Informatika" {{ $mahasiswa->jurusan == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                    <option value="Sistem Informasi" {{ $mahasiswa->jurusan == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Semester</label>
                <select name="semester" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm">
                    @for($i = 1; $i <= 7; $i++)
                    <option value="{{ $i }}" {{ $mahasiswa->semester == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                    class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors">
                    Update Data
                </button>
                <a href="{{ route('mahasiswa.index') }}"
                    class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-200 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection