@extends('layouts.app')
@section('title', 'Nilai Saya')
@section('page-title', 'Nilai Saya')
@section('content')

<div class="flex items-center justify-between mb-4">
    <div class="bg-white rounded-2xl px-5 py-3 border border-slate-100 shadow-sm">
        <span class="text-sm text-slate-500">Rata-rata Nilai: </span>
        <span class="font-bold text-lg {{ $rataRata >= 60 ? 'text-emerald-600' : 'text-red-600' }}">{{ $rataRata }}</span>
    </div>
    <a href="{{ route('nilai.create') }}"
       class="flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-medium hover:bg-indigo-700 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Input Nilai
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
<!-- Ringkasan per Mata Kuliah -->
@if($nilais->count() > 0)
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 mb-4">
    <h3 class="font-semibold text-slate-800 mb-3">📊 Ringkasan Nilai per Mata Kuliah</h3>
    <div class="grid grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach($nilais->groupBy('mata_kuliah_id') as $mkId => $group)
        @php
            $avg = round($group->avg('nilai'), 1);
            $matkul = $group->first()->mataKuliah->nama_matkul;
            $color = $avg >= 75 ? 'border-emerald-200 bg-emerald-50' : ($avg >= 60 ? 'border-amber-200 bg-amber-50' : 'border-red-200 bg-red-50');
            $textColor = $avg >= 75 ? 'text-emerald-700' : ($avg >= 60 ? 'text-amber-700' : 'text-red-700');
        @endphp
        <div class="border {{ $color }} rounded-xl p-3">
            <p class="text-xs text-slate-500 truncate mb-1">{{ $matkul }}</p>
            <p class="text-2xl font-bold {{ $textColor }}">{{ $avg }}</p>
            <p class="text-xs text-slate-400">{{ $group->count() }} entri nilai</p>
        </div>
        @endforeach
    </div>
</div>
@endif
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
            <tr>
                <th class="px-6 py-3 text-left">#</th>
                <th class="px-6 py-3 text-left">Mata Kuliah</th>
                <th class="px-6 py-3 text-center">Minggu</th>
                <th class="px-6 py-3 text-center">Nilai</th>
                <th class="px-6 py-3 text-center">Status</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($nilais as $n)
            <tr class="hover:bg-slate-50">
                <td class="px-6 py-4 text-slate-400">{{ $nilais->firstItem() + $loop->index }}</td>
                <td class="px-6 py-4 font-medium text-slate-800">{{ $n->mataKuliah->nama_matkul }}</td>
                <td class="px-6 py-4 text-center text-slate-500">Minggu {{ $n->minggu }}</td>
                <td class="px-6 py-4 text-center font-bold text-lg
                    {{ $n->nilai >= 75 ? 'text-emerald-600' : ($n->nilai >= 60 ? 'text-amber-600' : 'text-red-600') }}">
                    {{ $n->nilai }}
                </td>
                <td class="px-6 py-4 text-center">
                    @if($n->nilai >= 75)
                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">Baik</span>
                    @elseif($n->nilai >= 60)
                        <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">Cukup</span>
                    @else
                        <span class="px-2.5 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">Risiko</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('nilai.edit', $n) }}"
                           class="px-3 py-1.5 bg-amber-50 text-amber-600 rounded-lg text-xs font-medium hover:bg-amber-100">Edit</a>
                        <form method="POST" action="{{ route('nilai.destroy', $n) }}"
                              onsubmit="return confirm('Hapus nilai ini?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-medium hover:bg-red-100">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-slate-400">Belum ada data nilai</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($nilais->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $nilais->links() }}</div>
    @endif
</div>
@endsection