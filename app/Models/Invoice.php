<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'service_id', 'tanggal_invoice', 'detail_service', 'biaya_jasa', 'total_tagihan',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}