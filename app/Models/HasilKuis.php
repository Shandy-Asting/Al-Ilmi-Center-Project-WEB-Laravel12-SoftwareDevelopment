<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class HasilKuis extends Model
{
    use HasUuids;

    protected $table = 'hasil_kuis';

    protected $fillable = [
        'user_id',
        'materi_id',
        'nilai',
        'soal_benar',
        'soal_salah',
        'total_soal',
        'durasi_menit',
        'tipe',
        'jawaban',
    ];

    protected $casts = [
        'jawaban' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }
}