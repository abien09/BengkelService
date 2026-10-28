<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function create()
    {
        $devices = Auth::user()->devices;

        // Pengecekan aturan bisnis: wajib ada minimal 1 perangkat
        if ($devices->count() == 0) {
            return redirect()->route('pelanggan.device.create')
                ->with('error', 'Anda harus mendaftarkan minimal 1 perangkat sebelum membuat reservasi.');
        }

        return view('pelanggan.reservation.create', compact('devices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'required|exists:devices,id',
            'jenis_service' => 'required|string',
            'keluhan_awal' => 'required|string',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required',
        ]);

        $antrianHariIni = Reservation::whereDate('tanggal', $request->tanggal)->count() + 1;
        $tiket = 'RES-' . Carbon::parse($request->tanggal)->format('Ymd') . '-' . strtoupper(Str::random(4));

        Reservation::create([
            'user_id' => Auth::id(),
            'device_id' => $request->device_id,
            'keluhan_awal' => $request->keluhan_awal,
            'jenis_service' => $request->jenis_service,
            'tiket' => $tiket,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'no_antrian' => $antrianHariIni,
            'status_reservasi' => 'Menunggu',
        ]);

        return redirect()->route('pelanggan.dashboard')->with('success', 'Reservasi berhasil dibuat. Menunggu konfirmasi Admin.');
    }
}