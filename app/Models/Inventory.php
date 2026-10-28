<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'nama_part', 'device_type', 'jenis', 'stok', 'harga_satuan'
    ];
}