@extends('layouts.app')
@section('title', 'Upload Berkas')
@section('page-title', 'Upload Berkas')
@section('breadcrumb', 'Berkas / Upload')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100">
            <h2 class="font-semibold text-slate-800">Upload Berkas Baru</h2>
            <p class="text-xs text-slate-500 mt-0.5">Unggah dokumen organisasi ke sistem arsip digital</p>
        </div>

        <form method="POST" action="{{ route('berkas.store') }}" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Judul Berkas <span class="text-red-500">*</span></label>
                <input type="text" name="judul_berkas" value="{{ old('judul_berkas') }}" required
                       placeholder="Masukkan judul dokumen..."
                       class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('judul_berkas')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-5 gap-2">
                    @php
                    $katIcons = ['Proposal'=>'📋','LPJ'=>'📊','Notulen'=>'📝','Surat'=>'✉️','Dokumentasi'=>'📁'];
                    $katColors = ['Proposal'=>'border-blue-300 bg-blue-50 text-blue-700','LPJ'=>'border-blue-300 bg-blue-50 text-blue-700','Notulen'=>'border-blue-300 bg-blue-50 text-blue-700','Surat'=>'border-blue-300 bg-blue-50 text-blue-700','Dokumentasi'=>'border-blue-300 bg-blue-50 text-blue-700'];
                    @endphp
                    @foreach($katIcons as $kat => $icon)
                    <label class="cursor-pointer">
                        <input type="radio" name="kategori" value="{{ $kat }}" class="sr-only peer" {{ old('kategori') === $kat ? 'checked' : '' }}>
                        <div class="border-2 border-slate-200 rounded-xl p-3 text-center text-xs font-medium text-slate-500 hover:border-blue-300 transition peer-checked:{{ $katColors[$kat] }} peer-checked:border-2">
                            <div class="text-xl mb-1">{{ $icon }}</div>
                            {{ $kat }}
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('kategori')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                          placeholder="Deskripsi singkat tentang isi dokumen ini..."
                          class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none">{{ old('deskripsi') }}</textarea>
            </div>

            {{-- File Upload --}}
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">File Dokumen <span class="text-red-500">*</span></label>
                <div class="relative border-2 border-dashed border-slate-200 rounded-xl p-8 text-center hover:border-blue-300 transition"
                     x-data="{ fileName: '' }"
                     @dragover.prevent
                     @drop.prevent="fileName = $event.dataTransfer.files[0]?.name">
                    <input type="file" name="file" required
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                           @change="fileName = $event.target.files[0]?.name"
                           accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.zip,.rar">
                    <div x-show="!fileName">
                        <svg class="w-10 h-10 mx-auto mb-2 text-slate-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                        </svg>
                        <p class="text-sm font-medium text-slate-600">Klik atau drag & drop file di sini</p>
                        <p class="text-xs text-slate-400 mt-1">PDF, DOC, XLS, PPT, JPG, PNG, ZIP (Maks. 20 MB)</p>
                    </div>
                    <div x-show="fileName" class="text-sm font-medium text-blue-600">
                        📄 <span x-text="fileName"></span>
                    </div>
                </div>
                @error('file')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('berkas.index') }}" class="flex-1 py-2.5 text-center text-sm font-medium text-slate-600 bg-slate-100 rounded-xl hover:bg-slate-200 transition">Batal</a>
                <button type="submit" class="flex-1 py-2.5 text-sm font-medium bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">Upload Berkas</button>
            </div>
        </form>
    </div>
</div>
@endsection
