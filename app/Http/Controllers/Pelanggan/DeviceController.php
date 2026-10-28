<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;


class DeviceController extends Controller
{
    public function index()
    {
        $devices = Auth::user()->devices;
        return view('pelanggan.device.index', compact('devices'));
    }

    public function create()
    {
        return view('pelanggan.device.create');
    }

    public function store(Request $request)
    {
        // Ubah validasi dari 'merek_model' menjadi 'merek' dan 'model'
        $request->validate([
            'jenis' => 'required|in:HP,Laptop,PC,Monitor,Tablet',
            'merek' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'warna' => 'nullable|string|max:50',
        ]);

        Device::create([
            'user_id' => Auth::id(),
            'jenis' => $request->jenis,
            'merek' => $request->merek,
            'model' => $request->model,
            'warna' => $request->warna,
        ]);

        return redirect()->route('pelanggan.device.index')->with('success', 'Perangkat berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        // Cari perangkat milik user yang sedang login
        $device = Device::where('user_id', Auth::id())->findOrFail($id);

        // Proteksi opsional: Cek jika perangkat sedang memiliki reservasi aktif
        if ($device->reservations()->whereNotIn('status_reservasi', ['Selesai', 'Batal'])->exists()) {
            return back()->with('error', 'Perangkat tidak dapat dihapus karena sedang dalam proses service aktif.');
        }

        $device->delete();

        return back()->with('success', 'Perangkat berhasil dihapus!');
    }
}