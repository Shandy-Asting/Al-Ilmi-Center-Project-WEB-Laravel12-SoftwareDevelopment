<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasUuids;

    protected $table = 'soal';

    protected $fillable = [
        'materi_id',
        'tutor_id',
        'pertanyaan',
        'pilihan_a',
        'pilihan_b',
        'pilihan_c',
        'pilihan_d',
        'jawaban_benar',
        'pembahasan',
        'tingkat_kesulitan',
    ];

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }
}