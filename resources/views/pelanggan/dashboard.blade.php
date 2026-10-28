@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <!-- Header sambutan -->
    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                <span class="text-xs font-mono font-semibold uppercase tracking-wider text-slate-400">Portal Pelanggan Utama</span>
            </div>
            <h1 class="text-3xl font-black text-slate-900">Halo, {{ Auth::user()->name }}!</h1>
            <p class="text-sm text-slate-500 mt-1">Pantau perangkat elektronik, buat reservasi, dan cek status perbaikan secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('pelanggan.reservation.create') }}" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-xl shadow-md transition flex items-center gap-2">
                <span>+ Buat Reservasi</span>
            </a>
        </div>
    </div>

    <!-- Grid Menu Utama -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Menu Perangkat -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs hover:border-red-500 transition group flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition">
                    📱
                </div>
                <h3 class="text-lg font-bold text-slate-900">Kelola Perangkat</h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Daftarkan jenis, merek, model, dan warna perangkat elektronik milik Anda sebelum melakukan reservasi.</p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('pelanggan.device.index') }}" class="text-xs font-bold text-red-600 group-hover:text-red-700 flex items-center gap-1">
                    <span>Lihat Perangkat</span>
                    <span>→</span>
                </a>
                <a href="{{ route('pelanggan.device.create') }}" class="text-[11px] px-2.5 py-1 bg-slate-100 hover:bg-slate-200 rounded text-slate-600 font-medium transition">+ Tambah</a>
            </div>
        </div>

        <!-- Menu Reservasi -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs hover:border-red-500 transition group flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition">
                    📅
                </div>
                <h3 class="text-lg font-bold text-slate-900">Reservasi Service</h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Pilih perangkat terdaftar, tentukan jenis servis spesifik, dan masukkan keluhan awal kerusakan.</p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('pelanggan.reservation.create') }}" class="text-xs font-bold text-red-600 group-hover:text-red-700 flex items-center gap-1">
                    <span>Buat Jadwal</span>
                    <span>→</span>
                </a>
            </div>
        </div>

        <!-- Menu Service & Tagihan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs hover:border-red-500 transition group flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center text-xl mb-4 group-hover:scale-110 transition">
                    🔍
                </div>
                <h3 class="text-lg font-bold text-slate-900">Lacak & Pembayaran</h3>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Pantau alur pengerjaan teknisi, berikan approval secondary cause, dan bayar tagihan invoice.</p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <a href="{{ route('pelanggan.service.index') }}" class="text-xs font-bold text-red-600 group-hover:text-red-700 flex items-center gap-1">
                    <span>Buka Daftar Service</span>
                    <span>→</span>
                </a>
            </div>
        </div>

    </div>

    <!-- Tombol Fitur Tambahan Masa Depan (Opsional tanpa Table baru) -->
    <div class="bg-slate-900 text-white p-6 rounded-2xl shadow-md flex flex-col sm:flex-row justify-between items-center gap-4">
        <div>
            <h4 class="text-sm font-bold">Butuh Bantuan Cepat atau Konsultasi Sparepart?</h4>
            <p class="text-xs text-slate-400 mt-0.5">Hubungi teknisi kepala kami via WhatsApp bengkel resmi.</p>
        </div>
        <button onclick="alert('Fitur Live Chat WhatsApp akan segera terhubung dengan teknisi piket!')" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-xs font-semibold rounded-lg transition">
            Chat Teknisi 💬
        </button>
    </div>
</div>
@endsection