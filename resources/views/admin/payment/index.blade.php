@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                <span class="text-xs font-mono font-bold uppercase tracking-wider text-red-600">[ VERIFIKASI KEUANGAN ]</span>
            </div>
            <h1 class="text-2xl font-black text-slate-900">Verifikasi Pembayaran</h1>
            <p class="text-xs text-slate-500 mt-0.5">Validasi bukti transfer pelanggan dan ubah status invoice menjadi lunas.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-xs font-semibold text-slate-500 hover:text-red-600 transition flex items-center gap-1">
            <span>←</span>
            <span>Dashboard Admin</span>
        </a>
    </div>

    <!-- Payments Table -->
    @if(isset($payments) && count($payments) > 0)
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs font-bold uppercase tracking-wider">
                            <th class="p-4">Tiket / Service</th>
                            <th class="p-4">Nominal Tagihan</th>
                            <th class="p-4">Metode Bayar</th>
                            <th class="p-4">Bukti Transfer</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 text-center">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($payments as $p)
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="p-4 font-mono text-xs font-bold text-slate-900">
                                {{ $p->invoice->service->reservation->tiket ?? '#TKT-UNKNOWN' }}
                            </td>
                            <td class="p-4 font-mono font-bold text-slate-900">
                                Rp {{ number_format($p->nominal_bayar ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="p-4">
                                <span class="inline-block px-2.5 py-1 bg-slate-100 text-slate-700 text-[11px] font-semibold rounded-lg font-mono">
                                    {{ $p->metode_pembayaran ?? 'Transfer Bank' }}
                                </span>
                            </td>
                            <td class="p-4">
                                @if(isset($p->bukti_transfer))
                                    <a href="{{ asset('storage/' . $p->bukti_transfer) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-bold rounded-lg border border-red-200 transition">
                                        <span>🖼️ Lihat Bukti</span>
                                    </a>
                                @else
                                    <span class="text-xs text-slate-400 italic">Tanpa Bukti</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @if(($p->status_pembayaran ?? '') == 'Menunggu Verifikasi')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 text-amber-700 text-[11px] font-bold rounded-full border border-amber-200 animate-pulse">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Menunggu Verifikasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-emerald-50 text-emerald-700 text-[11px] font-bold rounded-full border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Lunas / Verified
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                @if(($p->status_pembayaran ?? '') == 'Menunggu Verifikasi')
                                    <form action="{{ route('admin.payment.verify', $p->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin memverifikasi pembayaran ini sebagai LUNAS?')" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg transition cursor-pointer shadow-xs">
                                            ✓ Verifikasi Lunas
                                        </button>
                                    </form>
                                @else
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="text-xs text-slate-400 font-mono font-semibold">✓ Selesai</span>
                                        @if(isset($p->invoice))
                                            <a href="{{ route('admin.invoice.print', $p->invoice->id) }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 bg-neutral-50 text-neutral-900 text-[11px] font-bold rounded-full border border-neutral-500">
                                                <span>Cetak Struk</span>
                                            </a>
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
                💳
            </div>
            <h3 class="text-base font-bold text-slate-800">Belum Ada Transaksi Pembayaran</h3>
            <p class="text-xs text-slate-500 max-w-sm mx-auto">
                Belum ada konfirmasi pembayaran transfer dari pelanggan yang perlu diverifikasi saat ini.
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