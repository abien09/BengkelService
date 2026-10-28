<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;

class AdminInventoryController extends Controller
{
    public function index()
    {
        $inventories = Inventory::all();
        return view('admin.inventory.index', compact('inventories'));
    }

    public function create()
    {
        return view('admin.inventory.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_part' => 'required|string|max:255',
            'device_type' => 'required|in:HP,Laptop,PC,Monitor,Tablet', // Validasi jenis perangkat sparepart
            'jenis' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        Inventory::create($request->all());

        return redirect()->route('admin.inventory.index')->with('success', 'Part baru berhasil ditambahkan ke inventori.');
    }
}