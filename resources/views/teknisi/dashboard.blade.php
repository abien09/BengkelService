@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    
    <!-- 1. Header Banner Dashboard Teknisi -->
    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-xs flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="w-2.5 h-2.5 rounded-full bg-red-600 animate-pulse"></span>
                <span class="text-xs font-mono font-bold uppercase tracking-wider text-red-600">[ RUANG KERJA TEKNISI ]</span>
            </div>
            <h1 class="text-3xl font-black text-slate-900">Dashboard Eksekusi Perbaikan</h1>
            <p class="text-sm text-slate-500 mt-1">Selamat datang, {{ Auth::user()->name }}. Kelola unit pelanggan, tentukan diagnosis komponen, dan perbarui progres perbaikan secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="text-right hidden sm:block font-mono text-xs text-slate-500">
                <div>{{ date('l, d F Y') }}</div>
                <div class="text-slate-900 font-bold">Status Teknisi: <span class="text-emerald-600">SIAP BERTUGAS</span></div>
            </div>
        </div>
    </div>

    <!-- 2. Ringkasan Metrik KPI Teknisi -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Metric 1: Tugas Dalam Pengerjaan -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between group hover:border-red-500 transition">
            <div>
                <span class="text-[11px] font-bold font-mono text-slate-400 uppercase tracking-wider block">Dalam Pengerjaan</span>
                <strong class="text-3xl font-black text-slate-900 mt-1 block">
                    {{ $activeTasksCount ?? 0 }}
                </strong>
                <span class="text-[11px] text-amber-600 font-medium mt-1 inline-block">Unit di meja servis</span>
            </div>
            <div class="w-12 h-12 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition">
                🛠️
            </div>
        </div>

        <!-- Metric 2: Menunggu Approval Secondary Cause -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between group hover:border-red-500 transition">
            <div>
                <span class="text-[11px] font-bold font-mono text-slate-400 uppercase tracking-wider block">Menunggu Approval</span>
                <strong class="text-3xl font-black text-slate-900 mt-1 block">
                    {{ $pendingApprovalCount ?? 0 }}
                </strong>
                <span class="text-[11px] text-rose-600 font-medium mt-1 inline-block">Secondary Cause</span>
            </div>
            <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition">
                ⏳
            </div>
        </div>

        <!-- Metric 3: Selesai Hari Ini -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between group hover:border-red-500 transition">
            <div>
                <span class="text-[11px] font-bold font-mono text-slate-400 uppercase tracking-wider block">Selesai Hari Ini</span>
                <strong class="text-3xl font-black text-slate-900 mt-1 block">
                    {{ $completedTodayCount ?? 0 }}
                </strong>
                <span class="text-[11px] text-emerald-600 font-medium mt-1 inline-block">QC Lolos</span>
            </div>
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition">
                ✅
            </div>
        </div>

        <!-- Metric 4: Total Perbaikan Selesai -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between group hover:border-red-500 transition">
            <div>
                <span class="text-[11px] font-bold font-mono text-slate-400 uppercase tracking-wider block">Total Selesai</span>
                <strong class="text-3xl font-black text-slate-900 mt-1 block">
                    {{ $totalCompletedCount ?? 0 }}
                </strong>
                <span class="text-[11px] text-slate-500 font-medium mt-1 inline-block">Kumulatif perbaikan</span>
            </div>
            <div class="w-12 h-12 bg-slate-100 text-slate-700 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition">
                📊
            </div>
        </div>
    </div>

    <!-- 3. Akses Utama Ruang Kerja & Panduan SOP -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Workspace Card -->
        <div class="lg:col-span-2 bg-white p-8 rounded-2xl border border-slate-200 shadow-xs flex flex-col justify-between group hover:border-red-500 transition">
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="w-14 h-14 bg-slate-900 text-white rounded-2xl flex items-center justify-center text-2xl group-hover:bg-red-600 transition shadow-sm">
                        🛠️
                    </div>
                    <span class="px-3 py-1 bg-red-50 text-red-700 font-mono text-xs font-bold rounded-full border border-red-200">
                        PENGURUSAN TUGAS
                    </span>
                </div>
                <div>
                    <h2 class="text-2xl font-black text-slate-900">Daftar Tugas Service & Ruang Eksekusi</h2>
                    <p class="text-sm text-slate-500 mt-1 leading-relaxed">
                        Akses daftar seluruh unit perangkat yang ditugaskan kepada Anda. Lakukan update status 1-click, masukkan item diagnosis (Root/Primary/Secondary Cause), dan lakukan konfirmasi ganda saat pengerjaan rampung.
                    </p>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="text-xs text-slate-400 font-mono">
                    Sistem Otomatis: Pemotongan stok inventori berjalan saat diagnosis disimpan.
                </div>
                <a href="{{ route('teknisi.service.index') }}" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-md shadow-red-600/20 transition flex items-center gap-2 cursor-pointer w-full sm:w-auto justify-center">
                    <span>Buka Daftar Tugas Saya</span>
                    <span>➔</span>
                </a>
            </div>
        </div>

        <!-- SOP Quick Rules -->
        <div class="bg-slate-900 text-white p-8 rounded-2xl shadow-md space-y-4 flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-2 text-red-500 font-mono text-xs font-bold uppercase mb-2">
                    <span>⚡</span>
                    <span>ALUR PENGERJAAN TEKNISI</span>
                </div>
                <h3 class="text-lg font-bold">Panduan Eksekusi Unit</h3>
                <ul class="space-y-3 text-xs text-slate-300 mt-4">
                    <li class="flex items-start gap-2">
                        <span class="text-red-500 font-bold">1.</span>
                        <span><strong>Pemeriksaan Awal:</strong> Cocokkan fisik perangkat dan keluhan awal dari reservasi pelanggan.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-red-500 font-bold">2.</span>
                        <span><strong>Diagnosis Component:</strong> Tetapkan Root Cause untuk mengurangi stok otomatis.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-red-500 font-bold">3.</span>
                        <span><strong>Secondary Cause:</strong> Item ekstra wajib menunggu persetujuan (approval) pelanggan via sistem.</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="text-red-500 font-bold">4.</span>
                        <span><strong>Penyelesaian:</strong> Lakukan Double Confirmation sebelum menandai service sebagai "Selesai".</span>
                    </li>
                </ul>
            </div>
            <div class="pt-4 border-t border-slate-800 text-[11px] text-slate-400 font-mono">
                BengkelService Technician Standard Operation
            </div>
        </div>

    </div>

</div>
@endsection