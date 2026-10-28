@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    
    <!-- 1. Header Banner Dashboard -->
    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-2.5 h-2.5 rounded-full bg-red-600 animate-pulse"></span>
                <span class="text-xs font-mono font-bold uppercase tracking-wider text-red-600">[ PANEL ADMINISTRATOR OPERASIONAL ]</span>
            </div>
            <h1 class="text-3xl font-black text-slate-900">Pusat Kendali BengkelService</h1>
            <p class="text-sm text-slate-500 mt-1">Pantau antrean reservasi pelanggan, penugasan teknisi, ketersediaan suku cadang, dan validasi transaksi keuangan.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="text-right hidden sm:block font-mono text-xs text-slate-500">
                <div>{{ date('l, d F Y') }}</div>
                <div class="text-slate-900 font-bold">Studio Status: <span class="text-emerald-600">AKTIF / BUKA</span></div>
            </div>
        </div>
    </div>

    <!-- 2. Kartu Metrik Menggunakan Komponen Reusable -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <x-stat-card 
                title="Reservasi Baru" 
                :value="$totalReservations ?? 0" 
                subtitle="Menunggu penugasan" 
                icon="📥" 
                color="amber" 
            />

            <x-stat-card 
                title="Service Aktif" 
                :value="$activeServices ?? 0" 
                subtitle="Sedang dikerjakan teknisi" 
                icon="🛠️" 
                color="blue" 
            />

            <x-stat-card 
                title="Verifikasi Bayar" 
                :value="$pendingPayments ?? 0" 
                subtitle="Cek bukti transfer" 
                icon="💰" 
                color="red" 
            />

            <x-stat-card 
                title="Stok Part Kritis" 
                :value="$lowStockItems ?? 0" 
                subtitle="Perlu restock segera" 
                icon="📦" 
                color="emerald" 
            />
        </div>

    <!-- 3. Akses Menu Utama (Main Action Grid) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Action 1: Reservasi & Teknisi -->
        <div class="bg-white p-7 rounded-2xl border border-slate-200 shadow-xs hover:border-red-500 transition group flex flex-col justify-between">
            <div class="space-y-3">
                <div class="w-12 h-12 bg-slate-900 text-white rounded-xl flex items-center justify-center text-xl group-hover:bg-red-600 transition">
                    📋
                </div>
                <h3 class="text-lg font-bold text-slate-900">Reservasi & Penugasan Teknisi</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Kelola reservasi masuk dari pelanggan, verifikasi keluhan awal, dan tentukan teknisi yang bertanggung jawab.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.reservation.index') }}" class="text-xs font-bold text-red-600 group-hover:text-red-700 flex items-center gap-1">
                    <span>Kelola Reservasi</span>
                    <span>→</span>
                </a>
                <span class="text-[10px] font-mono px-2 py-0.5 bg-slate-100 text-slate-600 rounded">Antrean Utama</span>
            </div>
        </div>

        <!-- Action 2: Inventori & Sparepart -->
        <div class="bg-white p-7 rounded-2xl border border-slate-200 shadow-xs hover:border-red-500 transition group flex flex-col justify-between">
            <div class="space-y-3">
                <div class="w-12 h-12 bg-slate-900 text-white rounded-xl flex items-center justify-center text-xl group-hover:bg-red-600 transition">
                    🧩
                </div>
                <h3 class="text-lg font-bold text-slate-900">Stok Inventori & Suku Cadang</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Atur ketersediaan sparepart (HP, Laptop, PC, Monitor, Tablet), harga satuan, dan pemotongan stok otomatis.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.inventory.index') }}" class="text-xs font-bold text-red-600 group-hover:text-red-700 flex items-center gap-1">
                    <span>Kelola Inventori</span>
                    <span>→</span>
                </a>
                <span class="text-[10px] font-mono px-2 py-0.5 bg-slate-100 text-slate-600 rounded">Auto Deduct</span>
            </div>
        </div>

        <!-- Action 3: Verifikasi Keuangan -->
        <div class="bg-white p-7 rounded-2xl border border-slate-200 shadow-xs hover:border-red-500 transition group flex flex-col justify-between">
            <div class="space-y-3">
                <div class="w-12 h-12 bg-slate-900 text-white rounded-xl flex items-center justify-center text-xl group-hover:bg-red-600 transition">
                    💳
                </div>
                <h3 class="text-lg font-bold text-slate-900">Verifikasi Pembayaran Transfer</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Validasi bukti pembayaran dari pelanggan, pastikan pelunasan invoice (Part + Jasa Flat Rp 50.000).
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('admin.payment.index') }}" class="text-xs font-bold text-red-600 group-hover:text-red-700 flex items-center gap-1">
                    <span>Cek Pembayaran</span>
                    <span>→</span>
                </a>
                <span class="text-[10px] font-mono px-2 py-0.5 bg-slate-100 text-slate-600 rounded">Verifikasi BCA</span>
            </div>
        </div>

    </div>

    <!-- 4. Area Informasi Tambahan (System Rules & Quick Guidelines) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Peringatan Aturan Bisnis Admin -->
        <div class="lg:col-span-2 bg-slate-900 text-white p-8 rounded-2xl shadow-md space-y-4">
            <div class="flex items-center gap-2 text-red-500 font-mono text-xs font-bold uppercase">
                <span>⚠️</span>
                <span>Standar Operasional Prosedur Admin</span>
            </div>
            <h3 class="text-xl font-bold">Aturan Penting Alur Kerja BengkelService</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-slate-300 pt-2">
                <div class="p-3 bg-slate-800/80 rounded-xl border border-slate-700/60">
                    <strong class="text-white block mb-1">1. Penugasan Teknisi:</strong>
                    Setiap reservasi masuk harus dipasangkan dengan teknisi sebelum proses perbaikan dimulai.
                </div>
                <div class="p-3 bg-slate-800/80 rounded-xl border border-slate-700/60">
                    <strong class="text-white block mb-1">2. Perhitungan Biaya Invoice:</strong>
                    Formula otomatis: Total Suku Cadang + Biaya Flat Jasa Teknisi Rp 50.000.
                </div>
                <div class="p-3 bg-slate-800/80 rounded-xl border border-slate-700/60">
                    <strong class="text-white block mb-1">3. Approval Secondary Cause:</strong>
                    Pastikan pelanggan sudah menyetujui rekomendasi komponen tambahan via portal mereka.
                </div>
                <div class="p-3 bg-slate-800/80 rounded-xl border border-slate-700/60">
                    <strong class="text-white block mb-1">4. Read-Only Lock:</strong>
                    Status service yang sudah "Lunas" akan terkunci secara otomatis dari perubahan data.
                </div>
            </div>
        </div>

        <!-- Quick Summary Box -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between">
            <div>
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider mb-3">Ringkasan Sistem</h4>
                <div class="space-y-3 text-xs">
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Kategori Perangkat Support:</span>
                        <span class="font-bold text-slate-800">5 Jenis (HP, Laptop, PC, Monitor, Tablet)</span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-100">
                        <span class="text-slate-500">Jasa Teknisi Standard:</span>
                        <span class="font-bold text-red-600 font-mono">Rp 50.000</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-slate-500">Metode Pembayaran:</span>
                        <span class="font-bold text-slate-800">Transfer Bank / Manual Verification</span>
                    </div>
                </div>
            </div>
            
            <div class="pt-4 border-t border-slate-100">
                <a href="{{ route('admin.reservation.index') }}" class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition text-center block shadow-xs">
                    Mulai Kelola Reservasi ➔
                </a>
            </div>
        </div>

    </div>

</div>
@endsection