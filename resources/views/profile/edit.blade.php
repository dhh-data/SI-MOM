@extends('layouts.app')
@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('breadcrumb', 'Pengaturan akun dan keamanan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    {{-- Update Profile --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-sm font-semibold text-slate-800 mb-1">Informasi Profil</h3>
        <p class="text-xs text-slate-500 mb-5">Perbarui nama dan email akun kamu.</p>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('patch')

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                       class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('email')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition">
                    Simpan Perubahan
                </button>
                @if(session('status') === 'profile-updated')
                <span class="text-xs text-green-600 font-medium">✓ Tersimpan!</span>
                @endif
            </div>
        </form>
    </div>

    {{-- Update Password --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-sm font-semibold text-slate-800 mb-1">Ubah Kata Sandi</h3>
        <p class="text-xs text-slate-500 mb-5">Pastikan akun kamu menggunakan kata sandi yang kuat.</p>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            @method('put')

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi Saat Ini</label>
                <input type="password" name="current_password" autocomplete="current-password"
                       class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('current_password', 'updatePassword')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kata Sandi Baru</label>
                <input type="password" name="password" autocomplete="new-password"
                       class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password', 'updatePassword')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="password_confirmation" autocomplete="new-password"
                       class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password_confirmation', 'updatePassword')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-xl hover:bg-blue-700 transition">
                    Ubah Kata Sandi
                </button>
                @if(session('status') === 'password-updated')
                <span class="text-xs text-green-600 font-medium">✓ Kata sandi diperbarui!</span>
                @endif
            </div>
        </form>
    </div>

    {{-- Delete Account --}}
    <div class="bg-white rounded-2xl shadow-sm border border-red-100 p-6">
        <h3 class="text-sm font-semibold text-red-600 mb-1">Hapus Akun</h3>
        <p class="text-xs text-slate-500 mb-5">Setelah akun dihapus, semua data akan hilang permanen.</p>

        <div x-data="{ confirm: false }">
            <button @click="confirm = true"
                    class="px-5 py-2.5 bg-red-600 text-white text-sm font-medium rounded-xl hover:bg-red-700 transition">
                Hapus Akun Saya
            </button>

            {{-- Confirm Modal --}}
            <div x-show="confirm"
                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                 x-transition.opacity>
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6" @click.away="confirm = false">
                    <h4 class="font-semibold text-slate-800 mb-2">Yakin ingin hapus akun?</h4>
                    <p class="text-sm text-slate-500 mb-5">Tindakan ini tidak dapat dibatalkan. Semua data akan hilang permanen.</p>

                    <form method="POST" action="{{ route('profile.destroy') }}">
                        @csrf