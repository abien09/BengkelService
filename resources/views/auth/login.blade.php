@extends('layouts.app')

<!-- Mengaktifkan Mode Gelap Full Page -->
@section('dark_theme', true)

@section('content')
<div class="py-6 flex items-center justify-center">
    
    <!-- Card Utama Split-Screen -->
    <div class="w-full max-w-4xl bg-neutral-900 rounded-3xl border border-zinc-800 overflow-hidden shadow-2xl grid grid-cols-1 lg:grid-cols-12 min-h-[520px]">
        
        <!-- Sisi Kiri: Foto Studio dengan Overlay Gelap Transparan -->
        <div class="lg:col-span-5 relative min-h-[300px] lg:min-h-[520px] flex flex-col justify-between p-8 md:p-10 border-b lg:border-b-0 lg:border-r border-zinc-800">
            <!-- Foto Background Studio -->
            <img src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=600&q=80" alt="Repair Studio" class="absolute inset-0 w-full h-full object-cover">
            
            <!-- Layer Overlay Gelap Transparan -->
            <div class="absolute inset-0 bg-neutral-950/80 bg-gradient-to-t from-neutral-950 via-neutral-950/70 to-neutral-950/50"></div>
            
            <!-- Teks Informasi Panel Kiri -->
            <div class="space-y-6 relative z-10">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                    <span class="text-xs font-mono font-bold uppercase tracking-wider text-red-500">[ ACCESS PORTAL ]</span>
                </div>
                <div>
                    <span class="text-stone-400 text-xs font-mono block mb-1">01 / MASUK SISTEM</span>
                    <h2 class="text-3xl font-black leading-tight text-stone-100">Ada yang mau diperbaiki?</h2>
                </div>
                <p class="text-xs text-stone-300 leading-relaxed">
                    Masuk ke portal Anda untuk memantau linimasa pengerjaan teknisi, menyetujui komponen tambahan, dan melunasi tagihan secara transparan.
                </p>
            </div>

            <!-- Quote Bawah -->
            <div class="pt-8 border-t border-zinc-800/80 relative z-10 space-y-1">
                <div class="text-[10px] font-mono text-red-500 font-bold uppercase tracking-widest">PRINSIP STUDIO</div>
                <div class="text-xs font-medium text-stone-200 italic">"Diagnosis teliti. Keputusan tetap di tanganmu."</div>
            </div>
        </div>

        <!-- Sisi Kanan: Form Input Berwarna Putih -->
        <div class="lg:col-span-7 p-8 md:p-10 flex flex-col justify-between bg-white text-slate-900">
            <div class="space-y-6">
                <!-- Header Form -->
                <div>
                    <h1 class="text-2xl font-black text-slate-900">Selamat Datang Kembali</h1>
                    <p class="text-xs text-slate-500 mt-1">Masukkan alamat email dan kata sandi akun Anda untuk melanjutkan.</p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">
                            Alamat Email <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm">✉️</span>
                            <input type="email" name="email" id="email" placeholder="nama@email.com" required value="{{ old('email') }}" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-600/20 focus:outline-none transition">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">
                            Kata Sandi <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 text-sm">🔒</span>
                            <input type="password" name="password" id="password" placeholder="••••••••" required class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-600/20 focus:outline-none transition">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-md shadow-red-600/20 transition cursor-pointer flex items-center justify-center gap-2">
                            <span>Masuk ke Portal System</span>
                            <span>➔</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer Link -->
            <div class="pt-6 mt-6 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-500">
                    Belum memiliki akun pelanggan? 
                    <a href="{{ route('register') }}" class="text-red-600 font-bold hover:underline transition">Daftar sekarang di sini</a>
                </p>
            </div>
        </div>

    </div>
</div>
@endsection