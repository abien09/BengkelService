@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <!-- Header & Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                <span class="text-xs font-mono font-bold uppercase tracking-wider text-red-600">[ OPERASIONAL BENGKEL ]</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900">Kelola Reservasi & Status Service</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pantau antrean masuk, tugaskan teknisi bertugas, dan terbitkan invoice pembayaran.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-xs font-semibold text-slate-500 hover:text-red-600 transition flex items-center gap-1">
            <span>←</span>
            <span>Dashboard Admin</span>
        </a>
    </div>

    <!-- Reservations Table -->
    @if(isset($reservations) && count($reservations) > 0)
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <th class="p-4">Tiket & Tanggal</th>
                            <th class="p-4">Pelanggan</th>
                            <th class="p-4">Perangkat & Spesifikasi</th>
                            <th class="p-4">Jenis Service & Keluhan</th>
                            <th class="p-4 text-center">Status / Aksi Operasional</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($reservations as $r)
                        <tr class="hover:bg-slate-50/80 transition">
                            <!-- Tiket & Waktu Kedatangan -->
                            <td class="p-4 font-mono text-xs">
                                <div class="font-bold text-slate-900">
                                    {{ $r->tiket }}
                                </div>
                                <div class="text-[11px] text-slate-500 mt-0.5 flex items-center gap-1">
                                    <span>🗓️</span>
                                    <span>{{ $r->tanggal }} ({{ $r->waktu }})</span>
                                </div>
                            </td>

                            <!-- Pelanggan -->
                            <td class="p-4">
                                <div class="font-bold text-slate-900">{{ $r->user->name ?? 'Pelanggan' }}</div>
                                <div class="text-xs font-mono text-slate-500 mt-0.5">{{ $r->user->no_telp ?? '-' }}</div>
                            </td>

                            <!-- Perangkat -->
                            <td class="p-4">
                                <div class="flex items-center gap-2">
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-700 font-mono text-[10px] font-bold rounded uppercase">
                                        {{ $r->device->jenis ?? 'Device' }}
                                    </span>
                                    <strong class="text-slate-900 font-bold">
                                        {{ $r->device->merek ?? '' }} {{ $r->device->model ?? '' }}
                                    </strong>
                                </div>
                                <div class="text-xs text-slate-400 mt-1">
                                    Warna: <span class="text-slate-600">{{ $r->device->warna ?? '-' }}</span>
                                </div>
                            </td>

                            <!-- Jenis Service & Keluhan -->
                            <td class="p-4 max-w-xs">
                                <span class="inline-block px-2.5 py-0.5 bg-red-50 text-red-700 text-[11px] font-bold rounded-md mb-1 border border-red-200/60">
                                    {{ $r->jenis_service }}
                                </span>
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                    {{ $r->keluhan_awal }}
                                </p>
                            </td>

                            <!-- Status / Action Buttons -->
                            <td class="p-4 text-center">
                                @if(($r->status_reservasi ?? '') == 'Menunggu')
                                    <a href="{{ route('admin.reservation.assign', $r->id) }}" class="px-3.5 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-xs transition inline-flex items-center gap-1">
                                        <span>Terima & Tugaskan</span>
                                        <span>➔</span>
                                    </a>
                                @else
                                    <div class="space-y-1.5">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-slate-100 text-slate-700 text-[11px] font-bold rounded-full border border-slate-200">
                                            Status: {{ $r->status_reservasi }}
                                        </span>

                                        @if(isset($r->service))
                                            <div class="text-[11px] text-slate-500">
                                                Teknisi: <strong class="text-slate-800">{{ $r->service->teknisi->name ?? '-' }}</strong>
                                            </div>
                                            <div class="text-[11px] text-slate-500">
                                                Progres: <strong class="text-red-600 font-semibold">{{ $r->service->status_perbaikan }}</strong>
                                            </div>

                                            @if(($r->service->status_perbaikan ?? '') == 'Selesai' && !$r->service->invoice)
                                                <div class="pt-1">
                                                    <a href="{{ route('admin.invoice.create', $r->service->id) }}" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-lg transition inline-block shadow-xs">
                                                        📄 Terbitkan Invoice
                                                    </a>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                @endif
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
                📥
            </div>
            <h3 class="text-base font-bold text-slate-800">Belum Ada Reservasi Masuk</h3>
            <p class="text-xs text-slate-500 max-w-sm mx-auto">
                Antrean reservasi perbaikan dari pelanggan masih kosong.
            </p>
        </div>
    @endif

    <div class="pt-2">
        <a href="{{ route('admin.dashboard') }}" class="text-xs font-semibold text-slate-500 hover:text-red-600 transition flex items-center gap-1 w-fit">
            <span>←</span>
            <span>Kembali ke Dashboard Admin</span>
        </a>
    </div>
</div>
@endsection