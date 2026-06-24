@extends('layouts.app')
@section('title', 'Ajukan Peminjaman')
@section('page-title', 'Ajukan Peminjaman Inventaris')
@section('breadcrumb', 'Inventaris / Pengajuan Peminjaman / Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-indigo-50">
            <h2 class="font-semibold text-slate-800">Form Pengajuan Peminjaman</h2>
            <p class="text-xs text-slate-500 mt-0.5">Isi formulir berikut untuk mengajukan peminjaman inventaris organisasi</p>
        </div>

        <form method="POST" action="{{ route('inventaris.peminjaman.store') }}" class="p-6 space-y-5">
            @csrf

            {{-- Informasi Peminjam (read-only) --}}
            <div class="bg-blue-50 rounded-xl p-4">
                <p class="text-xs font-semibold text-blue-700 mb-2 uppercase tracking-wide">Informasi Peminjam</p>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                        <p class="text-xs text-blue-600">Nama</p>
                        <p class="font-medium text-slate-800">{{ Auth::user()->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-blue-600">Departemen</p>
                        <p class="font-medium text-slate-800">{{ $departemen->nama_departemen ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-blue-600">Jabatan</p>
                        <p class="font-medium text-slate-800">{{ Auth::user()->jabatan }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-blue-600">NIM</p>
                        <p class="font-medium text-slate-800">{{ Auth::user()->nim }}</p>
                    </div>
                </div>
            </div>

            {{-- Pilih Barang --}}
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-2">
                    Barang yang Dipinjam <span class="text-red-500">*</span>
                </label>
                <select name="inventaris_id" required
                        class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                    <option value="">-- Pilih Barang --</option>
                    @foreach($inventarisTersedia as $inv)
                    <option value="{{ $inv->id }}" {{ old('inventaris_id') == $inv->id ? 'selected' : '' }}>
                        {{ $inv->nama_barang }} — {{ $inv->kategori }} (Stok: {{ $inv->jumlah }})
                    </option>
                    @endforeach
                </select>
                @error('inventaris_id')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Jumlah --}}
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-2">
                    Jumlah Dipinjam <span class="text-red-500">*</span>
                </label>
                <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" required
                       class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('jumlah')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Tanggal --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2">
                        Tanggal Pinjam <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}"
                           min="{{ now()->toDateString() }}" required
                           class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('tanggal_pinjam')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2">
                        Tanggal Kembali <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}" required
                           class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('tanggal_kembali')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Alasan --}}
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-2">
                    Keperluan / Alasan Peminjaman <span class="text-red-500">*</span>
                </label>
                <textarea name="alasan" rows="4" required
                          placeholder="Jelaskan keperluan peminjaman barang ini secara singkat dan jelas..."
                          class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('alasan') }}</textarea>
                @error('alasan')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            {{-- Info --}}
            <div class="flex items-start gap-2.5 p-3.5 bg-yellow-50 border border-yellow-100 rounded-xl">
                <svg class="w-4 h-4 text-yellow-600 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
                </svg>
                <p class="text-xs text-yellow-700">Pengajuan akan ditinjau oleh <strong>Admin Utama</strong> atau <strong>Kepala Departemen Inventaris</strong>. Harap menunggu konfirmasi sebelum mengambil barang.</p>
            </div>

            {{-- Actions --}}
            <div class="flex gap-3 pt-2">
                <a href="{{ route('inventaris.peminjaman') }}"
                   class="flex-1 py-2.5 text-center text-sm font-medium text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition">
                    Batal
                </a>
                <button type="submit"
                        class="flex-1 py-2.5 text-sm font-medium bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                    Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
