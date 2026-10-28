@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header & Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                <span class="text-xs font-mono font-bold uppercase tracking-wider text-red-600">[ RUANG MEJA SERVIS ]</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900">Daftar Tugas Service Saya</h1>
            <p class="text-xs text-slate-500 mt-0.5">Unit perangkat pelanggan yang ditugaskan kepada Anda untuk didiagnosa dan dieksekusi perbaikannya.</p>
        </div>
        <a href="{{ route('teknisi.dashboard') }}" class="text-xs font-semibold text-slate-500 hover:text-red-600 transition flex items-center gap-1">
            <span>←</span>
            <span>Dashboard Teknisi</span>
        </a>
    </div>

    <!-- Services Table -->
    @if(isset($services) && count($services) > 0)
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <th class="p-4">Tiket & Kode</th>
                            <th class="p-4">Pelanggan</th>
                            <th class="p-4">Perangkat & Spesifikasi</th>
                            <th class="p-4">Jenis Service</th>
                            <th class="p-4">Status Perbaikan</th>
                            <th class="p-4 text-center">Aksi Pengerjaan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($services as $s)
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Tiket & Waktu -->
                            <td class="p-4 font-mono text-xs">
                                <div class="font-bold text-slate-900">
                                    {{ $s->reservation->tiket ?? '#TKT-000' }}
                                </div>
                                <div class="text-[11px] text-slate-400 mt-0.5">
                                    #SRV-{{ str_pad($s->id, 4, '0', STR_PAD_LEFT) }}
                                </div>
                            </td>

                            <!-- Pelanggan -->
                            <td class="p-4">
                                <div class="font-bold text-slate-900">{{ $s->reservation->user->name ?? 'Pelanggan' }}</div>
                                <div class="text-xs font-mono text-slate-500 mt-0.5">{{ $s->reservation->user->no_telp ?? '-' }}</div>
                            </td>

                            <!-- Perangkat Complete -->
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-700 font-mono text-[10px] font-bold rounded uppercase">
                                        {{ $s->reservation->device->jenis ?? 'Device' }}
                                    </span>
                                    <strong class="text-slate-900 font-bold">
                                        {{ $s->reservation->device->merek ?? '' }} {{ $s->reservation->device->model ?? '' }}
                                    </strong>
                                </div>
                                <div class="text-xs text-slate-400 mt-1">
                                    Warna: <span class="text-slate-600">{{ $s->reservation->device->warna ?? '-' }}</span>
                                </div>
                            </td>

                            <!-- Jenis Service -->
                            <td class="p-4">
                                <span class="inline-block px-2.5 py-1 bg-red-50 text-red-700 text-[11px] font-bold rounded-md border border-red-200/60">
                                    {{ $s->reservation->jenis_service ?? 'Perbaikan Umum' }}
                                </span>
                            </td>

                            <!-- Status Perbaikan -->
                            <td class="p-4">
                                @php
                                    $st = strtolower($s->status_perbaikan ?? 'proses');
                                @endphp

                                @if($st == 'selesai' || $st == 'lunas')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[11px] font-bold rounded-full border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Selesai Pengerjaan
                                    </span>
                                @elseif(str_contains($st, 'menunggu') || str_contains($st, 'approval'))
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-rose-50 text-rose-700 text-[11px] font-bold rounded-full border border-rose-200 animate-pulse">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        Menunggu Approval Pelanggan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 text-amber-700 text-[11px] font-bold rounded-full border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        {{ $s->status_perbaikan }}
                                    </span>
                                @endif
                            </td>

                            <!-- Action -->
                            <td class="p-4 text-center">
                                <a href="{{ route('teknisi.service.show', $s->id) }}" class="px-3.5 py-2 bg-slate-900 hover:bg-red-600 text-white text-xs font-bold rounded-xl shadow-xs transition inline-flex items-center gap-1.5 cursor-pointer">
                                    <span>Kerjakan / Detail</span>
                                    <span>➔</span>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-white p-12 text-center rounded-2xl border border-slate-200 space-y-4">
            <div class="w-16 h-16 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center text-3xl mx-auto">
                🛠️
            </div>
            <h3 class="text-base font-bold text-slate-800">Meja Servis Masih Kosong</h3>
            <p class="text-xs text-slate-500 max-w-sm mx-auto">
                Belum ada tugas perbaikan perangkat yang ditugaskan kepada Anda saat ini.
            </p>
        </div>
    @endif

    <div class="pt-2">
        <a href="{{ route('teknisi.dashboard') }}" class="text-xs font-semibold text-slate-500 hover:text-red-600 transition flex items-center gap-1 w-fit">
            <span>←</span>
            <span>Kembali ke Dashboard Teknisi</span>
        </a>
    </div>
</div>
@endsection