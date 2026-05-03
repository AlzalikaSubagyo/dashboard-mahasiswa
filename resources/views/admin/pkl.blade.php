@extends('layouts.app')
@section('title', 'Monitoring PKL')
@section('page-title', 'Monitoring Laporan PKL')
@section('content')

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-4 mb-4">
    <form method="GET" class="flex flex-wrap gap-3">
        <select name="mahasiswa_id" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            <option value="">Semua Mahasiswa PKL</option>
            @foreach($mahasiswas as $m)
            <option value="{{ $m->id }}" {{ request('mahasiswa_id') == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>
            @endforeach
        </select>
        <select name="status" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
            <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>✓ Disetujui</option>
            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>✗ Ditolak</option>
        </select>
        <button class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-medium">Filter</button>
        <a href="{{ route('admin.pkl') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl text-sm font-medium">Reset</a>
    </form>
</div>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
            <tr>
                <th class="px-5 py-3 text-left">Mahasiswa</th>
                <th class="px-5 py-3 text-left">Tanggal</th>
                <th class="px-5 py-3 text-left">Kegiatan</th>
                <th class="px-5 py-3 text-center">Status</th>
                <th class="px-5 py-3 text-center">Aksi Validasi</th>
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
                <td class="px-5 py-4">
                    <p class="font-medium text-slate-800">{{ $l->mahasiswa->nama }}</p>
                    <p class="text-xs text-slate-400 font-mono">{{ $l->mahasiswa->nim }}</p>
                </td>
                <td class="px-5 py-4 text-slate-600">{{ \Carbon\Carbon::parse($l->tanggal)->format('d M Y') }}</td>
                <td class="px-5 py-4 text-slate-600 max-w-xs">
                    <p class="text-xs leading-relaxed">{{ Str::limit($l->kegiatan, 100) }}</p>
                </td>
                <td class="px-5 py-4 text-center">
                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $label }}</span>
                </td>
                <td class="px-5 py-4">
                    @if($l->status_validasi === 'pending')
                    <div x-data="{ open: false }" class="relative">
                        <button onclick="document.getElementById('modal-{{ $l->id }}').classList.remove('hidden')"
                            class="w-full px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-medium hover:bg-indigo-100">
                            Validasi
                        </button>
                    </div>
                    @else
                    <p class="text-xs text-slate-400 text-center">{{ $l->catatan_pembimbing ? Str::limit($l->catatan_pembimbing, 40) : 'Sudah divalidasi' }}</p>
                    @endif
                </td>
            </tr>

            {{-- Modal Validasi --}}
            <tr id="modal-{{ $l->id }}" class="hidden bg-indigo-50">
                <td colspan="5" class="px-5 py-4">
                    <form method="POST" action="{{ route('admin.pkl.validasi', $l) }}" class="flex flex-wrap items-end gap-3">
                        @csrf
                        <div>
                            <label class="block text-xs font-medium text-slate-600 mb-1">Keputusan</label>
                            <select name="status_validasi" class="px-3 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300">
                                <option value="disetujui">✓ Setujui</option>
                                <option value="ditolak">✗ Tolak</option>
                            </select>
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-slate-600 mb-1">Catatan Pembimbing</label>
                            <input type="text" name="catatan_pembimbing"
                                class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-300"
                                placeholder="Opsional...">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700">Simpan</button>
                        <button type="button"
                            onclick="document.getElementById('modal-{{ $l->id }}').classList.add('hidden')"
                            class="px-4 py-2 bg-slate-200 text-slate-600 rounded-lg text-sm font-medium">Batal</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-5 py-10 text-center text-slate-400">Belum ada laporan PKL</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($lapora->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">{{ $lapora->links() }}</div>
    @endif
</div>
@endsection