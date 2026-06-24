@extends('layouts.app')
@section('title', 'Program Kerja')
@section('page-title', 'Program Kerja')
@section('breadcrumb', 'Departemen & Anggota / Program Kerja')

@section('content')
<div class="space-y-5" x-data="{ showModal: false, editModal: false, editData: {} }">

    {{-- Sub Nav --}}
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('departemen.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-white text-slate-600 border border-slate-200 hover:bg-slate-50">Departemen</a>
        <a href="{{ route('departemen.anggota') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-white text-slate-600 border border-slate-200 hover:bg-slate-50">Data Anggota</a>
        <a href="{{ route('departemen.proker') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-blue-600 text-white shadow-sm">Program Kerja</a>
    </div>

    {{-- Toolbar --}}
    <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between">
        <form method="GET" class="flex flex-wrap gap-2">
            @if(Auth::user()->isAdmin())
            <select name="departemen" class="px-3 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Departemen</option>
                @foreach($departemens as $dep)
                <option value="{{ $dep->id }}" {{ $departemenFilter == $dep->id ? 'selected' : '' }}>{{ $dep->nama_departemen }}</option>
                @endforeach
            </select>
            @endif
            <select name="status" class="px-3 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Status</option>
                @foreach(['Perencanaan','Berjalan','Selesai'] as $s)
                <option value="{{ $s }}" {{ $statusFilter == $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700">Filter</button>
        </form>
        @if(Auth::user()->isKepalaDepartemen() || Auth::user()->isAdmin())
        <button @click="showModal=true"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Proker
        </button>
        @endif
    </div>

    {{-- Proker Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($programKerja as $pk)
        @php
        $statusColor = match($pk->status){
            'Selesai'=>'bg-green-100 text-green-700','Berjalan'=>'bg-blue-100 text-blue-700',default=>'bg-yellow-100 text-yellow-700'
        };
        $barColor = $pk->getProgressBarClass();
        @endphp
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1 min-w-0 pr-2">
                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-medium {{ $statusColor }} mb-2">{{ $pk->status }}</span>
                    <h3 class="font-semibold text-slate-800 text-sm leading-snug">{{ $pk->nama_proker }}</h3>
                    <p class="text-xs text-blue-600 font-medium mt-0.5">{{ $pk->departemen->nama_departemen }}</p>
                </div>
                @if(Auth::user()->isAdmin() || (Auth::user()->isKepalaDepartemen() && Auth::user()->departemen_id == $pk->departemen_id))
                <div class="flex items-center gap-1 shrink-0">
                    <button @click="editData={{ $pk->toJson() }}; editModal=true"
                            class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                    </button>
                    <form method="POST" action="{{ route('departemen.proker.destroy', $pk) }}" onsubmit="return confirm('Hapus proker ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <div class="text-xs text-slate-500 space-y-1 mb-4">
                <p>👤 PIC: <span class="font-medium text-slate-700">{{ $pk->pic }}</span></p>
                <p>📅 {{ $pk->tanggal_mulai->format('d/m/Y') }} s/d {{ $pk->tanggal_selesai->format('d/m/Y') }}</p>
                @if($pk->deskripsi)
                <p class="line-clamp-2 leading-relaxed">{{ $pk->deskripsi }}</p>
                @endif
            </div>

            <div>
                <div class="flex justify-between text-xs text-slate-500 mb-1.5">
                    <span>Progress</span><span class="font-semibold">{{ $pk->progress }}%</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="h-2 rounded-full {{ $barColor }} transition-all" style="width:{{ $pk->progress }}%"></div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 bg-white rounded-2xl shadow-sm border border-slate-100 py-16 text-center text-slate-400">
            <svg class="w-12 h-12 mx-auto mb-2 opacity-30" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <p>Belum ada program kerja</p>
        </div>
        @endforelse
    </div>
    @if($programKerja->hasPages())
    <div>{{ $programKerja->links() }}</div>
    @endif

    {{-- Modal Tambah --}}
    <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" x-transition.opacity>
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg" @click.away="showModal=false">
            <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
                <h3 class="font-semibold text-slate-800">Tambah Program Kerja</h3>
                <button @click="showModal=false" class="p-1 text-slate-400 hover:text-slate-600 rounded-lg"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
            <form method="POST" action="{{ route('departemen.proker.store') }}" class="p-6 space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Nama Program Kerja</label>
                        <input type="text" name="nama_proker" required class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    @if(Auth::user()->isAdmin())
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Departemen</label>
                        <select name="departemen_id" required class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach($departemens as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->nama_departemen }}</option>
                            @endforeach
                        </select>
                    </div>
                    @else
                    <input type="hidden" name="departemen_id" value="{{ Auth::user()->departemen_id }}">
                    @endif
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">PIC</label>
                        <input type="text" name="pic" required class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Status</label>
                        <select name="status" class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @foreach(['Perencanaan','Berjalan','Selesai'] as $s)
                            <option>{{ $s }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" required class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" required class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Progress (%)</label>
                        <input type="number" name="progress" min="0" max="100" value="0" class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-slate-700 mb-1.5">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="showModal=false" class="px-4 py-2 text-sm text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50">Batal</button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium bg-blue-600 text-white rounded-xl hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
