<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\User;    

class AdminReservationController extends Controller
{
    // Menampilkan daftar reservasi yang masuk
    public function index()
    {
        // Ambil semua reservasi beserta relasi user, device, dan service agar statusnya terpantau
        $reservations = Reservation::with(['user', 'device', 'service.invoice'])
                        ->orderBy('tanggal', 'desc')
                        ->get();
                        
        return view('admin.reservation.index', compact('reservations'));
    }

    // Form untuk menerima barang dan menugaskan teknisi
    public function assignForm($id)
    {
        $reservation = Reservation::with(['user', 'device'])->findOrFail($id);
        
        // Ambil daftar user yang memiliki role 'teknisi'
        $teknisiList = User::where('role', 'teknisi')->get();

        return view('admin.reservation.assign', compact('reservation', 'teknisiList'));
    }

    // Proses penyimpanan data Service & Update status Reservasi
    public function processAssign(Request $request, $id)
    {
        $request->validate([
            'teknisi_id' => 'required|exists:users,id',
            // Jika kamu menambahkan fitur upload foto kondisi barang di tabel services, tambahkan validasinya di sini
        ]);

        $reservation = Reservation::findOrFail($id);

        // 1. Buat data di tabel services
        $service = Service::create([
            'reservation_id' => $reservation->id,
            'teknisi_id' => $request->teknisi_id,
            'status_perbaikan' => 'Menunggu Teknisi',
        ]);

        // 2. Ubah status reservasi menjadi Diterima
        $reservation->update([
            'status_reservasi' => 'Diterima'
        ]);

        // 3. (Opsional) Kamu bisa otomatis menambahkan log awal ke tabel service_progress di sini
        // ServiceProgress::create([
        //     'service_id' => $service->id,
        //     'deskripsi_progres' => 'Perangkat telah diterima oleh Admin dan ditugaskan ke Teknisi.',
        // ]);

        return redirect()->route('admin.reservation.index')
                         ->with('success', 'Perangkat berhasil diterima dan teknisi telah ditugaskan.');
    }
}