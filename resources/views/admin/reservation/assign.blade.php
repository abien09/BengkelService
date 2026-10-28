@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Breadcrumb Navigasi -->
    <div>
        <a href="{{ route('admin.reservation.index') }}" class="text-xs font-semibold text-slate-500 hover:text-red-600 transition flex items-center gap-1 w-fit">
            <span>←</span>
            <span>Kembali ke Kelola Reservasi</span>
        </a>
    </div>

    <!-- Main Card Container -->
    <div class="bg-white p-8 md:p-10 rounded-2xl border border-slate-200 shadow-xs space-y-6">
        <!-- Header Form -->
        <div class="border-b border-slate-100 pb-5">
            <div class="flex items-center gap-2 mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                <span class="text-xs font-mono font-bold uppercase tracking-wider text-red-600">[ PENUGASAN TEKNISI ]</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900">
                Tugaskan Teknisi untuk Tiket: {{ $reservation->tiket }}
            </h1>
            <p class="text-xs text-slate-500 mt-1">Periksa ringkasan perangkat pelanggan dan tetapkan teknisi spesialis yang bertanggung jawab.</p>
        </div>

        <!-- Detail Ringkas Reservasi -->
        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-200 text-xs space-y-3">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <span class="text-slate-400 uppercase font-mono text-[10px] block font-semibold">Pelanggan</span>
                    <strong class="text-slate-800 text-sm block">{{ $reservation->user->name ?? '-' }}</strong>
                </div>
                <div>
                    <span class="text-slate-400 uppercase font-mono text-[10px] block font-semibold">Perangkat Fisik</span>
                    <strong class="text-slate-800 text-sm block">
                        {{ $reservation->device->jenis ?? '' }} - {{ $reservation->device->merek ?? '' }} {{ $reservation->device->model ?? '' }}
                    </strong>
                </div>
                <div>
                    <span class="text-slate-400 uppercase font-mono text-[10px] block font-semibold">Kategori Service</span>
                    <span class="inline-block mt-0.5 px-2 py-0.5 bg-red-100 text-red-700 font-bold rounded text-[11px]">
                        {{ $reservation->jenis_service }}
                    </span>
                </div>
                <div>
                    <span class="text-slate-400 uppercase font-mono text-[10px] block font-semibold">Jadwal Kedatangan</span>
                    <strong class="text-slate-800 font-mono block mt-0.5">{{ $reservation->tanggal }} ({{ $reservation->waktu }})</strong>
                </div>
            </div>

            <div class="pt-2 border-t border-slate-200/60">
                <span class="text-slate-400 uppercase font-mono text-[10px] block font-semibold mb-1">Keluhan Awal Kerusakan</span>
                <p class="text-slate-700 italic bg-white p-3 rounded-xl border border-slate-200/60 leading-relaxed">
                    "{{ $reservation->keluhan_awal }}"
                </p>
            </div>
        </div>

        <!-- Form Penugasan -->
        <form action="{{ route('admin.reservation.process_assign', $reservation->id) }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="teknisi_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wide mb-2">
                    Pilih Teknisi Bertugas <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="teknisi_id" id="teknisi_id" required class="w-full pl-4 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-800 focus:bg-white focus:border-red-500 focus:ring-2 focus:ring-red-500/20 focus:outline-none transition appearance-none cursor-pointer">
                        <option value="" disabled selected>-- Pilih Teknisi --</option>
                        @foreach($teknisiList as $t)
                            <option value="{{ $t->id }}">👨‍🔧 {{ $t->name }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-400 text-xs">
                        ▼
                    </div>
                </div>
                <p class="text-[11px] text-slate-400 mt-1.5">Teknisi terpilih akan langsung melihat tugas perbaikan ini di dashboard ruang kerja mereka.</p>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-slate-100 flex flex-col-reverse md:flex-row items-center justify-end gap-3">
                <a href="{{ route('admin.reservation.index') }}" class="w-full md:w-auto px-6 py-3 text-sm font-semibold text-slate-500 hover:text-slate-800 bg-transparent hover:bg-slate-100 rounded-xl transition text-center">
                    Batal
                </a>
                <button type="submit" class="w-full md:w-auto px-8 py-3 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl shadow-md shadow-red-600/20 transition cursor-pointer flex items-center justify-center gap-2">
                    <span>Terima & Simpan Penugasan</span>
                    <span>✓</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection