@extends('layouts.app')
@section('title', 'Log Aktivitas')
@section('page-title', 'Log Aktivitas Mahasiswa')
@section('content')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-4">
    <form method="GET" class="flex gap-3">
        <select name="mahasiswa_id" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            <option value="">Semua Mahasiswa</option>
            @foreach($mahasiswas as $m)
            <option value="{{ $m->id }}" {{ request('mahasiswa_id') == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>
            @endforeach
        </select>
        <button class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-medium">Filter</button>
        <a href="{{ route('admin.aktivitas') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-medium">Reset</a>
    </form>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
            <tr>
                <th class="px-6 py-3 text-left">Mahasiswa</th>
                <th class="px-6 py-3 text-left">Aktivitas</th>
                <th class="px-6 py-3 text-left">Waktu</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($aktivitas as $a)
            <tr class="hover:bg-slate-50">
                <td class="px-6 py-4 font-medium">{{ $a->mahasiswa->nama }}<br><span class="text-xs text-slate-400 font-mono">{{ $a->mahasiswa->nim }}</span></td>
                <td class="px-6 py-4 text-slate-600">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-indigo-400 rounded-full"></div>
                        {{ $a->aktivitas }}
                    </div>
                </td>
                <td class="px-6 py-4 text-slate-400 text-xs">{{ $a->waktu->diffForHumans() }}<br>{{ $a->waktu->format('d M Y, H:i') }}</td>
            </tr>
            @empty
            <tr><td colspan="3" class="px-6 py-10 text-center text-slate-400">Belum ada aktivitas</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($aktivitas->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $aktivitas->links() }}</div>
    @endif
</div>
@endsection