<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class AktivitasBelajar extends Model
{
    use HasUuids;

    protected $table = 'aktivitas_belajar';

    protected $fillable = [
        'user_id',
        'tanggal',
        'durasi_menit',
        'mata_pelajaran',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}