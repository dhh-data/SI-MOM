@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Selamat datang, ' . Auth::user()->name)

@section('content')
<div class="space-y-6">
    {{-- Stat Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="w-10 h-10 rounded-xl bg-blue-500 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['jumlah_anggota'] }}</p>
            <p class="text-xs text-slate-500">Anggota Departemen</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="w-10 h-10 rounded-xl bg-violet-500 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $stats['proker_selesai'] }}/{{ $stats['jumlah_proker'] }}</p>
            <p class="text-xs text-slate-500">Proker Selesai</p>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
            <div class="w-10 h-10 rounded-xl bg-teal-500 flex items-center justify-center mb-3">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z"/></svg>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $progress['persen'] }}%</p>
            <p class="text-xs text-slate-500">Progress Keseluruhan</p>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {{-- Progress Bar --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h2 class="text-sm font-semibold text-slate-800 mb-1">Progress Departemen</h2>
            <p class="text-xs text-slate-500 mb-4">{{ $departemen->nama_departemen ?? '-' }}</p>
            <div class="relative flex items-center justify-center mb-4">
                <svg class="w-32 h-32 -rotate-90" viewBox="0 0 120 120">
                    <circle cx="60" cy="60" r="50" fill="none" stroke="#f1f5f9" stroke-width="10"/>
                    <circle cx="60" cy="60" r="50" fill="none" stroke="#2563eb" stroke-width="10"
                            stroke-dasharray="{{ round(314 * $progress['persen'] / 100) }} 314"
                            stroke-linecap="round"/>
                </svg>
                <div class="absolute text-center">
                    <p class="text-2xl font-bold text-slate-800">{{ $progress['persen'] }}%</p>
                    <p class="text-[10px] text-slate-400">selesai</p>
                </div>
            </div>
            <p class="text-center text-sm text-slate-600">{{ $progress['selesai'] }} dari {{ $progress['total'] }} program kerja selesai</p>
        </div>

        {{-- Program Kerja Terbaru --}}
        <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-800">Program Kerja</h2>
                <a href="{{ route('departemen.proker') }}" class="text-xs text-blue-600 hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($programKerja as $pk)
                <div class="px-6 py-3">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-slate-700">{{ $pk->nama_proker }}</p>
                            <p class="text-xs text-slate-400 mt-0.5">PIC: {{ $pk->pic }}</p>
                        </div>
                        @php
                        $sc = match($pk->status){
                            'Selesai'=>'bg-green-100 text-green-700',
                            'Berjalan'=>'bg-blue-100 text-blue-700',
                            default=>'bg-yellow-100 text-yellow-700'
                        };
                        @endphp
                        <span class="shrink-0 inline-flex px-2 py-0.5 rounded-full text-[10px] font-medium {{ $sc }}">{{ $pk->status }}</span>
                    </div>
                    <div class="mt-2">
                        <div class="flex justify-between text-[10px] text-slate-400 mb-1">
                            <span>Progress</span><span>{{ $pk->progress }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-1.5">
                            <div class="h-1.5 rounded-full {{ $pk->getProgressBarClass() }}" style="width:{{ $pk->progress }}%"></div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-slate-400 text-sm">Belum ada program kerja</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        {{-- Rapat Terdekat --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h2 class="text-sm font-semibold text-slate-800 mb-4">Rapat Akbar Terdekat</h2>
            @if($rapatTerdekat)
            <div class="bg-blue-50 rounded-xl p-4">
                <p class="font-semibold text-slate-800 text-sm">{{ $rapatTerdekat->nama_rapat }}</p>
                <p class="text-xs text-slate-500 mt-1">{{ $rapatTerdekat->tanggal->translatedFormat('d F Y') }} — {{ $rapatTerdekat->waktu }}</p>
                <p class="text-xs text-slate-500">📍 {{ $rapatTerdekat->lokasi }}</p>
                <a href="{{ route('rapat.show', $rapatTerdekat) }}" class="mt-3 inline-block text-xs font-medium text-blue-600 hover:underline">Detail & Presensi →</a>
            </div>
            @else
            <p class="text-sm text-slate-400 text-center py-6">Belum ada rapat terjadwal</p>
            @endif
        </div>

        {{-- Status Peminjaman Saya --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-800">Peminjaman Saya</h2>
                <a href="{{ route('inventaris.peminjaman') }}" class="text-xs text-blue-600 hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($peminjamanSaya as $p)
                <div class="flex items-center gap-3 px-6 py-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-slate-700 truncate">{{ $p->inventaris->nama_barang }}</p>
                        <p class="text-[11px] text-slate-400">{{ $p->tanggal_pinjam->format('d/m/Y') }} s/d {{ $p->tanggal_kembali->format('d/m/Y') }}</p>
                    </div>
                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-medium {{ $p->getStatusBadgeClass() }}">{{ $p->status_pengajuan }}</span>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-slate-400 text-sm">Belum ada pengajuan</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
