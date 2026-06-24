@extends('layouts.app')
@section('title', isset($rapat) ? 'Edit Rapat' : 'Buat Rapat Akbar')
@section('page-title', isset($rapat) ? 'Edit Rapat Akbar' : 'Buat Rapat Akbar Baru')
@section('breadcrumb', 'Rapat Akbar / ' . (isset($rapat) ? 'Edit' : 'Buat Baru'))

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100">
            <h2 class="font-semibold text-slate-800">{{ isset($rapat) ? 'Edit Data Rapat' : 'Form Rapat Akbar Baru' }}</h2>
        </div>
        <form method="POST"
              action="{{ isset($rapat) ? route('rapat.update', $rapat) : route('rapat.store') }}"
              class="p-6 space-y-5">
            @csrf
            @if(isset($rapat)) @method('PUT') @endif

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Rapat <span class="text-red-500">*</span></label>
                <input type="text" name="nama_rapat" value="{{ old('nama_rapat', $rapat->nama_rapat ?? '') }}" required
                       placeholder="Contoh: Rapat Akbar Evaluasi Semester I"
                       class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('nama_rapat')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', isset($rapat) ? $rapat->tanggal->format('Y-m-d') : '') }}" required
                           class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Waktu <span class="text-red-500">*</span></label>
                    <input type="time" name="waktu" value="{{ old('waktu', $rapat->waktu ?? '') }}" required
                           class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Lokasi <span class="text-red-500">*</span></label>
                <input type="text" name="lokasi" value="{{ old('lokasi', $rapat->lokasi ?? '') }}" required
                       placeholder="Contoh: Aula Gedung A Lt. 3"
                       class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status</label>
                <select name="status" class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach(['Dijadwalkan','Berlangsung','Selesai','Dibatalkan'] as $s)
                    <option value="{{ $s }}" {{ old('status', $rapat->status ?? 'Dijadwalkan') === $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Agenda Rapat <span class="text-red-500">*</span></label>
                <textarea name="agenda" rows="5" required
                          placeholder="1. Pembukaan&#10;2. Laporan per departemen&#10;3. Diskusi&#10;4. Penutup"
                          class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('agenda', $rapat->agenda ?? '') }}</textarea>
                @error('agenda')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('rapat.index') }}" class="flex-1 py-2.5 text-center text-sm font-medium text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition">Batal</a>
                <button type="submit" class="flex-1 py-2.5 text-sm font-medium bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                    {{ isset($rapat) ? 'Perbarui Rapat' : 'Buat Rapat' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
