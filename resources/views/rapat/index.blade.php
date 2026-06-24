@extends('layouts.app')
@section('title', 'Rapat Akbar')
@section('page-title', 'Rapat Akbar')
@section('breadcrumb', 'Daftar rapat akbar organisasi')

@section('content')
<div class="space-y-5">
    <div class="flex items-center justify-between">
        <p class="text-sm text-slate-500">Total <span class="font-semibold text-slate-700">{{ $rapats->total() }}</span> rapat</p>
        @if(Auth::user()->isAdmin())
        <a href="{{ route('rapat.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Buat Rapat
        </a>
        @endif
    </div>

    <div class="space-y-3">
        @forelse($rapats as $rapat)
        @php
        $statusColors = [
            'Dijadwalkan' => 'bg-blue-50 border-blue-100',
            'Berlangsung' => 'bg-green-50 border-green-100',
            'Selesai'     => 'bg-slate-50 border-slate-100',
            'Dibatalkan'  => 'bg-red-50 border-red-100',
        ];
        $bg = $statusColors[$rapat->status] ?? 'bg-white border-slate-100';
        @endphp
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow overflow-hidden">
            <div class="flex flex-col md:flex-row md:items-center gap-4 p-5">
                {{-- Date box --}}
                <div class="text-center bg-blue-50 rounded-xl px-4 py-3 md:w-20 shrink-0">
                    <p class="text-xs font-medium text-blue-500 uppercase">{{ $rapat->tanggal->translatedFormat('M') }}</p>
                    <p class="text-2xl font-bold text-blue-700 leading-none">{{ $rapat->tanggal->format('d') }}</p>
                    <p class="text-xs text-blue-400">{{ $rapat->tanggal->format('Y') }}</p>
                </div>
                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h3 class="font-semibold text-slate-800">{{ $rapat->nama_rapat }}</h3>
                        <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-medium {{ $rapat->getStatusBadgeClass() }}">{{ $rapat->status }}</span>
                    </div>
                    <div class="flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-500">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $rapat->waktu }} WIB
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                            {{ $rapat->lokasi }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                            {{ $rapat->presensis_count }} peserta
                        </span>
                    </div>
                </div>
                {{-- Actions --}}
                <div class="flex items-center gap-2 shrink-0">
                    <a href="{{ route('rapat.show', $rapat) }}"
                       class="px-3.5 py-2 text-xs font-medium text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition">
                        Detail
                    </a>
                    <a href="{{ route('rapat.presensi', $rapat) }}"
                       class="px-3.5 py-2 text-xs font-medium text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition">
                        Presensi
                    </a>
                    @if(Auth::user()->isAdmin())
                    <a href="{{ route('rapat.edit', $rapat) }}"
                       class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
                    </a>
                    <form method="POST" action="{{ route('rapat.destroy', $rapat) }}" onsubmit="return confirm('Hapus rapat ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/></svg>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 py-16 text-center text-slate-400">
            <svg class="w-12 h-12 mx-auto mb-2 opacity-30" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5"/></svg>
            <p>Belum ada rapat akbar</p>
        </div>
        @endforelse
    </div>
    @if($rapats->hasPages())
    <div>{{ $rapats->links() }}</div>
    @endif
</div>
@endsection
