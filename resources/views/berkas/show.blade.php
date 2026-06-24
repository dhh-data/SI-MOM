@extends('layouts.app')
@section('title', $berkas->judul_berkas)
@section('page-title', 'Detail Berkas')
@section('breadcrumb', 'Berkas / Detail')

@section('content')
<div class="max-w-2xl mx-auto space-y-5">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="h-2 {{ match($berkas->kategori) {
            'Proposal'=>'bg-blue-500','LPJ'=>'bg-purple-500','Notulen'=>'bg-green-500','Surat'=>'bg-orange-500',default=>'bg-pink-500'
        } }}"></div>
        <div class="p-6">
            <div class="flex items-start gap-4 mb-6">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-4xl shrink-0">
                    {{ $berkas->getFileIcon() }}
                </div>
                <div class="flex-1 min-w-0">
                    <h2 class="text-lg font-bold text-slate-800 leading-snug">{{ $berkas->judul_berkas }}</h2>
                    <span class="inline-flex mt-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $berkas->getKategoriBadgeClass() }}">{{ $berkas->kategori }}</span>
                </div>
            </div>

            @if($berkas->deskripsi)
            <div class="mb-5 p-4 bg-slate-50 rounded-xl">
                <p class="text-xs font-semibold text-slate-500 uppercase mb-1.5">Deskripsi</p>
                <p class="text-sm text-slate-700">{{ $berkas->deskripsi }}</p>
            </div>
            @endif

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <p class="text-xs text-slate-400">Nama File</p>
                    <p class="text-sm font-medium text-slate-700 truncate">{{ $berkas->nama_file }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Ukuran</p>
                    <p class="text-sm font-medium text-slate-700">{{ $berkas->ukuran_file }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Diunggah Oleh</p>
                    <p class="text-sm font-medium text-slate-700">{{ $berkas->uploader->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Tanggal Upload</p>
                    <p class="text-sm font-medium text-slate-700">{{ $berkas->created_at->translatedFormat('d F Y') }}</p>
                </div>
            </div>

            <div class="flex gap-3">
                <a href="{{ route('berkas.download', $berkas) }}"
                   class="flex-1 flex items-center justify-center gap-2 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    Download File
                </a>
                <a href="{{ route('berkas.index') }}"
                   class="flex-1 flex items-center justify-center py-2.5 text-sm font-medium text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
