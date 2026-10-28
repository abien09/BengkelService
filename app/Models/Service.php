<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'reservation_id', 'teknisi_id', 'status_perbaikan', 'rentang_tanggal'
    ];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function teknisi()
    {
        return $this->belongsTo(User::class, 'teknisi_id');
    }

    public function diagnosisItems()
    {
        return $this->hasMany(DiagnosisItem::class);
    }

    public function serviceProgresses()
    {
        return $this->hasMany(ServiceProgress::class, 'service_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}