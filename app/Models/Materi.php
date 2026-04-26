<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasUuids;

    protected $table = 'materi';

    protected $fillable = [
        'tutor_id',
        'judul',
        'jenjang',
        'mata_pelajaran',
        'kelas',
        'deskripsi',
        'status',
    ];

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function soal()
    {
        return $this->hasMany(Soal::class);
    }
}