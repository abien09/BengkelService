<?php

namespace App\Http\Controllers\Teknisi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ServiceProgress;
use App\Models\DiagnosisItem;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;

class TeknisiServiceController extends Controller
{
    // 1. Melihat daftar pekerjaan yang ditugaskan ke teknisi login
    public function index()
    {
        $services = Service::with(['reservation.device', 'reservation.user'])
                    ->where('teknisi_id', Auth::id())
                    ->get();
        return view('teknisi.service.index', compact('services'));
    }

    // 2. Detail pekerjaan untuk eksekusi
    public function show($id)
    {
        $service = Service::with(['reservation.device', 'reservation.user', 'diagnosisItems.inventory', 'serviceProgresses'])
                ->where('teknisi_id', Auth::id())
                ->findOrFail($id);

        $this->generateRootCauseIfNeeded($service);
        $service->load('diagnosisItems.inventory');

        $deviceType = $service->reservation->device->jenis ?? 'Laptop';

        $inventories = Inventory::where('stok', '>', 0)
                        ->where('device_type', $deviceType)
                        ->get();

        $jenisService = $service->reservation->jenis_service ?? 'Umum';
        $progresOptions = $this->getProgressOptionsByService($jenisService);

        return view('teknisi.service.show', compact('service', 'inventories', 'progresOptions'));
    }

    private function generateRootCauseIfNeeded(Service $service)
    {
        $existingRoot = $service->diagnosisItems()->where('tipe_cause', 'Root Cause')->exists();

        if (!$existingRoot) {
            $jenisService = $service->reservation->jenis_service ?? '';
            $partsToDeduct = [];

            if ($jenisService == 'Ganti Kipas Laptop') {
                $partsToDeduct = [
                    ['nama_part_keyword' => 'Kipas Laptop', 'qty' => 1],
                    ['nama_part_keyword' => 'Thermal Paste', 'qty' => 1],
                ];
            } elseif (in_array($jenisService, ['LCD Laptop Mati', 'LCD HP Rusak', 'Ganti Layar'])) {
                $partsToDeduct = [
                    ['nama_part_keyword' => 'LCD', 'qty' => 1],
                ];
            } elseif (str_contains($jenisService, 'Baterai')) {
                $partsToDeduct = [
                    ['nama_part_keyword' => 'Baterai', 'qty' => 1],
                ];
            }

            foreach ($partsToDeduct as $rule) {
                $inventory = Inventory::where('nama_part', 'like', '%' . $rule['nama_part_keyword'] . '%')->first();

                if ($inventory) {
                    $biayaPart = $inventory->harga_satuan * $rule['qty'];
                    $estimasiBiaya = $biayaPart + 50000;

                    DiagnosisItem::create([
                        'service_id' => $service->id,
                        'inventory_id' => $inventory->id,
                        'nama_tindakan' => 'Root Cause (Otomatis): ' . $inventory->nama_part,
                        'tipe_cause' => 'Root Cause',
                        'qty_part' => $rule['qty'],
                        'estimasi_biaya' => $estimasiBiaya,
                        'status_persetujuan' => 'Auto Approved',
                        'alasan' => 'Dikecualikan otomatis dari jenis service: ' . $jenisService
                    ]);

                    $inventory->decrement('stok', $rule['qty']);

                    // Catat ke linimasa hanya menggunakan kolom deskripsi_progres
                    $service->serviceProgresses()->create([
                        'deskripsi_progres' => '[ROOT CAUSE] Otomatis menyiapkan ' . $inventory->nama_part,
                    ]);
                }
            }
        }
    }

    private function getProgressOptionsByService($jenisService)
    {
        switch ($jenisService) {
            case 'Ganti Kipas Laptop':
                return [
                    'Membongkar casing belakang laptop',
                    'Melepaskan soket kipas lama dan membersihkan debu heatsink',
                    'Mengaplikasikan thermal paste baru',
                    'Memasang kipas laptop baru dan merakit kembali'
                ];
            case 'LCD Laptop Mati':
            case 'LCD HP Rusak':
            case 'Ganti Layar':
                return [
                    'Membongkar bezel / panel layar perangkat',
                    'Melepaskan kabel fleksibel LCD yang rusak',
                    'Memasang LCD pengganti baru',
                    'Pengujian tampilan layar dan sentuhan (touchscreen)'
                ];
            case 'Ganti Baterai Laptop':
            case 'Ganti Baterai HP':
                return [
                    'Membongkar perangkat untuk akses baterai',
                    'Melepaskan baterai lama yang bermasalah',
                    'Memasang baterai baru dan menguji daya',
                    'Merakit kembali perangkat dengan presisi'
                ];
            default:
                return [
                    'Membongkar perangkat dan pengecekan fisik',
                    'Pembersihan komponen internal',
                    'Penggantian komponen / perbaikan jalur',
                    'Pengujian fungsionalitas akhir'
                ];
        }
    }

    // 3. Update progres 1-Klik / Manual
    public function updateProgress(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $teksProgresTeknisi = $request->input('catatan_teknisi') 
            ?? $request->input('status_pengerjaan') 
            ?? $request->input('deskripsi_progres') 
            ?? $request->input('keterangan') 
            ?? $request->input('catatan') 
            ?? $request->input('status_perbaikan') 
            ?? $request->input('status');

        if (empty($teksProgresTeknisi)) {
            return back()->with('error', 'Pembaruan gagal. Teks progres tidak boleh kosong.');
        }

        // Update status utama service
        $service->update([
            'status_perbaikan' => 'Dikerjakan',
            'catatan_teknisi'  => $teksProgresTeknisi,
        ]);

        // Simpan entri linimasa HANYA dengan kolom deskripsi_progres
        $service->serviceProgresses()->create([
            'deskripsi_progres' => $teksProgresTeknisi,
        ]);

        return back()->with('success', 'Progres pengerjaan berhasil diperbarui!');
    }

    // 4. Menambahkan Diagnosis & Auto-Deduction Stok
    public function addDiagnosis(Request $request, $id)
    {
        $request->validate([
            'inventory_id'  => 'nullable|exists:inventories,id',
            'nama_tindakan' => 'required|string',
            'tipe_cause'    => 'required|in:Primary Cause,Secondary Cause',
            'qty_part'      => 'required|integer|min:1',
            'alasan'        => 'nullable|string'
        ]);

        $service = Service::findOrFail($id);
        
        $biayaPart = 0;
        if ($request->inventory_id) {
            $inventory = Inventory::find($request->inventory_id);
            $biayaPart = ($inventory->harga_satuan ?? 0) * $request->qty_part;
        }
        
        $estimasiBiaya = $biayaPart + 50000;

        $isPrimary = str_contains($request->tipe_cause, 'Primary');
        $statusPersetujuan = $isPrimary ? 'Auto Approved' : 'Menunggu';

        DiagnosisItem::create([
            'service_id'         => $service->id,
            'inventory_id'       => $request->inventory_id,
            'nama_tindakan'      => $request->nama_tindakan,
            'tipe_cause'         => $request->tipe_cause,
            'qty_part'           => $request->qty_part,
            'estimasi_biaya'     => $estimasiBiaya,
            'status_persetujuan' => $statusPersetujuan,
            'alasan'             => $request->alasan
        ]);

        if ($request->inventory_id && $statusPersetujuan == 'Auto Approved') {
            Inventory::find($request->inventory_id)?->decrement('stok', $request->qty_part);
        }

        if ($request->tipe_cause == 'Secondary Cause') {
            $service->update(['status_perbaikan' => 'Menunggu Persetujuan']);
        }

        // Catat ke linimasa
        $teksLinimasa = "[{$request->tipe_cause}] {$request->nama_tindakan}. Alasan: " . ($request->alasan ?? 'Pemeriksaan teknisi.');
        $service->serviceProgresses()->create([
            'deskripsi_progres' => $teksLinimasa,
        ]);

        return back()->with('success', $request->tipe_cause . ' berhasil ditambahkan.');
    }

    // 5. Menyelesaikan Pekerjaan
    public function finishService($id)
    {
        $service = Service::findOrFail($id);
        $service->update(['status_perbaikan' => 'Selesai']);
        
        $service->serviceProgresses()->create([
            'deskripsi_progres' => 'Pekerjaan telah selesai. Menunggu pembuatan invoice oleh Admin.'
        ]);

        return back()->with('success', 'Service berhasil diselesaikan!');
    }
}