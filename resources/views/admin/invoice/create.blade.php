@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Navigasi Kembali -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.reservation.index') }}" class="text-xs font-semibold text-slate-500 hover:text-red-600 transition flex items-center gap-1.5 w-fit">
            <span>←</span>
            <span>Kembali ke Kelola Reservasi</span>
        </a>
        <span class="text-xs font-mono text-slate-400">STATUS: PENERBITAN INVOICE</span>
    </div>

    <!-- Main Card Container -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <!-- Header Banner -->
        <div class="p-6 md:p-8 bg-slate-900 text-white flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-[10px] font-mono font-bold uppercase tracking-widest text-slate-300">[ PENERBITAN TAGIHAN RESMI ]</span>
                </div>
                <h1 class="text-xl md:text-2xl font-black tracking-tight">Terbitkan Invoice Service</h1>
                <p class="text-xs text-slate-400 mt-1">Periksa kalkulasi otomatis sebelum mengirimkan invoice langsung ke akun pelanggan.</p>
            </div>

            <div class="bg-slate-800/80 border border-slate-700/80 px-4 py-3 rounded-xl text-right font-mono">
                <span class="text-[10px] uppercase text-slate-400 block font-semibold">Kode Service</span>
                <span class="text-base font-bold text-red-400">#SRV-{{ str_pad($service->id ?? 1, 4, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>

        <div class="p-6 md:p-8 space-y-6">
            <!-- Informasi Perangkat & Pelanggan -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200/80 text-xs">
                <div>
                    <span class="text-[10px] font-mono font-bold text-slate-400 uppercase block">Pemilik / Pelanggan</span>
                    <strong class="text-slate-900 font-bold block mt-0.5">{{ $service->reservation->user->name ?? 'Pelanggan' }}</strong>
                </div>
                <div>
                    <span class="text-[10px] font-mono font-bold text-slate-400 uppercase block">Perangkat</span>
                    <strong class="text-slate-900 font-bold block mt-0.5">
                        {{ $service->reservation->device->merek ?? 'Device' }} {{ $service->reservation->device->model ?? '' }}
                    </strong>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <span class="text-[10px] font-mono font-bold text-slate-400 uppercase block">Teknisi Bertugas</span>
                    <strong class="text-slate-900 font-bold block mt-0.5">{{ $service->teknisi->name ?? 'Teknisi Senior' }}</strong>
                </div>
            </div>

            <!-- Breakdown Ringkasan Kalkulasi Biaya (ReadOnly) -->
            <div class="space-y-3">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-mono flex items-center gap-2">
                    <span>🧾</span>
                    <span>Rincian Kalkulasi Biaya Sistem</span>
                </h3>

                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden divide-y divide-slate-100 text-xs">
                    <div class="p-4 flex justify-between items-center">
                        <div>
                            <span class="font-bold text-slate-800 block">Total Biaya Jasa Teknisi</span>
                            <span class="text-[11px] text-slate-400 font-mono">Rp 50.000 × Akumulasi Tindakan Disetujui</span>
                        </div>
                        <span class="font-mono font-bold text-slate-900 text-sm">
                            Rp {{ number_format($totalBiayaJasa ?? 50000, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="p-4 flex justify-between items-center">
                        <div>
                            <span class="font-bold text-slate-800 block">Total Murni Suku Cadang / Part</span>
                            <span class="text-[11px] text-slate-400 font-mono">Harga komponen fisik yang dipasang</span>
                        </div>
                        <span class="font-mono font-bold text-slate-900 text-sm">
                            Rp {{ number_format($totalBiayaPart ?? 0, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Row Total Akhir -->
                    <div class="p-4 bg-red-50/50 flex justify-between items-center">
                        <div>
                            <strong class="font-black text-red-900 text-sm block">TOTAL TAGIHAN AKHIR</strong>
                            <span class="text-[10px] text-red-700 font-mono">Otomatis dihitung oleh sistem</span>
                        </div>
                        <span class="font-mono font-black text-red-600 text-lg">
                            Rp {{ number_format(($totalBiayaPart ?? 0) + ($totalBiayaJasa ?? 50000), 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Form Terbitkan Invoice -->
            <form action="{{ route('admin.invoice.store', $service->id) }}" method="POST" class="space-y-5 pt-2">
                @csrf

                <!-- Hidden input untuk membawa data jasa otomatis -->
                <input type="hidden" name="biaya_jasa" value="{{ $totalBiayaJasa ?? 50000 }}">

                <!-- Input: Catatan Tambahan (Opsional) -->
                <div>
                    <label for="detail_service" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">
                        Catatan Tambahan / Garansi Perbaikan (Opsional)
                    </label>
                    <textarea name="detail_service" id="detail_service" rows="3" placeholder="Tuliskan catatan garansi atau petunjuk pembayaran tambahan untuk pelanggan..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition"></textarea>
                </div>

                <!-- Action Buttons -->
                <div class="pt-4 border-t border-slate-100 flex flex-col-reverse md:flex-row items-center justify-end gap-3">
                    <a href="{{ route('admin.reservation.index') }}" class="w-full md:w-auto px-5 py-3 text-xs font-semibold text-slate-500 hover:text-slate-800 bg-transparent hover:bg-slate-100 rounded-xl transition text-center">
                        Batal
                    </a>
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin MENERBITKAN invoice ini ke pelanggan?')" class="w-full md:w-auto px-8 py-3.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-md shadow-red-600/20 transition cursor-pointer flex items-center justify-center gap-2">
                        <span>🚀 Terbitkan & Kirim Invoice</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection