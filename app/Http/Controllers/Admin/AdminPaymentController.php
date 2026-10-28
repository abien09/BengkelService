<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;

class AdminPaymentController extends Controller
{
    // Melihat daftar pembayaran yang butuh verifikasi
    public function index()
    {
        $payments = Payment::with(['invoice.service.reservation.user'])
                           ->orderBy('created_at', 'desc')
                           ->get();
        return view('admin.payment.index', compact('payments'));
    }

    // Memverifikasi pembayaran dan mengubah status perangkat menjadi Siap Diambil
    public function verify($id)
    {
        $payment = Payment::findOrFail($id);
        
        $payment->update([
            'status_pembayaran' => 'Lunas'
        ]);

        // Catat progres bahwa perangkat siap diambil
        $payment->invoice->service->serviceProgresses()->create([
            'deskripsi_progres' => 'Pembayaran telah diverifikasi. Perangkat siap untuk diambil atau dikirim.'
        ]);

        return back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }
}