@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Breadcrumb / Back Link -->
    <div class="mb-6">
        <a href="{{ route('pelanggan.device.index') }}" class="text-xs font-semibold text-slate-500 hover:text-red-600 transition flex items-center gap-1 w-fit">
            <span>←</span>
            <span>Kembali ke Daftar Perangkat</span>
        </a>
    </div>

    <div class="bg-white p-8 md:p-10 rounded-2xl border border-slate-200 shadow-xs space-y-8">
        <!-- Form Header -->
        <div class="border-b border-slate-100 pb-6">
            <h1 class="text-2xl font-black text-slate-900">Daftarkan Perangkat Baru</h1>
            <p class="text-sm text-slate-500 mt-2 leading-relaxed">
                Masukkan spesifikasi perangkat elektronik Anda dengan valid. Data ini akan memudahkan teknisi kami dalam menyiapkan komponen dasar *sparepart* sebelum Anda datang ke studio.
            </p>
        </div>

        <form action="{{ route('pelanggan.device.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Input: Jenis Perangkat -->
            <div>
                <label for="jenis" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Pilih Jenis Perangkat <span class="text-red-500">*</span></label>
                <div class="relative">
                    <select name="jenis" id="jenis" required class="w-full pl-4 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition appearance-none cursor-pointer">
                        <option value="" disabled selected>-- Pilih Kategori --</option>
                        <option value="HP">📱 HP / Smartphone</option>
                        <option value="Laptop">💻 Laptop</option>
                        <option value="PC">🖥️ PC (Komputer)</option>
                        <option value="Monitor">🖥️ Monitor</option>
                        <option value="Tablet">📟 Tablet</option>
                    </select>
                    <!-- Custom Arrow Icon for Select -->
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400">
                        ▼
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Input: Merek -->
                <div>
                    <label for="merek" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Merek <span class="text-red-500">*</span></label>
                    <input type="text" name="merek" id="merek" placeholder="Contoh: Samsung, Asus, Apple" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition">
                </div>

                <!-- Input: Model/Seri -->
                <div>
                    <label for="model" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Seri / Model <span class="text-red-500">*</span></label>
                    <input type="text" name="model" id="model" placeholder="Contoh: S23 Ultra, ROG G14" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition">
                </div>
            </div>

            <!-- Input: Warna -->
            <div>
                <label for="warna" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">Warna Dominan</label>
                <input type="text" name="warna" id="warna" placeholder="Contoh: Space Grey, Midnight Black" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition">
                <p class="text-[11px] text-slate-400 mt-1.5">Opsional. Membantu identifikasi fisik barang di ruang servis.</p>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 mt-6 border-t border-slate-100 flex flex-col-reverse md:flex-row items-center justify-end gap-3">
                <a href="{{ route('pelanggan.device.index') }}" class="w-full md:w-auto px-6 py-3 text-sm font-semibold text-slate-500 hover:text-slate-800 bg-transparent hover:bg-slate-100 rounded-xl transition text-center">
                    Batalkan
                </a>
                <button type="submit" class="w-full md:w-auto px-8 py-3 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl shadow-md shadow-red-600/20 transition cursor-pointer">
                    Simpan Perangkat
                </button>
            </div>
        </form>
    </div>
</div>
@endsection