@extends('layouts.app')
@section('title', 'Presensi ' . $rapat->nama_rapat)
@section('page-title', 'Presensi Rapat')
@section('breadcrumb', 'Rapat Akbar / ' . $rapat->nama_rapat . ' / Presensi')

@section('content')
<div class="space-y-6">
    {{-- Rapat Info --}}
    <div class="bg-white rounded-2xl p-5 shadow-sm border border-slate-100">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="font-semibold text-slate-800">{{ $rapat->nama_rapat }}</h2>
                <p class="text-sm text-slate-500 mt-0.5">{{ $rapat->tanggal->translatedFormat('l, d F Y') }} · {{ $rapat->waktu }} WIB · {{ $rapat->lokasi }}</p>
            </div>
            <a href="{{ route('rapat.show', $rapat) }}" class="text-sm text-blue-600 hover:underline">← Kembali ke detail</a>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        {{-- Form Presensi --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100">
            <h3 class="text-sm font-semibold text-slate-800 mb-4">Isi Presensi Saya</h3>
            @if($userPresensi)
            <div class="mb-4 p-3 bg-slate-50 rounded-xl">
                <p class="text-xs text-slate-500">Status saat ini:</p>
                <span class="inline-flex mt-1 px-2.5 py-1 rounded-full text-xs font-medium {{ $userPresensi->getStatusBadgeClass() }}">{{ $userPresensi->status }}</span>
            </div>
            @endif
            <form method="POST" action="{{ route('rapat.presensi.isi', $rapat) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-2">Status Kehadiran</label>
                    <div class="space-y-2">
                        @foreach(['Hadir' => 'bg-green-50 border-green-200 text-green-700', 'Izin' => 'bg-yellow-50 border-yellow-200 text-yellow-700', 'Tidak Hadir' => 'bg-red-50 border-red-200 text-red-700'] as $status => $cls)
                        <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:bg-slate-50 transition {{ ($userPresensi && $userPresensi->status === $status) ? $cls : 'border-slate-200' }}">
                            <input type="radio" name="status" value="{{ $status }}"
                                   {{ $userPresensi && $userPresensi->status === $status ? 'checked' : '' }}
                                   class="w-4 h-4 text-blue-600">
                            <span class="text-sm font-medium text-slate-700">{{ $status }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Keterangan (opsional)</label>
                    <textarea name="keterangan" rows="2" placeholder="Tulis keterangan jika tidak hadir/izin..."
                              class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ $userPresensi?->keterangan }}</textarea>
                </div>
                <button type="submit" class="w-full py-2.5 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition">
                    Simpan Presensi
                </button>
            </form>
        </div>

        {{-- Daftar Presensi --}}
        <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <h3 class="text-sm font-semibold text-slate-800">Daftar Kehadiran ({{ $presensis->count() }} peserta)</h3>
                <div class="flex items-center gap-3 text-xs">
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-green-500"></span>Hadir: {{ $presensis->where('status','Hadir')->count() }}</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-yellow-400"></span>Izin: {{ $presensis->where('status','Izin')->count() }}</span>
                    <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-red-400"></span>Absen: {{ $presensis->where('status','Tidak Hadir')->count() }}</span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="text-left px-6 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Anggota</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider hidden sm:table-cell">Departemen</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="text-left px-4 py-3 text-xs font-semibold text-slate-500 uppercase tracking-wider hidden md:table-cell">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($presensis as $p)
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-6 py-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center text-[10px] font-bold text-blue-700">
                                        {{ strtoupper(substr($p->user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-slate-700">{{ $p->user->name }}</p>
                                        <p class="text-[10px] text-slate-400">{{ $p->user->nim }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 hidden sm:table-cell text-xs text-slate-600">{{ $p->user->departemen->nama_departemen ?? '-' }}</td>
                            <td class="px-4 py-3">
                                @if(Auth::user()->isAdmin())
                                <form method="POST" action="{{ route('rapat.presensi.update', [$rapat, $p]) }}">
                                    @csrf @method('PATCH')
                                    <select name="status" onchange="this.form.submit()"
                                            class="text-xs border border-slate-200 rounded-lg px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-500">
                                        @foreach(['Hadir','Izin','Tidak Hadir'] as $s)
                                        <option value="{{ $s }}" {{ $p->status === $s ? 'selected' : '' }}>{{ $s }}</option>
                                        @endforeach
                                    </select>
                                </form>
                                @else
                                <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-medium {{ $p->getStatusBadgeClass() }}">{{ $p->status }}</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 hidden md:table-cell text-xs text-slate-500">{{ $p->keterangan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
