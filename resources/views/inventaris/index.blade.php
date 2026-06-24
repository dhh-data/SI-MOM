@extends('layouts.app')
@section('title', 'Inventaris')
@section('page-title', 'Inventaris & Peminjaman')
@section('breadcrumb', 'Daftar barang inventaris organisasi')

@section('content')
<div class="space-y-5">
    {{-- Sub Nav --}}
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('inventaris.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('inventaris.index') ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            Data Inventaris
        </a>
        <a href="{{ route('inventaris.peminjaman') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('inventaris.peminjaman') ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            Pengajuan Peminjaman
        </a>
    </div>

    {{-- Toolbar --}}
    <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between">
        <form method="GET" class="flex flex-wrap gap-2">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari barang..."
                   class="min-w-0 max-w-[200px] px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="kategori" class="px-3 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Kategori</option>
                @foreach(['Elektronik','Perlengkapan','Dokumentasi','ATK','Lainnya'] as $k)
                <option value="{{ $k }}" {{ $kategori == $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
            <select name="status" class="px-3 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Status</option>
                @foreach(['Tersedia','Dipinjam','Maintenance'] as $s)
                <option value="{{ $s }}" {{ $status == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700">Filter</button>
        </form>
        <div class="flex gap-2">
            @if(Auth::user()->canAjukanPeminjaman())
            <a href="{{ route('inventaris.ajukan') }}"
               class="inline-flex items-center gap-2 px-4 py-2 border border-blue-600 text-blue-600 text-sm font-medium rounded-xl hover:bg-blue-50 transition whitespace-nowrap">
                Ajukan Peminjaman
            </a>
            @endif
            @if(Auth::user()->canManageInventaris())
            <a href="{{ route('inventaris.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                Tambah Barang
            </a>
            @endif
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4">
        @php
        $allInv = \App\Models\Inventaris::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total','status');
        @endphp
        <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100 text-center">
            <p class="text-xl font-bold text-green-600">{{ $allInv->get('Tersedia', 0) }}</p>
            <p class="text-xs text-slate-500">Tersedia</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100 text-center">
            <p class="text-xl font-bold text-yellow-600">{{ $allInv->get('Dipinjam', 0) }}</p>
            <p class="text-xs text-slate-500">Dipinjam</p>
        </div>
        <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100 text-center">
            <p class="text-xl font-bold text-red-600">{{ $allInv->get('Maintenance', 0) }}</p>
            <p class="text-xs text-slate-500">Maintenance</p>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Barang</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Jumlah</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider hidden md:table-cell">Kondisi</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider hidden lg:table-cell">Lokasi</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        @if(Auth::user()->canManageInventaris())
                        <th class="px-4 py-3.5 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($inventaris as $inv)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-lg shrink-0">
                                    {{ $inv->getKategoriIcon() }}
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800">{{ $inv->nama_barang }}</p>
                                    @if($inv->keterangan)
                                    <p class="text-xs text-slate-400 truncate max-w-[200px]">{{ $inv->keterangan }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3.5 text-slate-600 text-sm">{{ $inv->kategori }}</td>
                        <td class="px-4 py-3.5">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-50 text-blue-700 font-semibold text-sm">{{ $inv->jumlah }}</span>
                        </td>
                        <td class="px-4 py-3.5 hidden md:table-cell">
                            <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-medium {{ $inv->getKondisiBadgeClass() }}">{{ $inv->kondisi }}</span>
                        </td>
                        <td class="px-4 py-3.5 hidden lg:table-cell text-xs text-slate-500">{{ $inv->lokasi_penyimpanan }}</td>
                        <td class="px-4 py-3.5">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium {{ $inv->getStatusBadgeClass() }}">{{ $inv->status }}</span>
                        </td>
                        @if(Auth::user()->canManageInventaris())
                        <td class="px-4 py-3.5">
                            <div class="flex items-center justify-center gap-1">
                                <a href="{{ route('inventaris.edit', $inv) }}"
                                   class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('inventaris.destroy', $inv) }}" onsubmit="return confirm('Hapus barang ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                            <p class="text-sm">Tidak ada barang ditemukan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($inventaris->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $inventaris->links() }}</div>
        @endif
    </div>
</div>
@endsection
