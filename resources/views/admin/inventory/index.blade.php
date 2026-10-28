@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header & Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                <span class="text-xs font-mono font-bold uppercase tracking-wider text-red-600">[ INVENTORI BENGKEL ]</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900">Kelola Stok Inventori Part</h1>
            <p class="text-xs text-slate-500 mt-0.5">Daftar suku cadang, ketersediaan unit, harga satuan, dan pemantauan stok kritis.</p>
        </div>
        <a href="{{ route('admin.inventory.create') }}" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-sm transition flex items-center gap-2">
            <span class="text-base leading-none">+</span>
            <span>Tambah Part Baru</span>
        </a>
    </div>

    <!-- Table Container -->
    @if(isset($inventories) && $inventories->count() > 0)
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <th class="p-4">Nama Part / Component</th>
                            <th class="p-4">Peruntukan & Kategori</th>
                            <th class="p-4">Stok Tersedia</th>
                            <th class="p-4">Harga Satuan</th>
                            <th class="p-4 text-center">Status Ketersediaan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($inventories as $inv)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-4 font-bold text-slate-900">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center text-sm font-mono">
                                        🧩
                                    </div>
                                    <span>{{ $inv->nama_part }}</span>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="inline-block px-2.5 py-0.5 bg-slate-100 text-slate-700 text-[11px] font-semibold rounded-md uppercase font-mono mr-1">
                                    {{ $inv->device_type ?? 'Umum' }}
                                </span>
                                <span class="text-slate-500 text-xs">{{ $inv->jenis }}</span>
                            </td>
                            <td class="p-4 font-mono font-bold text-slate-900">
                                {{ $inv->stok }} <span class="text-xs font-normal text-slate-400">unit</span>
                            </td>
                            <td class="p-4 font-mono font-semibold text-slate-800">
                                Rp {{ number_format($inv->harga_satuan, 0, ',', '.') }}
                            </td>
                            <td class="p-4 text-center">
                                @if($inv->stok <= 2)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-50 text-red-700 text-[11px] font-bold rounded-full border border-red-200 animate-pulse">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                                        Stok Kritis (≤ 2)
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[11px] font-bold rounded-full border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Tersedia
                                    </span>
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
                📦
            </div>
            <h3 class="text-base font-bold text-slate-800">Inventori Masih Kosong</h3>
            <p class="text-xs text-slate-500 max-w-sm mx-auto">
                Belum ada data suku cadang / sparepart yang didaftarkan ke sistem. Tambahkan part awal untuk memulai operasional bengkel.
            </p>
            <div>
                <a href="{{ route('admin.inventory.create') }}" class="inline-block px-5 py-2.5 bg-red-600 text-white text-xs font-bold rounded-xl hover:bg-red-700 transition shadow-xs">
                    + Tambah Part Baru
                </a>
            </div>
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