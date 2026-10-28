<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Payment;
use Carbon\Carbon;

class PaymentController extends Controller
{
    // Menampilkan halaman pembayaran berdasarkan Invoice
    public function create($invoice_id)
    {
        $invoice = Invoice::findOrFail($invoice_id);
        return view('pelanggan.payment.create', compact('invoice'));
    }

    // Proses upload bukti pembayaran
    public function store(Request $request, $invoice_id)
    {
        $request->validate([
            'metode_pembayaran' => 'required|string',
            'nominal_bayar' => 'required|numeric',
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $invoice = Invoice::findOrFail($invoice_id);

        // Upload file bukti transfer ke folder storage/app/public/bukti_transfer
        $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');

        Payment::create([
            'invoice_id' => $invoice->id,
            'tanggal_bayar' => Carbon::now(),
            'metode_pembayaran' => $request->metode_pembayaran,
            'nominal_bayar' => $request->nominal_bayar,
            'bukti_transfer' => $path,
            'status_pembayaran' => 'Menunggu Verifikasi',
        ]);

        // Tambahkan log progres
        $invoice->service->serviceProgresses()->create([
            'deskripsi_progres' => 'Pelanggan telah mengunggah bukti pembayaran. Menunggu verifikasi Admin.'
        ]);

        return redirect()->route('pelanggan.service.index')->with('success', 'Bukti pembayaran berhasil diunggah.');
    }
}