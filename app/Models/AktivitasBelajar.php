<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AktivitasBelajar extends Model
{
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