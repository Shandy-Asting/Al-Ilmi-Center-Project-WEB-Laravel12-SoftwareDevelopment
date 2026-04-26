<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class HasilLatihan extends Model
{
    use HasUuids;

    protected $table = 'hasil_latihan';

    protected $fillable = [
        'user_id',
        'mata_pelajaran',
        'nilai',
        'jumlah_soal',
        'soal_benar',
        'durasi_menit',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}