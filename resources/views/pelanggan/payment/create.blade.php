@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <!-- Navigasi Kembali -->
    <div>
        <a href="{{ route('pelanggan.service.index') }}" class="text-xs font-semibold text-slate-500 hover:text-red-600 transition flex items-center gap-1 w-fit">
            <span>←</span>
            <span>Kembali ke Daftar Service & Tagihan</span>
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white p-8 md:p-10 rounded-2xl border border-slate-200 shadow-xs space-y-6">
        <!-- Header -->
        <div class="border-b border-slate-100 pb-5">
            <span class="text-xs font-mono font-bold text-red-600 uppercase tracking-wider">[ VERIFIKASI KEUANGAN ]</span>
            <h1 class="text-2xl font-black text-slate-900 mt-1">Konfirmasi Pembayaran Invoice</h1>
            <p class="text-xs text-slate-500 mt-1">Silakan transfer total tagihan ke Rekening Resmi BengkelService dan unggah bukti transfer Anda.</p>
        </div>

        <!-- Info Rekening Tujuan & Rincian Transparan -->
        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-xs font-mono text-slate-500 uppercase font-semibold">Bank Tujuan</span>
                <span class="text-xs font-bold px-2 py-0.5 bg-blue-100 text-blue-800 rounded">Bank BCA</span>
            </div>
            <div class="pt-2 border-t border-slate-200/60">
                <p class="text-xs text-slate-500">Nomor Rekening Resmi:</p>
                <div class="flex items-center justify-between mt-0.5">
                    <strong class="text-base font-mono font-bold text-slate-900 tracking-wider">1234-5678-90</strong>
                    <span class="text-[11px] text-slate-500">a/n PT BengkelService Indonesia</span>
                </div>
            </div>
            <div class="pt-3 border-t border-slate-200/60 flex items-center justify-between">
                <div>
                    <span class="text-xs text-slate-500 block">Total Wajib Dibayar:</span>
                    <span class="text-[10px] text-slate-400 font-mono">(Akumulasi Sparepart + Jasa Teknisi)</span>
                </div>
                <strong class="text-xl font-black text-red-600 font-mono">
                    Rp {{ isset($invoice) ? number_format($invoice->total_tagihan ?? 0, 0, ',', '.') : '0' }}
                </strong>
            </div>
        </div>

        <!-- Form Konfirmasi -->
        <form action="{{ isset($invoice) ? route('pelanggan.payment.store', $invoice->id) : '#' }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <!-- Hidden Inputs untuk mencocokkan validasi Controller -->
            <input type="hidden" name="metode_pembayaran" value="Transfer Bank">
            <input type="hidden" name="nominal_bayar" value="{{ $invoice->total_tagihan ?? 0 }}">

            <!-- Input: Nama Rekening Pengirim -->
            <div>
                <label for="nama_rekening" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">
                    Nama Pemilik Rekening Pengirim <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_rekening" id="nama_rekening" placeholder="Contoh: Budi Santoso" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 placeholder-slate-400 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition">
                <p class="text-[11px] text-slate-400 mt-1">Masukkan nama pengirim yang tertera di struk / mutasi bank.</p>
            </div>

            <!-- Input: Upload Bukti Transfer (Name disesuaikan menjadi bukti_transfer) -->
            <div>
                <label for="bukti_transfer" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">
                    Upload Bukti Transfer (Foto / Screenshot) <span class="text-red-500">*</span>
                </label>
                <div class="p-4 bg-slate-50 border border-dashed border-slate-300 rounded-xl text-center hover:border-red-400 transition">
                    <input type="file" name="bukti_transfer" id="bukti_transfer" accept="image/*" required class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition cursor-pointer">
                    <p class="text-[10px] text-slate-400 mt-2">Format yang didukung: JPG, JPEG, PNG (Maks. 2MB)</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                <a href="javascript:history.back()" class="px-5 py-2.5 text-xs font-semibold text-slate-500 hover:text-slate-800 bg-transparent hover:bg-slate-100 rounded-xl transition">
                    Batal
                </a>
                <button type="submit" class="px-7 py-3 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-md shadow-red-600/20 transition cursor-pointer flex items-center gap-2">
                    <span>Kirim Bukti Pembayaran</span>
                    <span>✓</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection