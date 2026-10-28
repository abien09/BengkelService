@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <!-- Breadcrumb & Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                <span class="text-xs font-mono font-bold uppercase tracking-wider text-red-600">[ RIWAYAT PERBAIKAN ]</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900">Daftar Service & Tagihan</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pantau status pengerjaan teknisi secara real-time dan selesaikan pembayaran invoice Anda.</p>
        </div>
        <a href="{{ route('pelanggan.reservation.create') }}" class="px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-xl shadow-sm transition flex items-center gap-1.5">
            <span>+ Buat Service Baru</span>
        </a>
    </div>

    <!-- Tabel Daftar Service -->
    @if(isset($services) && $services->count() > 0)
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <th class="p-4">Kode Service / Tanggal</th>
                            <th class="p-4">Perangkat</th>
                            <th class="p-4">Jenis Service</th>
                            <th class="p-4">Status Pengerjaan</th>
                            <th class="p-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($services as $serv)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-4 font-mono text-xs text-slate-600">
                                <div class="font-bold text-slate-900">#SRV-{{ str_pad($serv->id, 4, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-[11px] text-slate-400 mt-0.5">{{ $serv->created_at ? $serv->created_at->format('d M Y, H:i') : '-' }} WIB</div>
                            </td>
                            <td class="p-4 font-semibold text-slate-900">
                                {{ $serv->reservation->device->jenis ?? 'Device' }} - 
                                {{ $serv->reservation->device->merek ?? '' }} {{ $serv->reservation->device->model ?? '' }}
                            </td>
                            <td class="p-4 text-slate-600">
                                {{ $serv->reservation->jenis_service ?? 'Diagnosis Menyeluruh' }}
                            </td>
                            <td class="p-4">
                                @php
                                    $status = strtolower($serv->status_perbaikan ?? 'proses');
                                @endphp

                                <!-- Penerapan Komponen Badge Status Reusable -->
                                @if($status == 'selesai' || $status == 'lunas')
                                    <x-badge type="success">Selesai</x-badge>
                                @elseif(str_contains($status, 'menunggu') || str_contains($status, 'approval'))
                                    <x-badge type="danger" :pulse="true">Persetujuan Komponen</x-badge>
                                @else
                                    <x-badge type="warning">Sedang Dikerjakan</x-badge>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <a href="{{ route('pelanggan.service.show', $serv->id) }}" class="px-3.5 py-2 bg-slate-900 hover:bg-red-600 text-white text-xs font-semibold rounded-xl transition inline-flex items-center gap-1 shadow-xs">
                                    <span>Lacak Progres</span>
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
                🔍
            </div>
            <h3 class="text-base font-bold text-slate-800">Belum Ada Riwayat Service</h3>
            <p class="text-xs text-slate-500 max-w-sm mx-auto">
                Anda belum memiliki antrean perbaikan aktif. Buat reservasi service untuk mendaftarkan perbaikan perangkat Anda.
            </p>
            <div>
                <a href="{{ route('pelanggan.reservation.create') }}" class="inline-block mt-2 px-5 py-2.5 bg-red-600 text-white text-xs font-bold rounded-xl hover:bg-red-700 transition shadow-xs">
                    + Buat Reservasi Service
                </a>
            </div>
        </div>
    @endif

    <div class="pt-2">
        <a href="{{ route('pelanggan.dashboard') }}" class="text-xs font-semibold text-slate-500 hover:text-red-600 transition flex items-center gap-1 w-fit">
            <span>←</span>
            <span>Kembali ke Dashboard</span>
        </a>
    </div>
</div>
@endsection