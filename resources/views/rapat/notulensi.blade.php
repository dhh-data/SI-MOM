@extends('layouts.app')
@section('title', 'Notulensi Rapat')
@section('page-title', 'Notulensi Rapat')
@section('breadcrumb', 'Rapat Akbar / ' . $rapat->nama_rapat . ' / Notulensi')

@push('styles')
<style>
    .ck-editor__editable { min-height: 300px; font-size: 14px; }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-semibold text-slate-700">{{ $rapat->nama_rapat }}</h2>
            <p class="text-sm text-slate-500">{{ $rapat->tanggal->translatedFormat('l, d F Y') }}</p>
        </div>
        <a href="{{ route('rapat.show', $rapat) }}" class="text-sm text-blue-600 hover:underline">← Kembali</a>
    </div>

    @if($notulensi && !request()->has('edit'))
    {{-- View Mode --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h3 class="font-semibold text-slate-800">{{ $notulensi->judul_notulensi }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">
                    Ditulis oleh <span class="font-medium">{{ $notulensi->penulis->name }}</span> ·
                    {{ $notulensi->tanggal->translatedFormat('d F Y') }}
                </p>
            </div>
            @if(Auth::user()->isAdmin() || Auth::user()->isKepalaDepartemen())
            <a href="?edit=1" class="px-3.5 py-2 text-sm text-blue-600 bg-blue-50 rounded-xl hover:bg-blue-100 transition">Edit</a>
            @endif
        </div>
        <div class="px-6 py-6 prose prose-sm max-w-none text-slate-700">
            {!! $notulensi->isi_notulensi !!}
        </div>
    </div>

    @elseif(Auth::user()->isAdmin() || Auth::user()->isKepalaDepartemen())
    {{-- Edit / Create Mode --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100">
            <h3 class="font-semibold text-slate-800">{{ $notulensi ? 'Edit' : 'Buat' }} Notulensi</h3>
        </div>
        <form method="POST" action="{{ route('rapat.notulensi.store', $rapat) }}" class="p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1.5">Judul Notulensi</label>
                <input type="text" name="judul_notulensi" value="{{ $notulensi?->judul_notulensi ?? 'Notulensi ' . $rapat->nama_rapat }}" required
                       class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1.5">Tanggal</label>
                <input type="date" name="tanggal" value="{{ $notulensi?->tanggal?->format('Y-m-d') ?? $rapat->tanggal->format('Y-m-d') }}" required
                       class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-700 mb-1.5">Isi Notulensi</label>
                <textarea id="notulensi-editor" name="isi_notulensi" class="w-full border border-slate-200 rounded-xl">{{ $notulensi?->isi_notulensi }}</textarea>
            </div>
            <div class="flex justify-end gap-3">
                <a href="{{ route('rapat.notulensi', $rapat) }}" class="px-4 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition">Simpan Notulensi</button>
            </div>
        </form>
    </div>

    @else
    <div class="bg-white rounded-2xl p-12 shadow-sm border border-slate-100 text-center text-slate-400">
        <svg class="w-12 h-12 mx-auto mb-2 opacity-30" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/></svg>
        <p class="text-sm">Notulensi belum tersedia</p>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#notulensi-editor'), {
        toolbar: {
            items: ['heading','|','bold','italic','underline','|','bulletedList','numberedList','|','blockQuote','insertTable','|','undo','redo']
        }
    }).catch(console.error);
</script>
@endpush
