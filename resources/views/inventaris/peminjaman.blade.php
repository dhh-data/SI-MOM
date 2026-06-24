@extends('layouts.app')
@section('title', 'Pengajuan Peminjaman')
@section('page-title', 'Inventaris & Peminjaman')
@section('breadcrumb', 'Inventaris / Pengajuan Peminjaman')

@section('content')
<div class="space-y-5">
    {{-- Sub Nav --}}
    <div class="flex flex-wrap gap-2 items-center justify-between">
        <div class="flex gap-2">
            <a href="{{ route('inventaris.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-white text-slate-600 border border-slate-200 hover:bg-slate-50">Data Inventaris</a>
            <a href="{{ route('inventaris.peminjaman') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-blue-600 text-white shadow-sm">Pengajuan Peminjaman</a>
        </div>
        @if(Auth::user()->canAjukanPeminjaman())
        <a href="{{ route('inventaris.ajukan') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Ajukan Peminjaman
        </a>
        @endif
    </div>

    {{-- Filter --}}
    <div class="flex gap-2">
        @foreach(['' => 'Semua', 'Pending' => 'Pending', 'Approved' => 'Approved', 'Rejected' => 'Rejected'] as $val => $label)
        <a href="{{ route('inventaris.peminjaman', array_filter(['status' => $val])) }}"
           class="px-3.5 py-1.5 rounded-full text-xs font-medium transition
                  {{ $statusFilter === $val ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            {{ $label }}
        </a>
        @endforeach
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Peminjam</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Barang</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider hidden md:table-cell">Periode</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider hidden lg:table-cell">Alasan</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        @if(Auth::user()->canApproveInventaris())
                        <th class="px-4 py-3.5 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($peminjaman as $p)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-xs font-bold text-blue-700 shrink-0">
                                    {{ strtoupper(substr($p->peminjam->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-slate-700 text-sm">{{ $p->peminjam->name }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $p->departemen->nama_departemen }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3.5">
                            <p class="text-sm font-medium text-slate-700">{{ $p->inventaris->nama_barang }}</p>
                            <p class="text-xs text-slate-400">Qty: {{ $p->jumlah }}</p>
                        </td>
                        <td class="px-4 py-3.5 hidden md:table-cell text-xs text-slate-600">
                            <p>{{ $p->tanggal_pinjam->format('d/m/Y') }}</p>
                            <p class="text-slate-400">s/d {{ $p->tanggal_kembali->format('d/m/Y') }}</p>
                        </td>
                        <td class="px-4 py-3.5 hidden lg:table-cell">
                            <p class="text-xs text-slate-600 line-clamp-2 max-w-[180px]">{{ $p->alasan }}</p>
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium {{ $p->getStatusBadgeClass() }}">
                                {{ $p->status_pengajuan }}
                            </span>
                            @if($p->approved_at && $p->approvedBy)
                            <p class="text-[10px] text-slate-400 mt-1">oleh {{ $p->approvedBy->name }}</p>
                            @endif
                        </td>
                        @if(Auth::user()->canApproveInventaris())
                        <td class="px-4 py-3.5">
                            @if($p->status_pengajuan === 'Pending')
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open=!open" class="px-3 py-1.5 text-xs font-medium bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition">
                                    Tinjau ▾
                                </button>
                                <div x-show="open" @click.away="open=false"
                                     class="absolute right-0 mt-1 w-64 bg-white rounded-xl shadow-lg border border-slate-100 z-10 p-4"
                                     x-transition>
                                    <form method="POST" action="{{ route('inventaris.peminjaman.approval', $p) }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="block text-xs font-medium text-slate-700 mb-1">Catatan</label>
                                            <textarea name="catatan" rows="2" placeholder="Catatan persetujuan (opsional)"
                                                      class="w-full px-3 py-2 text-xs border border-slate-200 rounded-lg resize-none focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="submit" name="action" value="approve"
                                                    class="flex-1 py-2 text-xs font-medium bg-green-600 text-white rounded-lg hover:bg-green-700">
                                                ✓ Setujui
                                            </button>
                                            <button type="submit" name="action" value="reject"
                                                    class="flex-1 py-2 text-xs font-medium bg-red-600 text-white rounded-lg hover:bg-red-700">
                                                ✗ Tolak
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @else
                            <span class="text-xs text-slate-400">Sudah ditinjau</span>
                            @endif
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-sm">Belum ada pengajuan peminjaman</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($peminjaman->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $peminjaman->links() }}</div>
        @endif
    </div>
</div>
@endsection
