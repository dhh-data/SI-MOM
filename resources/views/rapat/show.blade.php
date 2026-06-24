@extends('layouts.app')
@section('title', $rapat->nama_rapat)
@section('page-title', $rapat->nama_rapat)
@section('breadcrumb', 'Rapat Akbar / Detail')

@section('content')
<div class="space-y-6">
    {{-- Header Card --}}
    <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="inline-flex px-2.5 py-1 rounded-full text-[11px] font-medium bg-white/20 backdrop-blur">{{ $rapat->status }}</span>
                </div>
                <h1 class="text-xl font-bold">{{ $rapat->nama_rapat }}</h1>
                <div class="mt-3 flex flex-wrap gap-4 text-sm text-blue-100">
                    <span>📅 {{ $rapat->tanggal->translatedFormat('l, d F Y') }}</span>
                    <span>🕐 {{ $rapat->waktu }} WIB</span>
                    <span>📍 {{ $rapat->lokasi }}</span>
                </div>
            </div>
            <div class="flex flex-wrap gap-2 shrink-0">
                <a href="{{ route('rapat.presensi', $rapat) }}"
                   class="px-4 py-2 bg-white/20 backdrop-blur text-white text-sm font-medium rounded-xl hover:bg-white/30 transition">
                    Presensi
                </a>
                <a href="{{ route('rapat.notulensi', $rapat) }}"
                   class="px-4 py-2 bg-white text-blue-700 text-sm font-medium rounded-xl hover:bg-blue-50 transition">
                    Notulensi
                </a>
                @if(Auth::user()->isAdmin())
                <a href="{{ route('rapat.edit', $rapat) }}"
                   class="px-4 py-2 bg-white/20 backdrop-blur text-white text-sm font-medium rounded-xl hover:bg-white/30 transition">
                    Edit
                </a>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {{-- Agenda --}}
        <div class="xl:col-span-2 space-y-5">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <h2 class="text-sm font-semibold text-slate-800 mb-3">Agenda Rapat</h2>
                <div class="prose prose-sm text-slate-600 whitespace-pre-line">{{ $rapat->agenda }}</div>
            </div>

            {{-- Dokumentasi --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-sm font-semibold text-slate-800">Dokumentasi</h2>
                </div>
                @if($rapat->dokumentasi->count())
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach($rapat->dokumentasi as $dok)
                    <div class="bg-slate-50 rounded-xl p-3 text-center">
                        <div class="text-2xl mb-1">{{ $dok->jenis === 'foto' ? '🖼️' : '📎' }}</div>
                        <p class="text-xs font-medium text-slate-700 truncate">{{ $dok->nama_file }}</p>
                        <p class="text-[10px] text-slate-400 capitalize">{{ $dok->jenis }}</p>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-sm text-slate-400 text-center py-6">Belum ada dokumentasi</p>
                @endif

                @if(Auth::user()->isAdmin() || Auth::user()->isKepalaDepartemen())
                <form method="POST" action="{{ route('rapat.dokumentasi.store', $rapat) }}" enctype="multipart/form-data" class="mt-4 pt-4 border-t border-slate-100">
                    @csrf
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1.5">Jenis</label>
                            <select name="jenis" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="foto">Foto</option>
                                <option value="lampiran">Lampiran</option>
                                <option value="hasil">Hasil Rapat</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1.5">File</label>
                            <input type="file" name="file" class="w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>
                    </div>
                    <button type="submit" class="mt-3 px-4 py-2 text-xs font-medium bg-blue-600 text-white rounded-xl hover:bg-blue-700">Upload</button>
                </form>
                @endif
            </div>
        </div>

        {{-- Statistik Presensi --}}
        <div class="space-y-5">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <h2 class="text-sm font-semibold text-slate-800 mb-4">Statistik Kehadiran</h2>
                <div class="space-y-3">
                    @php $total = max($presensiStats['total'], 1); @endphp
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-green-500 shrink-0"></div>
                        <div class="flex-1">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-slate-600">Hadir</span>
                                <span class="font-semibold text-slate-800">{{ $presensiStats['hadir'] }}</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="h-1.5 rounded-full bg-green-500" style="width:{{ round($presensiStats['hadir']/$total*100) }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-yellow-400 shrink-0"></div>
                        <div class="flex-1">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-slate-600">Izin</span>
                                <span class="font-semibold text-slate-800">{{ $presensiStats['izin'] }}</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="h-1.5 rounded-full bg-yellow-400" style="width:{{ round($presensiStats['izin']/$total*100) }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full bg-red-400 shrink-0"></div>
                        <div class="flex-1">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-slate-600">Tidak Hadir</span>
                                <span class="font-semibold text-slate-800">{{ $presensiStats['tidak_hadir'] }}</span>
                            </div>
                            <div class="w-full bg-slate-100 rounded-full h-1.5">
                                <div class="h-1.5 rounded-full bg-red-400" style="width:{{ round($presensiStats['tidak_hadir']/$total*100) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 text-center">
                    <p class="text-2xl font-bold text-slate-800">{{ round($presensiStats['hadir']/$total*100) }}%</p>
                    <p class="text-xs text-slate-500">Tingkat Kehadiran</p>
                </div>
            </div>

            {{-- Presensi Saya --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <h2 class="text-sm font-semibold text-slate-800 mb-3">Presensi Saya</h2>
                @if($userPresensi)
                <div class="text-center">
                    <span class="inline-flex px-4 py-2 rounded-xl text-sm font-medium {{ $userPresensi->getStatusBadgeClass() }}">
                        {{ $userPresensi->status }}
                    </span>
                </div>
                @endif
                <a href="{{ route('rapat.presensi', $rapat) }}"
                   class="mt-4 w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition">
                    {{ $userPresensi && $userPresensi->status !== 'Tidak Hadir' ? 'Ubah Presensi' : 'Isi Presensi' }}
                </a>
            </div>

            {{-- Notulensi --}}
            @if($rapat->notulensi)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
                <h2 class="text-sm font-semibold text-slate-800 mb-3">Notulensi</h2>
                <p class="text-sm font-medium text-slate-700">{{ $rapat->notulensi->judul_notulensi }}</p>
                <p class="text-xs text-slate-400 mt-1">Oleh: {{ $rapat->notulensi->penulis->name }}</p>
                <a href="{{ route('rapat.notulensi', $rapat) }}"
                   class="mt-3 inline-flex items-center gap-1 text-xs font-medium text-blue-600 hover:underline">
                    Baca notulensi →
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
