<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HasilKuis extends Model
{
    protected $table = 'hasil_kuis';

    protected $fillable = [
        'id',        // ← tambah ini
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

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class, 'materi_id');
    }
}
