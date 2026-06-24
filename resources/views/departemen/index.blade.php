@extends('layouts.app')
@section('title', 'Departemen')
@section('page-title', 'Departemen & Anggota')
@section('breadcrumb', 'Data departemen organisasi')

@section('content')
<div class="space-y-6">
    {{-- Sub Navigation --}}
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('departemen.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('departemen.index') ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            Departemen
        </a>
        <a href="{{ route('departemen.anggota') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('departemen.anggota*') ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            Data Anggota
        </a>
        <a href="{{ route('departemen.proker') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('departemen.proker*') ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            Program Kerja
        </a>
    </div>

    {{-- Departemen Grid --}}
    @php
    $depColors = [
        'Presidium'  => ['gradient'=>'from-blue-500 to-blue-700',   'light'=>'bg-blue-50',  'text'=>'text-blue-600'],
        'PSDM'       => ['gradient'=>'from-violet-500 to-violet-700','light'=>'bg-violet-50','text'=>'text-violet-600'],
        'Media'      => ['gradient'=>'from-pink-500 to-pink-700',    'light'=>'bg-pink-50',  'text'=>'text-pink-600'],
        'Pendidikan' => ['gradient'=>'from-teal-500 to-teal-700',    'light'=>'bg-teal-50',  'text'=>'text-teal-600'],
        'Inventaris' => ['gradient'=>'from-orange-500 to-orange-700','light'=>'bg-orange-50','text'=>'text-orange-600'],
    ];
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @foreach($departemens as $dep)
        @php
            $prog = $dep->getProgressProker();
            $clr = $depColors[$dep->nama_departemen] ?? ['gradient'=>'from-slate-500 to-slate-700','light'=>'bg-slate-50','text'=>'text-slate-600'];
            $kepala = $dep->kepalaDepartemen;
        @endphp
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-md transition-shadow">
            <div class="h-2 bg-gradient-to-r {{ $clr['gradient'] }}"></div>
            <div class="p-5">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <h3 class="font-semibold text-slate-800">{{ $dep->nama_departemen }}</h3>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $dep->deskripsi }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mb-4">
                    <div class="{{ $clr['light'] }} rounded-xl p-3 text-center">
                        <p class="text-lg font-bold {{ $clr['text'] }}">{{ $dep->getJumlahAnggota() }}</p>
                        <p class="text-[10px] text-slate-500">Anggota</p>
                    </div>
                    <div class="{{ $clr['light'] }} rounded-xl p-3 text-center">
                        <p class="text-lg font-bold {{ $clr['text'] }}">{{ $dep->programKerja->count() }}</p>
                        <p class="text-[10px] text-slate-500">Program Kerja</p>
                    </div>
                </div>

                {{-- Progress --}}
                <div class="mb-4">
                    <div class="flex justify-between text-xs text-slate-500 mb-1.5">
                        <span>Progress Proker</span>
                        <span class="font-semibold">{{ $prog['selesai'] }}/{{ $prog['total'] }} Selesai</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-2">
                        <div class="h-2 rounded-full bg-gradient-to-r {{ $clr['gradient'] }} transition-all"
                             style="width: {{ $prog['persen'] }}%"></div>
                    </div>
                    <p class="text-[10px] text-right text-slate-400 mt-1">{{ $prog['persen'] }}%</p>
                </div>

                {{-- Kepala --}}
                @if($kepala)
                <div class="flex items-center gap-2 pt-3 border-t border-slate-100">
                    <div class="w-7 h-7 rounded-full bg-gradient-to-br {{ $clr['gradient'] }} text-white flex items-center justify-center text-[10px] font-bold shrink-0">
                        {{ strtoupper(substr($kepala->name, 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs font-medium text-slate-700 truncate">{{ $kepala->name }}</p>
                        <p class="text-[10px] text-slate-400">Kepala Departemen</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
