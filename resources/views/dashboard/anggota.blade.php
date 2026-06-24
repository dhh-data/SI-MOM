@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Selamat datang, ' . Auth::user()->name . ' — ' . (Auth::user()->departemen->nama_departemen ?? ''))

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {{-- Rapat Terdekat --}}
        <div class="xl:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h2 class="text-sm font-semibold text-slate-800 mb-4">Rapat Akbar Terdekat</h2>
            @if($rapatTerdekat)
            <div class="flex gap-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-5 border border-blue-100">
                <div class="text-center bg-white rounded-xl p-3 shadow-sm w-16 shrink-0">
                    <p class="text-xs text-slate-400 font-medium">{{ $rapatTerdekat->tanggal->translatedFormat('M') }}</p>
                    <p class="text-2xl font-bold text-blue-600 leading-none">{{ $rapatTerdekat->tanggal->format('d') }}</p>
                    <p class="text-xs text-slate-400">{{ $rapatTerdekat->tanggal->format('Y') }}</p>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-slate-800">{{ $rapatTerdekat->nama_rapat }}</p>
                    <p class="text-xs text-slate-500 mt-1">🕐 {{ $rapatTerdekat->waktu }} WIB</p>
                    <p class="text-xs text-slate-500">📍 {{ $rapatTerdekat->lokasi }}</p>
                    <a href="{{ route('rapat.presensi', $rapatTerdekat) }}"
                       class="mt-3 inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700 transition">
                        Isi Presensi
                    </a>
                </div>
            </div>
            @else
            <div class="text-center py-10 text-slate-400">
                <svg class="w-12 h-12 mx-auto mb-2 opacity-30" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/></svg>
                <p class="text-sm">Belum ada rapat terjadwal</p>
            </div>
            @endif
        </div>

        {{-- Presensi Terakhir --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-800">Riwayat Presensi</h2>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($presensiSaya as $p)
                <div class="flex items-center gap-3 px-6 py-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-slate-700 truncate">{{ $p->rapat->nama_rapat }}</p>
                        <p class="text-[11px] text-slate-400">{{ $p->rapat->tanggal->format('d/m/Y') }}</p>
                    </div>
                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-medium {{ $p->getStatusBadgeClass() }}">{{ $p->status }}</span>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-slate-400 text-xs">Belum ada riwayat presensi</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        {{-- Inventaris Tersedia --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-800">Inventaris Tersedia</h2>
                <a href="{{ route('inventaris.index') }}" class="text-xs text-blue-600 hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($inventarisTersedia as $inv)
                <div class="flex items-center gap-3 px-6 py-3">
                    <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center text-base">{{ $inv->getKategoriIcon() }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-slate-700 truncate">{{ $inv->nama_barang }}</p>
                        <p class="text-[11px] text-slate-400">{{ $inv->kategori }} · Stok: {{ $inv->jumlah }}</p>
                    </div>
                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-medium bg-green-100 text-green-700">Tersedia</span>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-slate-400 text-sm">Tidak ada inventaris tersedia</div>
                @endforelse
            </div>
        </div>

        {{-- Berkas Terbaru --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-800">Berkas Terbaru</h2>
                <a href="{{ route('berkas.index') }}" class="text-xs text-blue-600 hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($berkasTerbaru as $b)
                <div class="flex items-center gap-3 px-6 py-3">
                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-base shrink-0">{{ $b->getFileIcon() }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-slate-700 truncate">{{ $b->judul_berkas }}</p>
                        <p class="text-[11px] text-slate-400">{{ $b->kategori }} · {{ $b->ukuran_file }}</p>
                    </div>
                    <a href="{{ route('berkas.download', $b) }}" class="shrink-0 p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg>
                    </a>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-slate-400 text-sm">Belum ada berkas</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
