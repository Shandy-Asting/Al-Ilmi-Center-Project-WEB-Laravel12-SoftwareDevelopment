<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasUuids;

    protected $table = 'ulasan';

    protected $fillable = [
        'les_privat_id',
        'siswa_id',
        'tutor_id',
        'bintang',
        'komentar',
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function lesPrivat()
    {
        return $this->belongsTo(LesPrivat::class, 'les_privat_id');
    }
}