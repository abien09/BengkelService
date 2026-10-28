@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header & Navigasi -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                <span class="text-xs font-mono font-bold uppercase tracking-wider text-red-600">[ AKUN SAYA ]</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900">Pengaturan Profil & Keamanan</h1>
            <p class="text-xs text-slate-500 mt-0.5">Perbarui data identitas pribadi, kontak WhatsApp, dan kata sandi akun Anda.</p>
        </div>
        <a href="javascript:history.back()" class="text-xs font-semibold text-slate-500 hover:text-red-600 transition flex items-center gap-1">
            <span>←</span>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Layout Grid 2 Kolom -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Kolom Kiri: Form Informasi Profil Utama -->
        <div class="lg:col-span-7 bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-xs space-y-6">
            <div class="border-b border-slate-100 pb-4 flex items-center justify-between">
                <div>
                    <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Informasi Profil Utama</h2>
                    <p class="text-[11px] text-slate-400 mt-0.5">Data ini digunakan untuk verifikasi reservasi dan komunikasi teknisi.</p>
                </div>
                <span class="px-2.5 py-1 bg-red-50 text-red-700 font-mono text-[10px] font-bold rounded-full uppercase border border-red-200/60">
                    {{ Auth::user()->role ?? 'PELANGGAN' }}
                </span>
            </div>

            <form action="{{ route('profile.update') ?? '#' }}" method="POST" class="space-y-4">
                @csrf
                @method('PATCH')

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name ?? '') }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-600/20 focus:outline-none transition">
                </div>

                <!-- Email & No. HP -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                            Alamat Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email ?? '') }}" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-600/20 focus:outline-none transition">
                    </div>

                    <div>
                        <label for="no_telp" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                            No. Telepon / WhatsApp
                        </label>
                        <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp', Auth::user()->no_telp ?? '') }}" placeholder="081234567890" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-600/20 focus:outline-none transition">
                    </div>
                </div>

                <!-- Alamat Domisili -->
                <div>
                    <label for="alamat" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                        Alamat Domisili
                    </label>
                    <textarea name="alamat" id="alamat" rows="3" placeholder="Masukkan alamat domisili lengkap Anda..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-600/20 focus:outline-none transition">{{ old('alamat', Auth::user()->alamat ?? '') }}</textarea>
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-md shadow-red-600/20 transition cursor-pointer flex items-center gap-2">
                        <span>Simpan Perubahan Profil</span>
                        <span>✓</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Kolom Kanan: Form Keamanan Kata Sandi -->
        <div class="lg:col-span-5 bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-xs space-y-6">
            <div class="border-b border-slate-100 pb-4">
                <h2 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Keamanan Kata Sandi</h2>
                <p class="text-[11px] text-slate-400 mt-0.5">Gunakan kata sandi yang kuat untuk melindungi akun Anda.</p>
            </div>

            <form action="{{ route('password.update') ?? '#' }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Kata Sandi Saat Ini -->
                <div>
                    <label for="current_password" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                        Kata Sandi Saat Ini <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="current_password" id="current_password" placeholder="••••••••" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-600/20 focus:outline-none transition">
                </div>

                <!-- Kata Sandi Baru -->
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                        Kata Sandi Baru <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-600/20 focus:outline-none transition">
                </div>

                <!-- Konfirmasi Kata Sandi Baru -->
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                        Konfirmasi Kata Sandi Baru <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi kata sandi baru" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-600/20 focus:outline-none transition">
                </div>

                <div class="pt-3 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="w-full py-2.5 bg-slate-900 hover:bg-red-600 text-white text-xs font-bold rounded-xl shadow-xs transition cursor-pointer flex items-center justify-center gap-2">
                        <span>Perbarui Kata Sandi</span>
                        <span>🔒</span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection