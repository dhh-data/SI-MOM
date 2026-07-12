@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto pb-12">
    
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <div class="p-3 bg-blue-600 rounded-2xl shadow-lg shadow-blue-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="id-badge" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Pengaturan Profil</h2>
                <p class="text-sm text-slate-500">Kelola informasi akun dan keamanan kata sandi Anda</p>
            </div>
        </div>
        
        <a href="{{ url()->previous() }}" class="group flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span class="text-sm font-medium">Kembali</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="md:col-span-1">
            <h3 class="text-lg font-semibold text-slate-800">Informasi Pribadi</h3>
            <p class="mt-1 text-sm text-slate-500">Pastikan alamat email Anda aktif untuk menerima notifikasi sistem.</p>
        </div>

        <div class="md:col-span-2">
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-100/50 border border-slate-100 overflow-hidden">
                <div class="p-8">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        <div class="md:col-span-1 pt-8 border-t border-slate-100">
            <h3 class="text-lg font-semibold text-slate-800">Keamanan Akun</h3>
            <p class="mt-1 text-sm text-slate-500">Gunakan kombinasi kata sandi yang kuat untuk menjaga akun tetap aman.</p>
        </div>

        <div class="md:col-span-2 pt-8 border-t border-slate-100">
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-100/50 border border-slate-100 overflow-hidden">
                <div class="p-8">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        @if (isset($display_delete) && $display_delete)
        <div class="md:col-span-1 pt-8 border-t border-slate-100">
            <h3 class="text-lg font-semibold text-red-600">Hapus Akun</h3>
            <p class="mt-1 text-sm text-slate-500">Setelah akun dihapus, semua data akan hilang secara permanen.</p>
        </div>
        <div class="md:col-span-2 pt-8 border-t border-slate-100">
            <div class="bg-white rounded-3xl shadow-sm border border-red-100 overflow-hidden">
                <div class="p-8">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
