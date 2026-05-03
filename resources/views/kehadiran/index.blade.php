@extends('layouts.app')
@section('title', 'Kehadiran Saya')
@section('page-title', 'Kehadiran Saya')
@section('content')

<div class="flex items-center justify-between mb-4">
    <div class="bg-white rounded-2xl px-5 py-3 border border-slate-100 shadow-sm">
        <span class="text-sm text-slate-500">Persentase Kehadiran: </span>
        <span class="font-bold text-lg {{ $persentase >= 75 ? 'text-emerald-600' : 'text-red-600' }}">{{ $persentase }}%</span>
    </div>
    <a href="{{ route('kehadiran.create') }}"
       class="flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-medium hover:bg-indigo-700 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Isi Kehadiran Hari Ini
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
<!-- Kalender Kehadiran Bulan Ini -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 mb-4">
    <h3 class="font-semibold text-slate-800 mb-4">📅 Kalender Kehadiran — {{ now()->translatedFormat('F Y') }}</h3>
    <div class="grid grid-cols-7 gap-1 text-center text-xs">
        @foreach(['Min','Sen','Sel','Rab','Kam','Jum','Sab'] as $h)
        <div class="py-1 font-semibold text-slate-400">{{ $h }}</div>
        @endforeach

        @php
        $startOfMonth = now()->startOfMonth();
        $daysInMonth  = now()->daysInMonth;
        $startDay     = $startOfMonth->dayOfWeek; // 0=minggu

        // Data kehadiran bulan ini
        $kehadiranBulanIni = $kehadirans->filter(
            fn($k) => $k->tanggal->month == now()->month && $k->tanggal->year == now()->year
        )->keyBy(fn($k) => $k->tanggal->day);
        @endphp

        {{-- Padding awal --}}
        @for($i = 0; $i < $startDay; $i++)
        <div></div>
        @endfor

        {{-- Hari-hari --}}
        @for($day = 1; $day <= $daysInMonth; $day++)
        @php
        $k = $kehadiranBulanIni->get($day);
        $isToday = $day == now()->day;
        $bgColor = 'bg-slate-50 text-slate-400';
        if ($k) {
            $bgColor = match($k->status) {
                'hadir' => 'bg-emerald-100 text-emerald-700',
                'izin'  => 'bg-blue-100 text-blue-700',
                'sakit' => 'bg-amber-100 text-amber-700',
                'alpha' => 'bg-red-100 text-red-700',
                default => 'bg-slate-100 text-slate-500',
            };
        }
        if ($isToday) $bgColor .= ' ring-2 ring-indigo-400 ring-offset-1';
        @endphp
        <div class="py-1.5 rounded-lg text-xs font-medium {{ $bgColor }} cursor-default"
             title="{{ $k ? ucfirst($k->status) : 'Belum ada data' }}">
            {{ $day }}
        </div>
        @endfor
    </div>

    <!-- Legend -->
    <div class="flex items-center gap-4 mt-3 justify-center flex-wrap">
        <span class="flex items-center gap-1.5 text-xs text-slate-500"><span class="w-3 h-3 bg-emerald-100 rounded"></span>Hadir</span>
        <span class="flex items-center gap-1.5 text-xs text-slate-500"><span class="w-3 h-3 bg-blue-100 rounded"></span>Izin</span>
        <span class="flex items-center gap-1.5 text-xs text-slate-500"><span class="w-3 h-3 bg-amber-100 rounded"></span>Sakit</span>
        <span class="flex items-center gap-1.5 text-xs text-slate-500"><span class="w-3 h-3 bg-red-100 rounded"></span>Alpha</span>
        <span class="flex items-center gap-1.5 text-xs text-slate-500"><span class="w-3 h-3 bg-slate-50 rounded border"></span>Belum Diisi</span>
    </div>
</div>
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
            <tr>
                <th class="px-6 py-3 text-left">#</th>
                <th class="px-6 py-3 text-left">Tanggal</th>
                <th class="px-6 py-3 text-center">Status</th>
                <th class="px-6 py-3 text-left">Keterangan</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($kehadirans as $k)
            @php $badge = match($k->status) { 'hadir'=>'bg-emerald-100 text-emerald-700', 'izin'=>'bg-blue-100 text-blue-700', 'sakit'=>'bg-amber-100 text-amber-700', 'alpha'=>'bg-red-100 text-red-700' }; @endphp
            <tr class="hover:bg-slate-50">
                <td class="px-6 py-4 text-slate-400">{{ $kehadirans->firstItem() + $loop->index }}</td>
                <td class="px-6 py-4 font-medium">{{ $k->tanggal->format('d F Y') }}</td>
                <td class="px-6 py-4 text-center">
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ ucfirst($k->status) }}</span>
                </td>
                <td class="px-6 py-4 text-slate-500">{{ $k->keterangan ?? '-' }}</td>
                <td class="px-6 py-4">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('kehadiran.edit', $k) }}" class="px-3 py-1.5 bg-amber-50 text-amber-600 rounded-lg text-xs font-medium hover:bg-amber-100">Edit</a>
                        <form method="POST" action="{{ route('kehadiran.destroy', $k) }}" onsubmit="return confirm('Hapus data ini?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-medium hover:bg-red-100">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-10 text-center text-slate-400">Belum ada data kehadiran</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($kehadirans->hasPages())
    <div class="px-6 py-4 border-t border-slate-100">{{ $kehadirans->links() }}</div>
    @endif
</div>
@endsection