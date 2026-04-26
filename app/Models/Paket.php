<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasUuids;

    protected $table = 'paket';

    protected $fillable = [
        'nama',
        'tipe',
        'harga_min',
        'harga_max',
        'jumlah_soal',
        'jumlah_les',
        'feedback_tutor',
        'akses_penuh',
    ];

    protected $casts = [
        'feedback_tutor' => 'boolean',
        'akses_penuh' => 'boolean',
    ];
}