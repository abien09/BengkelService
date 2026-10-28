@extends('layouts.app')

<!-- Mengaktifkan Mode Gelap Full Page -->
@section('dark_theme', true)

@section('content')
<div class="py-6 flex items-center justify-center">
    
    <!-- Card Utama Split-Screen -->
    <div class="w-full max-w-5xl bg-neutral-900 rounded-3xl border border-zinc-800 overflow-hidden shadow-2xl grid grid-cols-1 lg:grid-cols-12">
        
        <!-- Sisi Kiri: Foto Studio dengan Overlay Gelap Transparan -->
        <div class="lg:col-span-5 relative min-h-[340px] lg:min-h-[580px] flex flex-col justify-between p-8 md:p-10 border-b lg:border-b-0 lg:border-r border-zinc-800">
            <!-- Foto Background Studio -->
            <img src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=600&q=80" alt="Repair Studio" class="absolute inset-0 w-full h-full object-cover">
            
            <!-- Layer Overlay Gelap Transparan -->
            <div class="absolute inset-0 bg-neutral-950/80 bg-gradient-to-t from-neutral-950 via-neutral-950/70 to-neutral-950/50"></div>

            <!-- Teks Informasi Panel Kiri -->
            <div class="space-y-6 relative z-10">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                    <span class="text-xs font-mono font-bold uppercase tracking-wider text-red-500">[ NEW CLIENT REGISTRATION ]</span>
                </div>
                <div>
                    <span class="text-stone-400 text-xs font-mono block mb-1">02 / REGISTRASI PELANGGAN</span>
                    <h2 class="text-3xl font-black leading-tight text-stone-100">Beri perangkatmu kesempatan kedua.</h2>
                </div>
                
                <p class="text-xs text-stone-300 leading-relaxed">
                    Bergabung bersama BengkelService untuk menikmati kemudahan perawatan elektronik dengan alur kerja terstruktur dan transparan.
                </p>

                <!-- Keunggulan Layanan -->
                <div class="space-y-2 pt-2 text-xs text-stone-200">
                    <div class="flex items-center gap-2">
                        <span class="text-red-500 font-bold">✓</span>
                        <span>Support HP, Laptop, PC, Monitor & Tablet</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-red-500 font-bold">✓</span>
                        <span>Lacak progres pengerjaan real-time</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-red-500 font-bold">✓</span>
                        <span>Persetujuan biaya tambahan di tangan Anda</span>
                    </div>
                </div>
            </div>

            <!-- Info Brand Bawah -->
            <div class="pt-8 border-t border-zinc-800/80 relative z-10">
                <div class="text-[10px] font-mono text-red-500 font-bold uppercase tracking-widest">BENGKELSERVICE SYSTEM</div>
                <div class="text-[11px] text-stone-400 mt-0.5">Rawat yang ada. Hidupkan kembali perangkatmu.</div>
            </div>
        </div>

        <!-- Sisi Kanan: Form Input Berwarna Putih -->
        <div class="lg:col-span-7 p-8 md:p-10 bg-white text-slate-900 flex flex-col justify-between">
            <div class="space-y-6">
                <!-- Header Form -->
                <div>
                    <h1 class="text-2xl font-black text-slate-900">Daftarkan Akun Pelanggan</h1>
                    <p class="text-xs text-slate-500 mt-1">Lengkapi data identitas Anda untuk mencatatkan perangkat dan membuat reservasi.</p>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Nama Lengkap -->
                        <div>
                            <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" placeholder="Contoh: Budi Santoso" required value="{{ old('name') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-600/20 focus:outline-none transition">
                        </div>

                        <!-- No Telepon -->
                        <div>
                            <label for="no_telp" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                                No. Telepon / WhatsApp <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="no_telp" id="no_telp" placeholder="081234567890" required value="{{ old('no_telp') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-600/20 focus:outline-none transition">
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                            Alamat Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" placeholder="nama@email.com" required value="{{ old('email') }}" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-600/20 focus:outline-none transition">
                    </div>

                    <!-- Alamat Lengkap -->
                    <div>
                        <label for="alamat" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                            Alamat Lengkap
                        </label>
                        <textarea name="alamat" id="alamat" rows="2" placeholder="Masukkan alamat domisili Anda..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-600/20 focus:outline-none transition">{{ old('alamat') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Password Input -->
                        <div>
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                                Kata Sandi <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-600/20 focus:outline-none transition">
                        </div>

                        <!-- Password Confirmation -->
                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                                Konfirmasi Kata Sandi <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi kata sandi" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-600 focus:ring-2 focus:ring-red-600/20 focus:outline-none transition">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-3">
                        <button type="submit" class="w-full py-3.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-md shadow-red-600/20 transition cursor-pointer flex items-center justify-center gap-2">
                            <span>Buat Akun Pelanggan Sekarang</span>
                            <span>➔</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer Link -->
            <div class="pt-6 mt-6 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-500">
                    Sudah pernah mendaftar sebelumnya? 
                    <a href="{{ route('login') }}" class="text-red-600 font-bold hover:underline transition">Masuk di sini</a>
                </p>
            </div>
        </div>

    </div>
</div>
@endsection