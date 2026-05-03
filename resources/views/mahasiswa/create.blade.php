@extends('layouts.app')
@section('title', 'Tambah Mahasiswa')
@section('page-title', 'Tambah Mahasiswa')
@section('content')
<div class="max-w-2xl mx-auto">
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
<form method="POST" action="{{ route('mahasiswa.store') }}" class="space-y-5">
    @csrf

    <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama') }}"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm"
                placeholder="Nama lengkap mahasiswa">
            @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">NIM</label>
            <input type="text" name="nim" value="{{ old('nim') }}"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm font-mono"
                placeholder="2023001">
            @error('nim')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Semester</label>
            <select name="semester" id="semester"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm">
                <option value="">-- Pilih --</option>
                @for($i = 1; $i <= 7; $i++)
                <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>Semester {{ $i }}</option>
                @endfor
            </select>
            @error('semester')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Jurusan</label>
            <select name="jurusan" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm">
                <option value="">-- Pilih Jurusan --</option>
                <option value="Teknik Informatika" {{ old('jurusan') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                <option value="Sistem Informasi" {{ old('jurusan') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
            </select>
            @error('jurusan')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div id="matkul-preview" class="hidden bg-slate-50 rounded-xl p-4">
        <p class="text-xs font-semibold text-slate-500 mb-2">📚 Mata Kuliah Semester Ini:</p>
        <div id="matkul-list" class="flex flex-wrap gap-2"></div>
    </div>

    <hr class="border-slate-100">
    <p class="text-sm font-semibold text-slate-700">🔐 Akun Login Mahasiswa</p>

    <div class="grid grid-cols-2 gap-4">
        <div class="col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm"
                placeholder="email@mahasiswa.com">
            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="col-span-2">
            <label class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
            <input type="password" name="password"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm"
                placeholder="Min. 6 karakter">
            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors">
            Simpan Mahasiswa
        </button>
        <a href="{{ route('mahasiswa.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-200 transition-colors">
            Batal
        </a>
    </div>
</form>
</div>
</div>
<script>
const matkulData = @json(\App\Models\MataKuliah::all()->groupBy('semester'));
document.getElementById('semester').addEventListener('change', function() {
    const sem = this.value;
    const preview = document.getElementById('matkul-preview');
    const list = document.getElementById('matkul-list');
    if (!sem || !matkulData[sem]) { preview.classList.add('hidden'); return; }
    list.innerHTML = '';
    matkulData[sem].forEach(mk => {
        const span = document.createElement('span');
        span.className = 'px-2.5 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-xs font-medium';
        span.textContent = mk.nama_matkul;
        list.appendChild(span);
    });
    preview.classList.remove('hidden');
});
</script>
@endsection