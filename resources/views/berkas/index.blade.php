@extends('layouts.app')
@section('title', 'Berkas')
@section('page-title', 'Berkas Organisasi')
@section('breadcrumb', 'Arsip dokumen organisasi mahasiswa')

@section('content')
<div class="space-y-5">

    {{-- Toolbar --}}
    <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between">
        <form method="GET" class="flex flex-wrap gap-2">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari berkas..."
                   class="min-w-0 max-w-[220px] px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="kategori" class="px-3 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Kategori</option>
                @foreach(['Proposal','LPJ','Notulen','Surat','Dokumentasi'] as $k)
                <option value="{{ $k }}" {{ $kategori == $k ? 'selected' : '' }}>{{ $k }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700">Cari</button>
            @if($search || $kategori)
            <a href="{{ route('berkas.index') }}" class="px-4 py-2 text-sm text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200">Reset</a>
            @endif
        </form>
        @if(Auth::user()->isAdmin())
        <a href="{{ route('berkas.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Upload Berkas
        </a>
        @endif
    </div>

    {{-- Kategori Pills --}}
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('berkas.index') }}"
           class="px-3.5 py-1.5 rounded-full text-xs font-medium transition {{ !$kategori ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            Semua
        </a>
        @php
        $katColors = ['Proposal'=>'blue','LPJ'=>'purple','Notulen'=>'green','Surat'=>'orange','Dokumentasi'=>'pink'];
        @endphp
        @foreach($katColors as $kat => $clr)
        <a href="{{ route('berkas.index', ['kategori' => $kat]) }}"
           class="px-3.5 py-1.5 rounded-full text-xs font-medium transition {{ $kategori === $kat ? "bg-{$clr}-600 text-white" : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            {{ $kat }}
        </a>
        @endforeach
    </div>

    {{-- Berkas Grid --}}
    @if($berkas->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach($berkas as $b)
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow overflow-hidden group">
            {{-- Top color strip --}}
            <div class="h-1.5 {{ match($b->kategori) {
                'Proposal'=>'bg-blue-500','LPJ'=>'bg-purple-500','Notulen'=>'bg-green-500','Surat'=>'bg-orange-500',default=>'bg-pink-500'
            } }}"></div>

            <div class="p-5">
                {{-- File Icon --}}
                <div class="flex items-start justify-between mb-3">
                    <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-2xl">
                        {{ $b->getFileIcon() }}
                    </div>
                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-medium {{ $b->getKategoriBadgeClass() }}">
                        {{ $b->kategori }}
                    </span>
                </div>

                {{-- Info --}}
                <h3 class="text-sm font-semibold text-slate-800 leading-snug line-clamp-2 mb-1">{{ $b->judul_berkas }}</h3>
                @if($b->deskripsi)
                <p class="text-xs text-slate-400 line-clamp-2 mb-3">{{ $b->deskripsi }}</p>
                @endif

                <div class="text-[10px] text-slate-400 space-y-0.5 mb-4">
                    <p>{{ $b->nama_file }}</p>
                    <p>{{ $b->ukuran_file }} · {{ $b->created_at->diffForHumans() }}</p>
                    <p>Oleh: {{ $b->uploader->name }}</p>
                </div>

                {{-- Actions --}}
                <div class="flex gap-2">
                    <a href="{{ route('berkas.download', $b) }}"
                       class="flex-1 flex items-center justify-center gap-1.5 py-2 text-xs font-medium bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                        Unduh
                    </a>
                    <a href="{{ route('berkas.show', $b) }}"
                       class="px-3 py-2 text-xs font-medium text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition">
                        Detail
                    </a>
                    @if(Auth::user()->isAdmin())
                    <form method="POST" action="{{ route('berkas.destroy', $b) }}" onsubmit="return confirm('Hapus berkas ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($berkas->hasPages())
    <div>{{ $berkas->links() }}</div>
    @endif

    @else
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 py-20 text-center text-slate-400">
        <svg class="w-14 h-14 mx-auto mb-3 opacity-25" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776"/>
        </svg>
        <p class="text-sm font-medium">Tidak ada berkas ditemukan</p>
        <p class="text-xs mt-1">Coba ubah filter pencarian atau kategori</p>
    </div>
    @endif
</div>
@endsection
