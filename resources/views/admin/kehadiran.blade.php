@extends('layouts.app')
@section('title', 'Monitoring Kehadiran')
@section('page-title', 'Monitoring Kehadiran')
@section('content')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-4">
    <form method="GET" class="flex flex-wrap gap-3">
        <select name="mahasiswa_id" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            <option value="">Semua Mahasiswa</option>
            @foreach($mahasiswas as $m)
            <option value="{{ $m->id }}" {{ request('mahasiswa_id') == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>
            @endforeach
        </select>
        <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
        <select name="status" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            <option value="">Semua Status</option>
            @foreach(['hadir','izin','sakit','alpha'] as $s)
            <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-medium">Filter</button>
        <a href="{{ route('admin.kehadiran') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-medium">Reset</a>
    </form>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
            <tr>
                <th class="px-6 py-3 text-left">Mahasiswa</th>
                <th class="px-6 py-3 text-left">Tanggal</th>
                <th class="px-6 py-3 text-center">Status</th>
                <th class="px-6 py-3 text-left">Keterangan</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($kehadirans as $k)
            @php $badge = match($k->status) { 'hadir'=>'bg-emerald-100 text-emerald-700', 'izin'=>'bg-blue-100 text-blue-700', 'sakit'=>'bg-amber-100 text-amber-700', 'alpha'=>'bg-red-100 text-red-700' }; @endphp
            <tr class="hover:bg-slate-50">
                <td class="px-6 py-4 font-medium">{{ $k->mahasiswa->nama }}<br><span class="text-xs text-slate-400 font-mono">{{ $k->mahasiswa->nim }}</span></td>
                <td class="px-6 py-4 text-slate-600">{{ $k->tanggal->format('d M Y') }}</td>
                <td class="px-6 py-4 text-center"><span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ ucfirst($k->status) }}</span></td>
                <td class="px-6 py-4 text-slate-500">{{ $k->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="px-6 py-10 text-center text-slate-400">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($kehadirans->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $kehadirans->links() }}</div>
    @endif
</div>
@endsection