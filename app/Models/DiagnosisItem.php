<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiagnosisItem extends Model
{
    protected $fillable = [
        'service_id', 'inventory_id', 'nama_tindakan', 'tipe_cause', 
        'qty_part', 'estimasi_biaya', 'status_persetujuan', 'alasan'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}