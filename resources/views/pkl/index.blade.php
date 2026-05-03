@extends('layouts.app')
@section('title', 'Laporan PKL')
@section('page-title', 'Laporan PKL / Magang')
@section('content')

<div class="mb-4 p-4 bg-indigo-50 border border-indigo-200 rounded-2xl flex items-center justify-between">
    <div>
        <p class="font-semibold text-indigo-800">🎓 PKL / Magang — Semester 7</p>
        <p class="text-sm text-indigo-600 mt-0.5">Total laporan: <strong>{{ $lapora->total() }}</strong> hari</p>
    </div>
    <a href="{{ route('pkl.create') }}"
       class="flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-medium hover:bg-indigo-700 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Laporan
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
            <tr>
                <th class="px-5 py-3 text-left">#</th>
                <th class="px-5 py-3 text-left">Tanggal</th>
                <th class="px-5 py-3 text-left">Kegiatan</th>
                <th class="px-5 py-3 text-center">Status</th>
                <th class="px-5 py-3 text-left">Catatan Pembimbing</th>
                <th class="px-5 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($lapora as $l)
            @php
            $badge = match($l->status_validasi) {
                'disetujui' => 'bg-emerald-100 text-emerald-700',
                'ditolak'   => 'bg-red-100 text-red-700',
                default     => 'bg-amber-100 text-amber-700',
            };
            $label = match($l->status_validasi) {
                'disetujui' => '✓ Disetujui',
                'ditolak'   => '✗ Ditolak',
                default     => '⏳ Pending',
            };
            @endphp
            <tr class="hover:bg-slate-50">
                <td class="px-5 py-4 text-slate-400">{{ $lapora->firstItem() + $loop->index }}</td>
                <td class="px-5 py-4 font-medium text-slate-800">{{ \Carbon\Carbon::parse($l->tanggal)->format('d M Y') }}</td>
                <td class="px-5 py-4 text-slate-600 max-w-xs">
                    <p class="truncate">{{ $l->kegiatan }}</p>
                </td>
                <td class="px-5 py-4 text-center">
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $label }}</span>
                </td>
                <td class="px-5 py-4 text-slate-500 text-xs">{{ $l->catatan_pembimbing ?? '-' }}</td>
                <td class="px-5 py-4">
                    <div class="flex justify-center gap-2">
                        @if($l->status_validasi === 'pending')
                        <a href="{{ route('pkl.edit', $l) }}"
                           class="px-3 py-1.5 bg-amber-50 text-amber-600 rounded-lg text-xs font-medium hover:bg-amber-100">Edit</a>
                        <form method="POST" action="{{ route('pkl.destroy', $l) }}"
                              onsubmit="return confirm('Hapus laporan ini?')">
                            @csrf @method('DELETE')
                            <button class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg text-xs font-medium hover:bg-red-100">Hapus</button>
                        </form>
                        @else
                        <span class="text-xs text-slate-400">Terkunci</span>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-5 py-12 text-center text-slate-400">
                    Belum ada laporan PKL. Mulai tambahkan laporan harian Anda!
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @if($lapora->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">{{ $lapora->links() }}</div>
    @endif
</div>
@endsection