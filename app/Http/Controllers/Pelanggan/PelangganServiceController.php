<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\DiagnosisItem;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PelangganServiceController extends Controller
{
    // Melihat daftar service pelanggan
    public function index()
    {
        $services = Service::whereHas('reservation', function($q) {
            $q->where('user_id', Auth::id());
        })->with(['reservation.device'])->get();

        return view('pelanggan.service.index', compact('services'));
    }

    // Detail service (Tracking 2-Sektor & Linimasa Real-Time)
    public function show($id)
    {
        $service = Service::whereHas('reservation', function($q) {
            $q->where('user_id', Auth::id());
        })->with([
            'reservation.device',
            'teknisi',
            'invoice',
            'serviceProgresses' => function($q) {
                $q->orderBy('created_at', 'desc'); // Urutkan progres dari yang terbaru
            },
            'diagnosisItems.inventory'
        ])->findOrFail($id);

        return view('pelanggan.service.show', compact('service'));
    }

    // Menyetujui atau Menolak Secondary Cause via Form Tunggal
    public function respondDiagnosis(Request $request, $id)
    {
        $request->validate([
            'tanggapan' => 'required|in:Disetujui,Ditolak'
        ]);

        return $this->processDiagnosisResponse($id, $request->tanggapan);
    }

    // Method khusus jika view memanggil route approve-item
    public function approveItem($id)
    {
        return $this->processDiagnosisResponse($id, 'Disetujui');
    }

    // Method khusus jika view memanggil route reject-item
    public function rejectItem($id)
    {
        return $this->processDiagnosisResponse($id, 'Ditolak');
    }

    // Helper privat untuk memproses tanggapan persetujuan, pemotongan stok, dan pembaruan linimasa
    private function processDiagnosisResponse($id, string $tanggapan)
    {
        // Bungkus seluruh proses dalam DB Transaction untuk keamanan total
        return DB::transaction(function () use ($id, $tanggapan) {
            
            $diagnosis = DiagnosisItem::whereHas('service.reservation', function($q) {
                $q->where('user_id', Auth::id());
            })->findOrFail($id);

            $statusLama = strtolower($diagnosis->status_persetujuan ?? $diagnosis->status ?? 'menunggu');
            
            // Proteksi: Jika sudah pernah di-approve/reject sebelumnya, batalkan
            if (in_array($statusLama, ['disetujui', 'approved', 'ditolak', 'rejected'])) {
                return back()->with('error', 'Item ini sudah ditanggapi sebelumnya.');
            }

            // 1. Update status persetujuan item
            $diagnosis->update([
                'status_persetujuan' => $tanggapan,
                'status'             => $tanggapan,
            ]);

            // 2. Jika disetujui, potong stok otomatis
            if ($tanggapan == 'Disetujui' && $diagnosis->inventory_id) {
                Inventory::find($diagnosis->inventory_id)?->decrement('stok', $diagnosis->qty_part ?? 1);
            }

            // 3. Catat respon ke linimasa pengerjaan
            $namaItem = $diagnosis->nama_tindakan ?? $diagnosis->inventory->nama_part ?? 'Komponen Tambahan';
            $teksLinimasa = "Pelanggan telah {$tanggapan} pemasangan komponen: {$namaItem}.";

            $diagnosis->service->serviceProgresses()->create([
                'deskripsi_progres' => $teksLinimasa,
            ]);

            // 4. Cek apakah masih ada item Secondary Cause yang 'Menunggu' persetujuan
            $menungguCount = DiagnosisItem::where('service_id', $diagnosis->service_id)
                ->where(function($q) {
                    $q->whereIn('status_persetujuan', ['Menunggu', 'Pending'])
                    ->orWhereNull('status_persetujuan');
                })
                ->whereIn('tipe_cause', ['Secondary Cause', 'Secondary'])
                ->count();

            // Jika semua Secondary Cause sudah ditanggapi, kembalikan status perbaikan ke 'Dikerjakan'
            if ($menungguCount == 0) {
                $diagnosis->service->update(['status_perbaikan' => 'Dikerjakan']);
            }

            return back()->with('success', 'Tanggapan Anda telah berhasil disimpan!');
        });
    }
}