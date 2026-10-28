<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Service;

class AdminInvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['service.reservation.user', 'service.reservation.device'])->latest()->get();
        return view('admin.invoice.index', compact('invoices'));
    }

    public function create($service_id)
    {
        $service = Service::with(['reservation.device', 'reservation.user', 'teknisi', 'diagnosisItems.inventory'])->findOrFail($service_id);

        // Ambil item yang disetujui / auto approved / root / primary
        $approvedItems = $service->diagnosisItems->filter(function ($item) {
            $status = strtolower($item->status_persetujuan ?? $item->status ?? '');
            $tipe   = strtolower($item->tipe_cause ?? $item->category ?? '');
            
            return in_array($status, ['approved', 'disetujui', 'auto approved']) 
                || str_contains($tipe, 'root') 
                || str_contains($tipe, 'primary');
        });

        // 1. Hitung Murni Total Sparepart (Harga Satuan x Qty)
        $totalBiayaPart = $approvedItems->sum(function($item) {
            if ($item->inventory_id && $item->inventory) {
                return ($item->inventory->harga_satuan ?? 0) * ($item->qty_part ?? 1);
            }
            return 0; // Jika murni tindakan tanpa part
        });

        // 2. Hitung Total Biaya Jasa Teknisi (Rp 50.000 per tindakan/cause yang disetujui)
        $jumlahTindakan = $approvedItems->count();
        $totalBiayaJasa = max(1, $jumlahTindakan) * 50000; // Minimal 1x Jasa (Rp 50.000)

        return view('admin.invoice.create', compact('service', 'totalBiayaPart', 'totalBiayaJasa'));
    }

    public function store(Request $request, $service_id)
    {
        $service = Service::with('diagnosisItems')->findOrFail($service_id);

        $approvedItems = $service->diagnosisItems->filter(function ($item) {
            $status = strtolower($item->status_persetujuan ?? $item->status ?? '');
            $tipe   = strtolower($item->tipe_cause ?? $item->category ?? '');
            
            return in_array($status, ['approved', 'disetujui', 'auto approved']) 
                || str_contains($tipe, 'root') 
                || str_contains($tipe, 'primary');
        });

        // Murni Sparepart
        $totalBiayaPart = $approvedItems->sum(function($item) {
            if ($item->inventory_id && $item->inventory) {
                return ($item->inventory->harga_satuan ?? 0) * ($item->qty_part ?? 1);
            }
            return 0;
        });

        // Akumulasi Jasa Teknisi (50rb per tindakan)
        $jumlahTindakan = $approvedItems->count();
        $biayaJasa = max(1, $jumlahTindakan) * 50000;

        $totalTagihan = $biayaJasa + $totalBiayaPart;

        Invoice::create([
            'service_id'      => $service_id,
            'tanggal_invoice' => now(),
            'biaya_jasa'      => $biayaJasa,
            'total_tagihan'   => $totalTagihan,
            'detail_service'  => $request->detail_service,
            // Kolom status / status_pembayaran dihapus karena tidak ada di tabel database
        ]);

        return redirect()->route('admin.reservation.index')->with('success', 'Invoice berhasil diterbitkan!');
    }

    public function show($id)
    {
        $invoice = Invoice::with(['service.reservation.user', 'service.reservation.device'])->findOrFail($id);
        return view('admin.invoice.show', compact('invoice'));
    }

    public function print($id)
    {
        $invoice = Invoice::with([
            'service.reservation.user', 
            'service.reservation.device', 
            'service.diagnosisItems.inventory', 
            'service.teknisi'
        ])->findOrFail($id);

        return view('admin.invoice.print', compact('invoice'));
    }
}