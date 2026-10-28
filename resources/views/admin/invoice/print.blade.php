<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #INV-{{ str_pad($invoice->id ?? 1, 5, '0', STR_PAD_LEFT) }} - BengkelService</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; color: black !important; padding: 0 !important; }
            .print-container { border: none !important; box-shadow: none !important; padding: 0 !important; max-width: 100% !important; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 font-sans antialiased min-h-screen p-4 sm:p-8">

    <!-- Action Bar (Tidak ikut tercetak) -->
    <div class="max-w-3xl mx-auto mb-6 no-print flex justify-between items-center">
        <a href="javascript:history.back()" class="text-xs font-semibold text-slate-600 hover:text-red-600 transition flex items-center gap-1">
            <span>←</span>
            <span>Kembali</span>
        </a>
        <button onclick="window.print()" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-md transition cursor-pointer flex items-center gap-2">
            <span>🖨️ Cetak Struk / Cetak PDF</span>
        </button>
    </div>

    <!-- Calculations Initializer -->
    @php
        $approvedCount = 0;
        $totalItems = 0;
        
        if (isset($invoice->service->diagnosisItems)) {
            foreach ($invoice->service->diagnosisItems as $item) {
                $status = strtolower($item->status_persetujuan ?? $item->status ?? '');
                $tipe   = strtolower($item->tipe_cause ?? $item->category ?? '');
                
                if (in_array($status, ['approved', 'disetujui', 'auto approved']) || str_contains($tipe, 'root') || str_contains($tipe, 'primary') || str_contains($tipe, 'secondary')) {
                    $approvedCount++;
                    $totalItems += ($item->estimasi_biaya ?? (($item->inventory->harga_satuan ?? 0) * ($item->qty_part ?? 1)));
                }
            }
        }
        
        $jumlahJasa = max(1, $approvedCount);
        $biayaJasaSatuan = 50000;
        $totalBiayaJasa = $invoice->biaya_jasa ?? ($jumlahJasa * $biayaJasaSatuan);
        
        $grandTotal = $invoice->total_tagihan ?? ($totalBiayaJasa + $totalItems);
    @endphp

    <!-- Container Struk / Invoice -->
    <div class="print-container max-w-3xl mx-auto bg-white p-8 md:p-12 rounded-2xl border border-slate-200 shadow-sm space-y-8 relative overflow-hidden">
        
        <!-- Watermark Status Pembayaran -->
        <div class="absolute -right-10 -bottom-10 opacity-10 pointer-events-none select-none font-black text-8xl text-slate-900 uppercase transform -rotate-12">
            {{ strtoupper($invoice->status_pembayaran ?? $invoice->status_bayar ?? 'PAID') }}
        </div>

        <!-- Invoice Header -->
        <div class="flex justify-between items-start border-b border-slate-200 pb-6">
            <div>
                <div class="flex items-baseline gap-1">
                    <span class="text-slate-900 text-2xl font-black">Bengkel</span>
                    <span class="text-red-600 text-2xl font-black">Service</span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Studio Perbaikan & Presisi Elektronik</p>
                <p class="text-[11px] text-slate-400 font-mono mt-0.5">Jl. Studio Utama No. 88, Banten | WA: 0812-3456-7890</p>
            </div>
            <div class="text-right">
                <span class="text-xs font-mono font-bold text-red-600 uppercase tracking-wider block">[ INVOICE RESMI ]</span>
                <strong class="text-lg font-mono font-bold text-slate-900 block mt-0.5">
                    #INV-{{ str_pad($invoice->id ?? 1, 5, '0', STR_PAD_LEFT) }}
                </strong>
                <span class="text-xs text-slate-500 font-mono block mt-1">
                    Tanggal: {{ $invoice->created_at ? $invoice->created_at->format('d/m/Y') : date('d/m/Y') }}
                </span>
            </div>
        </div>

        <!-- Info Meta Pelanggan & Perangkat -->
        <div class="grid grid-cols-2 gap-6 text-xs bg-slate-50 p-5 rounded-xl border border-slate-200">
            <div>
                <span class="text-slate-400 font-mono uppercase text-[10px] font-bold block mb-1">Ditujukan Kepada:</span>
                <strong class="text-slate-900 text-sm block font-bold">{{ $invoice->service->reservation->user->name ?? 'Pelanggan' }}</strong>
                <span class="text-slate-600 block mt-0.5">{{ $invoice->service->reservation->user->no_telp ?? '-' }}</span>
                <span class="text-slate-500 block text-[11px] mt-0.5">{{ $invoice->service->reservation->user->alamat ?? 'Alamat tidak dicantumkan' }}</span>
            </div>
            <div>
                <span class="text-slate-400 font-mono uppercase text-[10px] font-bold block mb-1">Perangkat Perbaikan:</span>
                <strong class="text-slate-900 text-sm block font-bold">
                    {{ $invoice->service->reservation->device->jenis ?? 'Device' }}
                    {{ $invoice->service->reservation->device->merek ?? '' }} {{ $invoice->service->reservation->device->model ?? '' }}
                </strong>
                <span class="text-slate-600 block mt-0.5">Tiket: <strong class="font-mono">{{ $invoice->service->reservation->tiket ?? '-' }}</strong></span>
                <span class="text-slate-500 block text-[11px] mt-0.5">Teknisi: {{ $invoice->service->teknisi->name ?? 'Teknisi Senior' }}</span>
            </div>
        </div>

        <!-- Rincian Biaya Transaksi -->
        <div class="space-y-3">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-mono">Rincian Komponen & Jasa</h3>
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b-2 border-slate-900 text-slate-900 font-bold uppercase">
                        <th class="py-2.5">Deskripsi Item</th>
                        <th class="py-2.5 text-center font-mono">Tipe</th>
                        <th class="py-2.5 text-center font-mono">Qty</th>
                        <th class="py-2.5 text-right font-mono">Harga Satuan</th>
                        <th class="py-2.5 text-right font-mono">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <!-- Biaya Jasa Teknisi Dinamis -->
                    <tr>
                        <td class="py-3 font-semibold text-slate-900">
                            Biaya Jasa Perbaikan Teknisi
                            <span class="block text-[11px] text-slate-400 font-normal">Pemeriksaan, pembongkaran, & pengujian QC ({{ $jumlahJasa }} Tindakan)</span>
                        </td>
                        <td class="py-3 text-center font-mono text-slate-500">JASA</td>
                        <td class="py-3 text-center font-mono text-slate-700">{{ $jumlahJasa }}</td>
                        <td class="py-3 text-right font-mono text-slate-700">Rp {{ number_format($biayaJasaSatuan, 0, ',', '.') }}</td>
                        <td class="py-3 text-right font-mono font-bold text-slate-900">Rp {{ number_format($totalBiayaJasa, 0, ',', '.') }}</td>
                    </tr>

                    <!-- Item Diagnosis (Primary & Secondary Cause) Terpasang -->
                    @forelse($invoice->service->diagnosisItems ?? [] as $item)
                        @php
                            $status = strtolower($item->status_persetujuan ?? $item->status ?? '');
                            $tipe   = strtolower($item->tipe_cause ?? $item->category ?? '');
                            
                            $isApproved = in_array($status, ['approved', 'disetujui', 'auto approved']) || str_contains($tipe, 'root') || str_contains($tipe, 'primary') || str_contains($tipe, 'secondary');
                            
                            $namaItem = $item->nama_tindakan ?? ($item->inventory->nama_part ?? 'Komponen Tambahan');
                            $tipeLabel = strtoupper($item->tipe_cause ?? $item->category ?? 'PART');
                            $qty = $item->qty_part ?? 1;
                            $hargaSatuan = $item->inventory->harga_satuan ?? $item->estimasi_biaya ?? 0;
                            $subtotal = $item->estimasi_biaya ?? ($hargaSatuan * $qty);
                        @endphp

                        @if($isApproved)
                            <tr>
                                <td class="py-3 font-semibold text-slate-900">
                                    {{ $namaItem }}
                                    @if(isset($item->inventory) && $item->inventory->nama_part)
                                        <span class="block text-[11px] text-slate-500 font-normal">Part: {{ $item->inventory->nama_part }}</span>
                                    @endif
                                    @if(!empty($item->alasan))
                                        <span class="block text-[10px] text-slate-400 italic">Alasan: "{{ $item->alasan }}"</span>
                                    @endif
                                </td>
                                <td class="py-3 text-center font-mono text-slate-500 text-[10px]">{{ $tipeLabel }}</td>
                                <td class="py-3 text-center font-mono text-slate-700">{{ $qty }}</td>
                                <td class="py-3 text-right font-mono text-slate-700">
                                    Rp {{ number_format($hargaSatuan, 0, ',', '.') }}
                                </td>
                                <td class="py-3 text-right font-mono font-bold text-slate-900">
                                    Rp {{ number_format($subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-slate-400 italic">Tidak ada rincian komponen tambahan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Total Tagihan -->
        <div class="border-t-2 border-slate-900 pt-4 flex justify-between items-start">
            <div class="text-xs text-slate-500 max-w-xs space-y-1">
                <p class="font-semibold text-slate-800">Catatan Garansi:</p>
                <p class="text-[11px] text-slate-500 leading-relaxed">
                    Garansi perbaikan berlaku selama 7 hari sejak diterbitkannya invoice ini untuk komponen dan kendala yang sama.
                </p>
            </div>
            <div class="text-right space-y-1">
                <span class="text-xs text-slate-500 font-mono uppercase block font-semibold">Total Pelunasan:</span>
                <strong class="text-2xl font-mono font-black text-red-600 block">
                    Rp {{ number_format($grandTotal, 0, ',', '.') }}
                </strong>
                <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-800 font-mono font-bold text-[10px] rounded-md uppercase mt-1">
                    STATUS: {{ strtoupper($invoice->status_pembayaran ?? $invoice->status_bayar ?? 'MENUNGGU PEMBAYARAN') }}
                </span>
            </div>
        </div>

        <!-- Footer Struk -->
        <div class="pt-8 border-t border-slate-100 text-center text-slate-400 text-[10px] font-mono space-y-1">
            <p>TERIMA KASIH TELAH MEMPERCAYAKAN PERBAIKAN PERANGKAT ANDA KEPADA BENGKELSERVICE</p>
            <p>DOKUMEN INI DITERBITKAN SECARA OTOMATIS OLEH SISTEM BENGKELSERVICE</p>
        </div>

    </div>

</body>
</html>