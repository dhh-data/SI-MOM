@extends('layouts.app')
@section('title', isset($inventaris) ? 'Edit Inventaris' : 'Tambah Inventaris')
@section('page-title', isset($inventaris) ? 'Edit Data Inventaris' : 'Tambah Barang Inventaris')
@section('breadcrumb', 'Inventaris / ' . (isset($inventaris) ? 'Edit' : 'Tambah'))

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100">
            <h2 class="font-semibold text-slate-800">{{ isset($inventaris) ? 'Edit Data Barang' : 'Tambah Barang Baru' }}</h2>
        </div>
        <form method="POST"
              action="{{ isset($inventaris) ? route('inventaris.update', $inventaris) : route('inventaris.store') }}"
              class="p-6 space-y-5">
            @csrf
            @if(isset($inventaris)) @method('PUT') @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Barang <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_barang" value="{{ old('nama_barang', $inventaris->nama_barang ?? '') }}" required
                           class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('nama_barang')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                    <select name="kategori" required class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach(['Elektronik','Perlengkapan','Dokumentasi','ATK','Lainnya'] as $k)
                        <option value="{{ $k }}" {{ old('kategori', $inventaris->kategori ?? '') === $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jumlah <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah" value="{{ old('jumlah', $inventaris->jumlah ?? 1) }}" min="1" required
                           class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kondisi <span class="text-red-500">*</span></label>
                    <select name="kondisi" required class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach(['Baik','Rusak Ringan','Rusak Berat'] as $k)
                        <option value="{{ $k }}" {{ old('kondisi', $inventaris->kondisi ?? 'Baik') === $k ? 'selected' : '' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach(['Tersedia','Dipinjam','Maintenance'] as $s)
                        <option value="{{ $s }}" {{ old('status', $inventaris->status ?? 'Tersedia') === $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Lokasi Penyimpanan <span class="text-red-500">*</span></label>
                    <input type="text" name="lokasi_penyimpanan" value="{{ old('lokasi_penyimpanan', $inventaris->lokasi_penyimpanan ?? '') }}" required
                           placeholder="Contoh: Lemari A - Rak 1, Gudang Sekretariat"
                           class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                              class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('keterangan', $inventaris->keterangan ?? '') }}</textarea>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('inventaris.index') }}" class="flex-1 py-2.5 text-center text-sm font-medium text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition">Batal</a>
                <button type="submit" class="flex-1 py-2.5 text-sm font-medium bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                    {{ isset($inventaris) ? 'Perbarui Data' : 'Simpan Barang' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
