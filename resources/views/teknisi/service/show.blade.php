@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header & Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <a href="{{ route('teknisi.service.index') }}" class="text-xs font-semibold text-slate-500 hover:text-red-600 transition flex items-center gap-1 w-fit mb-2">
                <span>←</span>
                <span>Kembali ke Daftar Tugas Saya</span>
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-black text-slate-900">
                    Pekerjaan Service: {{ $service->reservation->device->merek }} {{ $service->reservation->device->model }}
                </h1>
                <span class="px-3 py-1 bg-red-50 text-red-700 text-xs font-mono font-bold rounded-full border border-red-200/60">
                    #SRV-{{ str_pad($service->id, 4, '0', STR_PAD_LEFT) }}
                </span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs text-slate-400 font-mono">Status Saat Ini:</span>
            <span class="px-3 py-1 bg-amber-50 text-amber-700 text-xs font-bold rounded-full border border-amber-200 font-mono">
                {{ $service->status_perbaikan }}
            </span>
        </div>
    </div>

    <!-- Layout 2 Kolom Utama -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

        <!-- ================= KOLOM KIRI ================= -->
        <div class="space-y-6">
            
            <!-- Kiri 1: Detail Perangkat, Layanan & Root Cause -->
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-4 flex items-center justify-between">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <span>📱</span>
                        <span>Detail Perangkat & Layanan</span>
                    </h3>
                    <span class="text-[11px] font-mono text-slate-400">Tiket: {{ $service->reservation->tiket }}</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-slate-400 uppercase font-mono text-[10px] block font-semibold">Pelanggan</span>
                        <strong class="text-slate-900 text-sm block mt-0.5">{{ $service->reservation->user->name }}</strong>
                        <span class="text-slate-500 font-mono text-[11px]">{{ $service->reservation->user->no_telp }}</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <span class="text-slate-400 uppercase font-mono text-[10px] block font-semibold">Perangkat Fisik</span>
                        <strong class="text-slate-900 text-sm block mt-0.5">
                            {{ $service->reservation->device->jenis }} - {{ $service->reservation->device->merek }} {{ $service->reservation->device->model }}
                        </strong>
                        <span class="text-slate-500 text-[11px]">Warna: {{ $service->reservation->device->warna ?? '-' }}</span>
                    </div>
                </div>

                <div class="text-xs space-y-2">
                    <div>
                        <span class="text-slate-400 font-mono uppercase text-[10px] font-semibold block">Jenis Service / Kategori</span>
                        <span class="inline-block mt-1 px-2.5 py-1 bg-red-50 text-red-700 font-bold rounded-md border border-red-200/60">
                            {{ $service->reservation->jenis_service }}
                        </span>
                    </div>
                    <div>
                        <span class="text-slate-400 font-mono uppercase text-[10px] font-semibold block">Keluhan Awal Kerusakan</span>
                        <p class="text-slate-700 italic bg-slate-50 p-3 rounded-xl border border-slate-100 mt-1 leading-relaxed">
                            "{{ $service->reservation->keluhan_awal }}"
                        </p>
                    </div>
                </div>

                <hr class="border-slate-100">

                <!-- Section Root Cause Otomatis -->
                <div class="space-y-3">
                    <div>
                        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Root Cause / Part Bawaan Layanan</h4>
                        <p class="text-[11px] text-slate-400 mt-0.5">Sistem secara otomatis mencatat item utama berdasarkan jenis service yang dipilih pelanggan.</p>
                    </div>

                    @php
                        $rootCauses = $service->diagnosisItems->where('tipe_cause', 'Root Cause');
                    @endphp

                    @if($rootCauses->count() > 0)
                        <div class="space-y-2">
                            @foreach($rootCauses as $root)
                                <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-red-600"></span>
                                        <span class="font-bold text-slate-800">{{ $root->nama_tindakan }}</span>
                                        <span class="text-slate-400 font-mono text-[11px]">(Qty: {{ $root->qty_part }})</span>
                                    </div>
                                    <span class="font-mono font-bold text-slate-900">
                                        Rp {{ number_format($root->estimasi_biaya, 0, ',', '.') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-3 bg-slate-50 rounded-xl border border-dashed border-slate-200 text-slate-400 text-xs italic">
                            Belum ada Root Cause yang tercatat. Silakan tambahkan item Root Cause di bawah jika diperlukan.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Kiri 2: Form Item Tambahan (Primary / Secondary Cause) -->
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-xs space-y-5">
                <div class="border-b border-slate-100 pb-4">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <span>🧩</span>
                        <span>Tambah Item Tambahan (Primary / Secondary Cause)</span>
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-1">Gunakan form ini jika ditemukan indikasi kerusakan komponen pendukung saat pembongkaran.</p>
                </div>

                <form action="{{ route('teknisi.service.diagnosis', $service->id) }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="nama_tindakan" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                            Judul / Nama Tindakan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_tindakan" id="nama_tindakan" placeholder="Contoh: Ganti IC Power / Perbaikan Jalur VCC" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition">
                    </div>

                    <div>
                        <label for="tipe_cause" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                            Tipe Cause <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="tipe_cause" id="tipe_cause" required class="w-full pl-3.5 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition appearance-none cursor-pointer">
                                <option value="Primary Cause">Primary Cause (Wajib, Stok Berkurang Otomatis)</option>
                                <option value="Secondary Cause">Secondary Cause (Opsional, Butuh Persetujuan Pelanggan)</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3.5 pointer-events-none text-slate-400 text-xs">
                                ▼
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="sm:col-span-2">
                            <label for="inventory_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                                Part yang Digunakan (Opsional)
                            </label>
                            <div class="relative">
                                <select name="inventory_id" id="inventory_id" class="w-full pl-3.5 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition appearance-none cursor-pointer">
                                    <option value="">-- Tanpa Part / Hanya Jasa --</option>
                                    @foreach($inventories as $inv)
                                        <option value="{{ $inv->id }}">
                                            {{ $inv->nama_part }} (Stok: {{ $inv->stok }}) - Rp {{ number_format($inv->harga_satuan, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3.5 pointer-events-none text-slate-400 text-xs">
                                    ▼
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="qty_part" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                                Qty Part <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="qty_part" id="qty_part" value="1" min="1" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition">
                        </div>
                    </div>

                    <div>
                        <label for="alasan" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-1.5">
                            Alasan / Keterangan Tambahan
                        </label>
                        <textarea name="alasan" id="alasan" rows="2" placeholder="Mengapa item ini diperlukan..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition"></textarea>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-[11px] text-slate-500 flex items-center gap-2">
                        <span>💡</span>
                        <span>Estimasi biaya dihitung otomatis oleh sistem: (Harga Part + Flat Rp 50.000 Biaya Jasa Teknisi).</span>
                    </div>

                    <button type="submit" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-md shadow-red-600/20 transition cursor-pointer flex items-center justify-center gap-2">
                        <span>+ Tambahkan Item Diagnosis</span>
                    </button>
                </form>
            </div>

        </div>

        <!-- ================= KOLOM KANAN ================= -->
        <div class="space-y-6">
            
            <!-- Kanan 1: Update Progres 1-Klik & Timeline -->
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-xs space-y-6">
                <div>
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                        <span>⚡</span>
                        <span>Update Progres Pengerjaan (1-Klik)</span>
                    </h3>
                    <p class="text-[11px] text-slate-400 mt-1">Klik tombol di bawah sesuai dengan tahap pengerjaan yang sedang Anda lakukan:</p>
                </div>

                <div class="grid grid-cols-1 gap-2.5">
                    @foreach($progresOptions as $option)
                        <form action="{{ route('teknisi.service.progress', $service->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="deskripsi_progres" value="{{ $option }}">
                            <button type="submit" class="w-full p-3 bg-slate-50 hover:bg-red-50 hover:border-red-300 border border-slate-200 rounded-xl text-xs font-bold text-slate-700 hover:text-red-700 text-left transition flex items-center justify-between group cursor-pointer">
                                <span>📌 Update: {{ $option }}</span>
                                <span class="text-slate-400 group-hover:text-red-600 font-mono text-xs">Kirim ➔</span>
                            </button>
                        </form>
                    @endforeach
                </div>

                <hr class="border-slate-100">

                <!-- Card Riwayat Linimasa Progres Teknisi -->
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-mono flex items-center gap-2">
                            <span>⏱️</span>
                            <span>Riwayat Progres Pengerjaan</span>
                        </h3>
                        <span class="text-[11px] font-mono text-slate-400">Update Real-Time</span>
                    </div>

                    <!-- Status Utama Terkini -->
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 flex items-center justify-between">
                        <span class="text-xs text-slate-500 font-medium">Status Perbaikan Saat Ini:</span>
                        <x-badge type="warning" :pulse="true">
                            {{ $service->status_perbaikan ?? 'Dikerjakan' }}
                        </x-badge>
                    </div>

                    <!-- Linimasa Progres (Membaca deskripsi_progres) -->
                    <div class="border-l-2 border-red-600 pl-4 ml-2 space-y-4 pt-2">
                        @forelse($service->serviceProgresses as $prg)
                            <div class="relative">
                                <span class="absolute -left-[23px] top-1 w-3 h-3 bg-red-600 rounded-full ring-4 ring-red-100"></span>
                                <p class="text-xs font-bold text-slate-900 leading-relaxed">
                                    {{ $prg->deskripsi_progres }}
                                </p>
                                <span class="text-[10px] text-slate-400 font-mono mt-1 block">
                                    {{ $prg->created_at ? $prg->created_at->format('d M Y - H:i') : '' }} WIB
                                </span>
                            </div>
                        @empty
                            <div class="relative">
                                <span class="absolute -left-[23px] top-1 w-3 h-3 bg-red-600 rounded-full ring-4 ring-red-100"></span>
                                <p class="text-xs font-bold text-slate-900">Perangkat Diterima & Pengecekan Awal</p>
                                <span class="text-[10px] text-slate-400 font-mono mt-1 block">{{ date('d M Y - H:i') }} WIB</span>
                            </div>
                        @endforelse
                    </div>
                </div>

            <!-- Kanan 2: Tombol Selesaikan dengan Konfirmasi Ganda -->
            @if($service->status_perbaikan !== 'Selesai')
                <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-xs space-y-4 text-center">
                    <div>
                        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Penyelesaian Pekerjaan</h4>
                        <p class="text-xs text-slate-500 mt-1">Pastikan seluruh pemeriksaan, diagnosis, dan penggantian part sudah tuntas sepenuhnya.</p>
                    </div>

                    <form id="finishForm" action="{{ route('teknisi.service.finish', $service->id) }}" method="POST">
                        @csrf
                        <button type="button" onclick="confirmFinish()" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-md shadow-emerald-600/20 transition cursor-pointer flex items-center justify-center gap-2">
                            <span>✓ Tandai Pekerjaan Selesai</span>
                        </button>
                    </form>
                </div>
            @else
                <div class="p-6 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-semibold text-center flex items-center justify-center gap-2 shadow-xs">
                    <span>✅ Pekerjaan ini sudah selesai dan berstatus Read-Only.</span>
                </div>
            @endif

        </div>

    </div>
</div>

<!-- Script Double Confirmation -->
<script>
    function confirmFinish() {
        let check1 = confirm("Apakah Anda yakin ingin menandai pekerjaan ini sebagai SELESAI?\n\nPastikan semua tindakan dan part sudah dicatat dengan benar.");
        if (check1) {
            let check2 = confirm("KONFIRMASI ULANG:\nTindakan ini bersifat final dan data pekerjaan akan dikunci (Read-Only). Lanjutkan?");
            if (check2) {
                document.getElementById('finishForm').submit();
            }
        }
    }
</script>
@endsection