<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id', 'device_id', 'keluhan_awal', 'jenis_service', 'tiket', 'tanggal', 'waktu', 'no_antrian', 'status_reservasi'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function service()
    {
        return $this->hasOne(Service::class);
    }
}