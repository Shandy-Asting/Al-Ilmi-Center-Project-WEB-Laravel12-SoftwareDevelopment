<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HasilLatihan extends Model
{
    protected $table = 'hasil_latihan';

    protected $fillable = [
        'user_id',
        'mata_pelajaran',
        'nilai',
        'jumlah_soal',
        'soal_benar',
        'durasi_menit',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}