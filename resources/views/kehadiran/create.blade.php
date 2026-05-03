@extends('layouts.app')
@section('title', 'Isi Kehadiran')
@section('page-title', 'Isi Kehadiran Hari Ini')
@section('content')
<div class="max-w-lg mx-auto">
    @if($sudahAbsen)
    <div class="bg-amber-50 border border-amber-200 text-amber-700 px-5 py-4 rounded-2xl mb-4">
        ⚠️ Anda sudah mengisi kehadiran hari ini!
    </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <p class="text-sm text-slate-500 mb-5">Tanggal: <strong>{{ now()->translatedFormat('d F Y') }}</strong></p>

        <form method="POST" action="{{ route('kehadiran.store') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-3">Status Kehadiran</label>
                <div class="grid grid-cols-2 gap-3">
                    @foreach(['hadir' => ['Hadir','emerald'], 'izin' => ['Izin','blue'], 'sakit' => ['Sakit','amber'], 'alpha' => ['Alpha','red']] as $val => $info)
                    <label class="cursor-pointer">
                        <input type="radio" name="status" value="{{ $val }}" class="sr-only peer" {{ old('status') == $val ? 'checked' : '' }}>
                        <div class="border-2 border-slate-200 rounded-xl p-4 text-center peer-checked:border-{{ $info[1] }}-500 peer-checked:bg-{{ $info[1] }}-50 transition-all">
                            <p class="font-semibold text-slate-700">{{ $info[0] }}</p>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1.5">Keterangan (opsional)</label>
                <textarea name="keterangan" rows="3"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-indigo-300 text-sm"
                    placeholder="Contoh: Sakit demam, ada surat dokter">{{ old('keterangan') }}</textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" {{ $sudahAbsen ? 'disabled' : '' }}
                    class="px-6 py-3 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    Simpan Kehadiran
                </button>
                <a href="{{ route('kehadiran.index') }}" class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl text-sm font-semibold">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection