<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class LesPrivat extends Model
{
    use HasUuids;

    protected $table = 'les_privat';

    protected $fillable = [
        'user_id',
        'tutor_id',
        'mata_pelajaran',
        'jadwal',
        'status',
        'mode',
    ];

    protected $casts = [
        'jadwal' => 'datetime',
    ];

    public function siswa()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }
}