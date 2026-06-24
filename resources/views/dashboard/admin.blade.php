@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Selamat datang, ' . Auth::user()->name)

@section('content')
<div class="space-y-6">

    {{-- STAT CARDS --}}
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4">
        @php
        $cards = [
            ['label'=>'Total Anggota',    'value'=>$stats['total_anggota'],       'color'=>'blue',   'icon'=>'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z'],
            ['label'=>'Departemen',       'value'=>$stats['total_departemen'],     'color'=>'violet', 'icon'=>'M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z'],
            ['label'=>'Total Inventaris', 'value'=>$stats['total_inventaris'],     'color'=>'orange', 'icon'=>'M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z'],
            ['label'=>'Rapat Akbar',      'value'=>$stats['total_rapat'],          'color'=>'teal',   'icon'=>'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],
            ['label'=>'Total Berkas',     'value'=>$stats['total_berkas'],          'color'=>'pink',   'icon'=>'M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776'],
            ['label'=>'Peminjaman Pending','value'=>$stats['peminjaman_pending'],  'color'=>'yellow', 'icon'=>'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'],
        ];
        $colors = [
            'blue'  =>['bg'=>'bg-blue-50',  'icon'=>'bg-blue-500',   'text'=>'text-blue-600'],
            'violet'=>['bg'=>'bg-violet-50','icon'=>'bg-violet-500', 'text'=>'text-violet-600'],
            'orange'=>['bg'=>'bg-orange-50','icon'=>'bg-orange-500', 'text'=>'text-orange-600'],
            'teal'  =>['bg'=>'bg-teal-50',  'icon'=>'bg-teal-500',   'text'=>'text-teal-600'],
            'pink'  =>['bg'=>'bg-pink-50',  'icon'=>'bg-pink-500',   'text'=>'text-pink-600'],
            'yellow'=>['bg'=>'bg-yellow-50','icon'=>'bg-yellow-500', 'text'=>'text-yellow-600'],
        ];
        @endphp
        @foreach($cards as $card)
        @php $c = $colors[$card['color']]; @endphp
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="w-9 h-9 rounded-xl {{ $c['icon'] }} flex items-center justify-center">
                    <svg class="w-4.5 h-4.5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $card['icon'] }}" />
                    </svg>
                </div>
            </div>
            <p class="text-2xl font-bold text-slate-800">{{ $card['value'] }}</p>
            <p class="text-xs text-slate-500 mt-0.5">{{ $card['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- ROW 2: Progress + Rapat Terdekat --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Progress Departemen --}}
        <div class="xl:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-sm font-semibold text-slate-800">Progress Departemen</h2>
                    <p class="text-xs text-slate-500">Capaian program kerja per departemen</p>
                </div>
            </div>
            <div class="space-y-4">
                @php
                $depColors = ['Presidium'=>'bg-blue-500','PSDM'=>'bg-violet-500','Media'=>'bg-pink-500','Pendidikan'=>'bg-teal-500','Inventaris'=>'bg-orange-500'];
                @endphp
                @foreach($departemens as $dep)
                @php
                    $prog = $dep->getProgressProker();
                    $clr = $depColors[$dep->nama_departemen] ?? 'bg-slate-400';
                @endphp
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full {{ $clr }}"></div>
                            <span class="text-sm font-medium text-slate-700">{{ $dep->nama_departemen }}</span>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-semibold text-slate-600">{{ $prog['selesai'] }}/{{ $prog['total'] }} Proker</span>
                            <span class="text-xs text-slate-400 ml-1">({{ $prog['persen'] }}%)</span>
                        </div>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="h-2 rounded-full {{ $clr }} transition-all duration-500"
                             style="width: {{ $prog['persen'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Rapat Terdekat --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h2 class="text-sm font-semibold text-slate-800 mb-4">Rapat Terdekat</h2>
            @if($rapatTerdekat)
            <div class="bg-blue-50 rounded-xl p-4 mb-4">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-blue-100 text-blue-700 mb-2">
                    {{ $rapatTerdekat->status }}
                </span>
                <p class="font-semibold text-slate-800 text-sm leading-snug">{{ $rapatTerdekat->nama_rapat }}</p>
                <div class="mt-3 space-y-1.5">
                    <div class="flex items-center gap-2 text-xs text-slate-600">
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                        {{ $rapatTerdekat->tanggal->translatedFormat('d F Y') }} — {{ $rapatTerdekat->waktu }}
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-600">
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        {{ $rapatTerdekat->lokasi }}
                    </div>
                </div>
                <a href="{{ route('rapat.show', $rapatTerdekat) }}"
                   class="mt-3 inline-flex items-center gap-1 text-xs font-medium text-blue-600 hover:text-blue-700">
                    Lihat detail
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
            </div>
            @else
            <div class="text-center py-8 text-slate-400">
                <svg class="w-10 h-10 mx-auto mb-2 opacity-40" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/></svg>
                <p class="text-xs">Belum ada rapat terjadwal</p>
            </div>
            @endif
            <a href="{{ route('rapat.index') }}" class="block text-center text-xs font-medium text-blue-600 hover:text-blue-700 mt-1">
                Lihat semua rapat →
            </a>
        </div>
    </div>

    {{-- ROW 3: Pengajuan + Berkas Terbaru --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        {{-- Pengajuan Inventaris Terbaru --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h2 class="text-sm font-semibold text-slate-800">Pengajuan Peminjaman Terbaru</h2>
                <a href="{{ route('inventaris.peminjaman') }}" class="text-xs text-blue-600 hover:underline">Lihat semua</a>
            </div>
            <div class="divide-y divide-slate-50">
                @forelse($peminjamanTerbaru as $p)
                <div class="flex items-center gap-3 px-6 py-3">
                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-xs font-bold text-slate-600 shrink-0">
                        {{ strtoupper(substr($p->peminjam->name, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-slate-700 truncate">{{ $p->inventaris->nama_barang }}</p>
                        <p class="text-[11px] text-slate-400">{{ $p->peminjam->name }} · {{ $p->departemen->nama_departemen }}</p>
                    </div>
                    <span class="shrink-0 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium {{ $p->getStatusBadgeClass() }}">
                        {{ $p->status_pengajuan }}
                    </span>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-slate-400 text-sm">Belum ada pengajuan</div>
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
                    <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-base shrink-0">
                        {{ $b->getFileIcon() }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-slate-700 truncate">{{ $b->judul_berkas }}</p>
                        <p class="text-[11px] text-slate-400">{{ $b->ukuran_file }} · {{ $b->created_at->diffForHumans() }}</p>
                    </div>
                    <span class="shrink-0 inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium {{ $b->getKategoriBadgeClass() }}">
                        {{ $b->kategori }}
                    </span>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-slate-400 text-sm">Belum ada berkas</div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
