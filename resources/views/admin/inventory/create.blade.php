@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Breadcrumb Navigasi -->
    <div>
        <a href="{{ route('admin.inventory.index') }}" class="text-xs font-semibold text-slate-500 hover:text-red-600 transition flex items-center gap-1 w-fit">
            <span>←</span>
            <span>Kembali ke Stok Inventori</span>
        </a>
    </div>

    <!-- Form Card Container -->
    <div class="bg-white p-8 md:p-10 rounded-2xl border border-slate-200 shadow-xs space-y-8">
        <!-- Header Form -->
        <div class="border-b border-slate-100 pb-6">
            <div class="flex items-center gap-2 mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                <span class="text-xs font-mono font-bold uppercase tracking-wider text-red-600">[ STOK SUKU CADANG ]</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900">Tambah Part / Sparepart Baru</h1>
            <p class="text-sm text-slate-500 mt-1">Daftarkan item komponen fisik ke inventori bengkel untuk mendukung penetapan Root Cause dan pengerjaan teknisi.</p>
        </div>

        <form action="{{ route('admin.inventory.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Input: Nama Part -->
            <div>
                <label for="nama_part" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">
                    Nama Part / Sparepart <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_part" id="nama_part" placeholder="Contoh: LCD Samsung A50, Kipas Asus ROG, SSD NVMe 512GB" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Input: Peruntukan Perangkat -->
                <div>
                    <label for="device_type" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">
                        Peruntukan Perangkat <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select name="device_type" id="device_type" required class="w-full pl-4 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition appearance-none cursor-pointer">
                            <option value="" disabled selected>-- Pilih Perangkat --</option>
                            <option value="HP">📱 HP / Smartphone</option>
                            <option value="Laptop">💻 Laptop</option>
                            <option value="PC">🖥️ PC (Komputer)</option>
                            <option value="Monitor">🖥️ Monitor</option>
                            <option value="Tablet">📟 Tablet</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400 text-xs">
                            ▼
                        </div>
                    </div>
                </div>

                <!-- Input: Jenis / Kategori Part -->
                <div>
                    <label for="jenis" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">
                        Jenis / Kategori Part <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="jenis" id="jenis" placeholder="Contoh: LCD, Kipas, Baterai, Thermal Paste" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Input: Jumlah Stok Awal -->
                <div>
                    <label for="stok" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">
                        Jumlah Stok Awal <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stok" id="stok" min="0" placeholder="0" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition">
                </div>

                <!-- Input: Harga Satuan -->
                <div>
                    <label for="harga_satuan" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">
                        Harga Satuan (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center font-bold text-slate-400 text-xs font-mono">Rp</span>
                        <input type="number" name="harga_satuan" id="harga_satuan" min="0" placeholder="50000" required class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-mono text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition">
                    </div>
                </div>
            </div>

            <!-- Info Box Aturan Sistem -->
            <div class="p-4 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-500 flex items-start gap-2.5">
                <span class="text-sm">💡</span>
                <p class="leading-relaxed">
                    <strong class="text-slate-800">Aturan Pengurangan Otomatis:</strong> Begitu teknisi menetapkan part ini sebagai Root Cause atau Primary Cause pada suatu proses perbaikan, jumlah stok akan terpotong secara otomatis oleh sistem.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-slate-100 flex flex-col-reverse md:flex-row items-center justify-end gap-3">
                <a href="{{ route('admin.inventory.index') }}" class="w-full md:w-auto px-6 py-3 text-sm font-semibold text-slate-500 hover:text-slate-800 bg-transparent hover:bg-slate-100 rounded-xl transition text-center">
                    Batal
                </a>
                <button type="submit" class="w-full md:w-auto px-8 py-3 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl shadow-md shadow-red-600/20 transition cursor-pointer flex items-center justify-center gap-2">
                    <span>Simpan Part Baru</span>
                    <span>✓</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection