@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- Breadcrumb Header -->
    <div class="flex items-center justify-between">
        <div>
            <span class="text-xs font-mono text-red-600 font-bold uppercase tracking-wider">[ TRACKING PROGRES PERBAIKAN ]</span>
            <h1 class="text-2xl font-black text-slate-900 mt-1">Detail Pengerjaan Perangkat</h1>
        </div>
        <a href="{{ route('pelanggan.service.index') }}" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition flex items-center gap-1">
            <span>←</span>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Status Banner Real-Time dari Teknisi -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <span class="text-[10px] font-mono font-bold text-slate-400 uppercase tracking-wider block">Status Perbaikan Saat Ini</span>
            <div class="mt-1 flex items-center gap-2">
                @php
                    $statusCurrent = $service->status_perbaikan ?? $service->status ?? 'Sedang Dikerjakan';
                    $statusLower = strtolower($statusCurrent);
                @endphp

                @if($statusLower == 'selesai' || $statusLower == 'lunas')
                    <x-badge type="success">{{ $statusCurrent }}</x-badge>
                @elseif(str_contains($statusLower, 'menunggu') || str_contains($statusLower, 'approval'))
                    <x-badge type="danger" :pulse="true">{{ $statusCurrent }}</x-badge>
                @else
                    <x-badge type="warning" :pulse="true">{{ $statusCurrent }}</x-badge>
                @endif
            </div>
        </div>

        @if(!empty($service->catatan_teknisi))
            <div class="bg-slate-50 p-3 rounded-xl border border-slate-200 w-full sm:w-auto text-xs max-w-sm">
                <span class="text-[10px] font-mono font-bold text-slate-400 uppercase block">Catatan Terakhir Teknisi:</span>
                <p class="text-slate-700 italic mt-0.5 font-medium">"{{ $service->catatan_teknisi }}"</p>
            </div>
        @endif
    </div>

    <!-- GRID UTAMA 2 SEKTOR -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- SEKTOR KIRI (5 KOLOM) -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Card 1: Info Ringkas Perangkat & Teknisi -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-mono border-b border-slate-100 pb-3 flex items-center gap-2">
                    <span>📱</span>
                    <span>Informasi Perangkat</span>
                </h3>

                <div class="grid grid-cols-2 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 block uppercase font-mono text-[10px] font-semibold">Kode Service</span>
                        <strong class="text-slate-900 font-mono font-bold">#SRV-{{ str_pad($service->id ?? 1, 4, '0', STR_PAD_LEFT) }}</strong>
                    </div>
                    <div>
                        <span class="text-slate-400 block uppercase font-mono text-[10px] font-semibold">Teknisi Bertugas</span>
                        <strong class="text-slate-900 font-bold block truncate">
                            {{ $service->teknisi->name ?? $service->technician->name ?? 'Teknisi Senior' }}
                        </strong>
                    </div>
                    <div class="col-span-2 pt-2 border-t border-slate-100">
                        <span class="text-slate-400 block uppercase font-mono text-[10px] font-semibold">Perangkat Fisik</span>
                        <strong class="text-slate-900 text-sm font-bold block mt-0.5">
                            {{ $service->reservation->device->merek ?? 'Device' }} {{ $service->reservation->device->model ?? '' }}
                        </strong>
                    </div>
                </div>
            </div>

            <!-- Card 2: Hasil Diagnosis & Alasan Tindakan Teknisi -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-mono flex items-center gap-2">
                        <span>🔍</span>
                        <span>Hasil Diagnosis Teknisi</span>
                    </h3>
                    <span class="text-[10px] font-mono text-slate-400">Rincian</span>
                </div>

                <div class="space-y-3">
                    @forelse($service->diagnosisItems ?? [] as $item)
                        @php
                            $tipe = strtolower($item->tipe_cause ?? $item->category ?? $item->tipe ?? '');
                            $isPrimary = str_contains($tipe, 'primary') || str_contains($tipe, 'root');
                            $status = strtolower($item->status_persetujuan ?? $item->status ?? 'menunggu');
                            
                            // Tampilkan harga part asli
                            $hargaPart = ($item->inventory->harga_satuan ?? 0) * ($item->qty_part ?? 1);
                        @endphp

                        <div class="p-3.5 rounded-xl border {{ $isPrimary ? 'bg-slate-50 border-slate-200' : 'bg-amber-50/50 border-amber-200' }} space-y-2">
                            <div class="flex items-center justify-between gap-2">
                                @if($isPrimary)
                                    <span class="px-2 py-0.5 bg-red-100 text-red-700 font-mono font-bold text-[9px] rounded uppercase border border-red-200">
                                        Primary Cause
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 bg-amber-100 text-amber-800 font-mono font-bold text-[9px] rounded uppercase border border-amber-300">
                                        Secondary Cause
                                    </span>
                                @endif

                                <span class="font-mono text-xs font-bold text-slate-900">
                                    Rp {{ number_format($hargaPart, 0, ',', '.') }}
                                </span>
                            </div>

                            <strong class="text-xs font-bold text-slate-900 block">
                                {{ $item->nama_tindakan ?? $item->inventory->nama_part ?? 'Tindakan Perbaikan' }}
                            </strong>

                            <div class="text-[11px] text-slate-600 bg-white p-2.5 rounded-lg border border-slate-200/80">
                                <span class="text-[9px] font-mono font-bold text-slate-400 uppercase block mb-0.5">Alasan Teknisi:</span>
                                <p class="italic leading-relaxed">
                                    "{{ $item->alasan ?? $item->keterangan ?? $item->catatan ?? 'Tindakan ini diperlukan berdasarkan hasil verifikasi teknisi.' }}"
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-xs text-slate-400 bg-slate-50 rounded-xl border border-slate-100">
                            Teknisi belum mencatatkan rincian diagnosis.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Card 3: Rincian Invoice & Pembayaran -->
            @php
                // Jika invoice sudah diterbitkan admin di database:
                $hasInvoice = isset($service->invoice);
                $invBiayaJasa = $hasInvoice ? ($service->invoice->biaya_jasa ?? 0) : 0;
                $invTotalTagihan = $hasInvoice ? ($service->invoice->total_tagihan ?? 0) : 0;
                
                // Sparepart dari invoice = Total Tagihan dikurangi Biaya Jasa
                $invTotalPart = $hasInvoice ? max(0, $invTotalTagihan - $invBiayaJasa) : 0;

                // Jika invoice BELUM diterbitkan (Estimasi real-time):
                $approvedItemsPelanggan = isset($service->diagnosisItems) ? $service->diagnosisItems->filter(function ($item) {
                    $status = strtolower($item->status_persetujuan ?? $item->status ?? '');
                    $tipe   = strtolower($item->tipe_cause ?? $item->category ?? '');
                    return in_array($status, ['approved', 'disetujui', 'auto approved']) || str_contains($tipe, 'root') || str_contains($tipe, 'primary');
                }) : collect();

                $estPart = $approvedItemsPelanggan->sum(function($item) {
                    return ($item->inventory->harga_satuan ?? 0) * ($item->qty_part ?? 1);
                });

                $estJasa = max(1, $approvedItemsPelanggan->count()) * 50000;
                $estTotal = $estPart + $estJasa;
            @endphp

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-mono">Rincian Invoice</h4>
                    @if($hasInvoice)
                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 text-[10px] font-mono font-bold rounded border border-emerald-200">
                            {{ strtoupper($service->invoice->status_pembayaran ?? $service->invoice->status_bayar ?? 'UNPAID') }}
                        </span>
                    @else
                        <span class="px-2 py-0.5 bg-amber-50 text-amber-700 text-[10px] font-mono font-bold rounded border border-amber-200">
                            Belum Diterbitkan
                        </span>
                    @endif
                </div>

                <div class="text-xs space-y-2 text-slate-600">
                    <div class="flex justify-between">
                        <span>Total Biaya Jasa Teknisi:</span>
                        <span class="font-mono font-semibold text-slate-900">
                            Rp {{ number_format($hasInvoice ? $invBiayaJasa : $estJasa, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span>Total Komponen Sparepart:</span>
                        <span class="font-mono font-semibold text-slate-900">
                            Rp {{ number_format($hasInvoice ? $invTotalPart : $estPart, 0, ',', '.') }}
                        </span>
                    </div>
                    <div class="pt-2 border-t border-slate-100 flex justify-between items-center font-bold text-slate-900 text-sm">
                        <span>Total Tagihan Akhir:</span>
                        <span class="text-red-600 font-mono text-base">
                            Rp {{ number_format($hasInvoice ? $invTotalTagihan : $estTotal, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="pt-2">
                    @if($hasInvoice)
                        <a href="{{ route('pelanggan.payment.create', ['invoice_id' => $service->invoice->id]) }}" class="w-full py-3 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl shadow-md shadow-red-600/20 transition flex items-center justify-center gap-2 cursor-pointer">
                            <span>Bayar / Upload Bukti Transfer</span>
                            <span>➔</span>
                        </a>
                    @else
                        <button disabled class="w-full py-3 bg-slate-100 text-slate-400 text-xs font-bold rounded-xl border border-slate-200 cursor-not-allowed flex items-center justify-center gap-2">
                            <span>Invoice Belum Diterbitkan Admin</span>
                        </button>
                    @endif
                </div>
            </div>

        </div>

        <!-- SEKTOR KANAN (7 KOLOM) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- Card Persetujuan Komponen Tambahan (Secondary Cause) -->
            @php
                $secondaryCauses = isset($service->diagnosisItems) 
                    ? $service->diagnosisItems->filter(function($item) {
                        $tipe   = strtolower($item->tipe_cause ?? $item->category ?? $item->tipe ?? '');
                        $status = strtolower($item->status_persetujuan ?? $item->status ?? $item->status_approval ?? '');
                        
                        $isSecondary = str_contains($tipe, 'secondary') || str_contains($tipe, 'tambahan');
                        
                        $isPending = !in_array($status, ['approved', 'disetujui', 'rejected', 'ditolak', 'auto approved']);
                        
                        return $isSecondary && $isPending;
                    }) 
                    : collect();
            @endphp

            @if($secondaryCauses->count() > 0)
                <div class="bg-amber-50/90 border border-amber-200 p-6 rounded-2xl space-y-4 shadow-xs">
                    <div class="flex items-start gap-3">
                        <span class="text-2xl">⚠️</span>
                        <div>
                            <h3 class="text-xs font-bold text-amber-900 uppercase tracking-wider font-mono">Persetujuan Komponen Tambahan (Secondary Cause)</h3>
                            <p class="text-xs text-amber-700 mt-1 leading-relaxed">
                                Silakan tinjau alasan di sektor kiri sebelum mengambil keputusan. Persetujuan Anda menentukan apakah komponen ini dipasang.
                            </p>
                        </div>
                    </div>

                    <div class="space-y-3 pt-2">
                        @foreach($secondaryCauses as $item)
                            <div class="bg-white p-4 rounded-xl border border-amber-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                <div>
                                    <strong class="text-xs font-bold text-slate-900 block">
                                        {{ $item->inventory->nama_part ?? $item->nama_tindakan ?? 'Suku Cadang Tambahan' }}
                                    </strong>
                                    <p class="text-[11px] text-slate-500 italic mt-0.5">
                                        Alasan: "{{ $item->alasan ?? $item->keterangan ?? 'Rekomendasi teknisi untuk perbaikan optimal.' }}"
                                    </p>
                                    <span class="text-[11px] text-slate-500 font-mono block mt-1">
                                        Biaya Part: Rp {{ number_format((($item->inventory->harga_satuan ?? 0) * ($item->qty_part ?? 1)), 0, ',', '.') }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                                    <form action="{{ route('pelanggan.service.approve-item', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin MENYETUJUI komponen tambahan ini?')" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition cursor-pointer">
                                            ✓ Setujui
                                        </button>
                                    </form>

                                    <form action="{{ route('pelanggan.service.reject-item', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin MENOLAK komponen tambahan ini?')" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition cursor-pointer">
                                            ✕ Tolak
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Card Linimasa Progres Pengerjaan (Timeline) -->
            <div class="bg-white p-6 md:p-8 rounded-2xl border border-slate-200 shadow-xs space-y-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                    <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2 font-mono">
                        <span>⏱️</span>
                        <span>Linimasa Tahapan Pengerjaan Teknisi</span>
                    </h3>
                    <span class="text-[11px] font-mono text-slate-400">Update Real-Time</span>
                </div>
                
                <div class="border-l-2 border-red-600 pl-5 ml-2 space-y-6">
                    @forelse($service->serviceProgresses as $prg)
                        <div class="relative">
                            <span class="absolute -left-[27px] top-1 w-3.5 h-3.5 bg-red-600 rounded-full ring-4 ring-red-100"></span>
                            
                            <h4 class="text-xs font-bold text-slate-900 leading-relaxed">
                                {{ $prg->deskripsi_progres ?? $prg->catatan_teknisi ?? 'Pembaruan Progres' }}
                            </h4>
                            
                            <span class="text-[10px] text-slate-400 font-mono mt-1.5 block">
                                {{ $prg->created_at ? $prg->created_at->format('d M Y, H:i') : '' }} WIB
                            </span>
                        </div>
                    @empty
                        <div class="relative">
                            <span class="absolute -left-[27px] top-1 w-3.5 h-3.5 bg-red-600 rounded-full ring-4 ring-red-100"></span>
                            <h4 class="text-xs font-bold text-slate-900">{{ $service->status_perbaikan ?? 'Pemeriksaan & Diagnosis' }}</h4>
                            <p class="text-xs text-slate-500 mt-0.5">Teknisi sedang melakukan tahapan perbaikan pada perangkat Anda.</p>
                            <span class="text-[10px] text-slate-400 font-mono mt-1 block">{{ date('d M Y, H:i') }} WIB</span>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</div>
@endsection