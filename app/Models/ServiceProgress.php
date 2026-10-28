<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProgress extends Model
{
    protected $fillable = [
        'service_id',
        'deskripsi_progres',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}