@extends('layouts.app')
@section('title', 'Data Anggota')
@section('page-title', 'Data Anggota')
@section('breadcrumb', 'Departemen & Anggota / Data Anggota')

@section('content')
<div class="space-y-5">
    {{-- Sub Nav --}}
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('departemen.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-white text-slate-600 border border-slate-200 hover:bg-slate-50">Departemen</a>
        <a href="{{ route('departemen.anggota') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-blue-600 text-white shadow-sm">Data Anggota</a>
        <a href="{{ route('departemen.proker') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-white text-slate-600 border border-slate-200 hover:bg-slate-50">Program Kerja</a>
    </div>

    {{-- Toolbar --}}
    <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center justify-between">
        <form method="GET" action="{{ route('departemen.anggota') }}" class="flex flex-wrap gap-2 flex-1">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama / NIM / email..."
                   class="flex-1 min-w-0 max-w-xs px-3.5 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            @if(Auth::user()->isAdmin())
            <select name="departemen" class="px-3 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Departemen</option>
                @foreach($departemens as $dep)
                <option value="{{ $dep->id }}" {{ $departemenFilter == $dep->id ? 'selected' : '' }}>{{ $dep->nama_departemen }}</option>
                @endforeach
            </select>
            @endif
            <select name="jabatan" class="px-3 py-2 text-sm bg-white border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Jabatan</option>
                @foreach(['Ketua Umum','Sekretaris','Kepala Departemen','Staff'] as $j)
                <option value="{{ $j }}" {{ $jabatanFilter == $j ? 'selected' : '' }}>{{ $j }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition">Cari</button>
        </form>
        @if(Auth::user()->isAdmin())
        <a href="{{ route('departemen.anggota.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Anggota
        </a>
        @endif
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="text-left px-6 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Anggota</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">NIM</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider hidden md:table-cell">Departemen</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider hidden lg:table-cell">Angkatan</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Jabatan</th>
                        <th class="text-left px-4 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider">Role</th>
                        @if(Auth::user()->isAdmin())
                        <th class="px-4 py-3.5 text-xs font-semibold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($anggota as $a)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-xs font-bold text-blue-700 shrink-0">
                                    {{ strtoupper(substr($a->name, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="font-medium text-slate-800 text-sm">{{ $a->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $a->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3.5 text-slate-600 text-sm font-mono">{{ $a->nim }}</td>
                        <td class="px-4 py-3.5 hidden md:table-cell">
                            <span class="text-sm text-slate-600">{{ $a->departemen->nama_departemen ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-3.5 hidden lg:table-cell text-slate-600 text-sm">{{ $a->angkatan }}</td>
                        <td class="px-4 py-3.5">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">{{ $a->jabatan }}</span>
                        </td>
                        <td class="px-4 py-3.5">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium {{ $a->getRoleBadgeClass() }}">{{ $a->getRoleLabel() }}</span>
                        </td>
                        @if(Auth::user()->isAdmin())
                        <td class="px-4 py-3.5">
                            <div class="flex items-center justify-center gap-1">
                                <form method="POST" action="{{ route('departemen.anggota.destroy', $a) }}"
                                      onsubmit="return confirm('Yakin hapus anggota ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
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
                            <svg class="w-10 h-10 mx-auto mb-2 opacity-30" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                            <p class="text-sm">Tidak ada anggota ditemukan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($anggota->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">{{ $anggota->links() }}</div>
        @endif
    </div>
</div>
@endsection
