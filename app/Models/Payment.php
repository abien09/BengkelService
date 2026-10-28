<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'invoice_id', 'tanggal_bayar', 'metode_pembayaran', 'nominal_bayar', 'bukti_transfer', 'status_pembayaran'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}