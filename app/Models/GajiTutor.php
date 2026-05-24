<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class GajiTutor extends Model
{
    use HasUuids;

    protected $table = 'gaji_tutor';

    protected $fillable = [
        'tutor_id',
        'total_sesi',
        'total_pendapatan',
        'komisi_platform',
        'total_diterima',
        'periode',
        'status',
        'catatan',
        'dikonfirmasi_at',
    ];

    protected $casts = [
        'dikonfirmasi_at' => 'datetime',
    ];

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }
}