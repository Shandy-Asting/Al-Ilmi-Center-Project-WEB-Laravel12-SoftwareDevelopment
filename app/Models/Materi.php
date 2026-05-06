<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';

    // ← TAMBAH INI (karena id pakai UUID)
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'tutor_id',
        'judul',
        'deskripsi',
        'jenjang',
        'mata_pelajaran',
        'kelas',
        'tipe',
        'topik',
        'status',
        'file_path',
        'file_size',
        'link_video',
        'catatan',
    ];

    // ← TAMBAH INI agar UUID di-generate otomatis saat create
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Relasi ke User (tutor)
    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    // Relasi ke Soal
    public function soal()
    {
        return $this->hasMany(Soal::class, 'materi_id');
    }

    // Relasi ke HasilKuis
    public function hasilKuis()
    {
        return $this->hasMany(HasilKuis::class, 'materi_id');
    }

    // Accessor: ikon Bootstrap sesuai tipe
    public function getIkonAttribute(): string
    {
        return match ($this->tipe) {
            'pdf'   => 'bi-file-earmark-pdf-fill',
            'video' => 'bi-camera-video-fill',
            'doc'   => 'bi-file-earmark-word-fill',
            'ppt'   => 'bi-file-earmark-slides-fill',
            'quiz'  => 'bi-patch-question-fill',
            default => 'bi-file-earmark',
        };
    }

    // Accessor: warna background ikon
    public function getWarnaBgAttribute(): string
    {
        return match ($this->tipe) {
            'pdf'   => '#fee2e2',
            'video' => '#dbeafe',
            'doc'   => '#e0f2fe',
            'ppt'   => '#fef3c7',
            'quiz'  => '#dcfce7',
            default => '#f1f5f9',
        };
    }

    // Accessor: warna teks ikon
    public function getWarnaIkonAttribute(): string
    {
        return match ($this->tipe) {
            'pdf'   => '#dc2626',
            'video' => '#2563eb',
            'doc'   => '#0369a1',
            'ppt'   => '#d97706',
            'quiz'  => '#16a34a',
            default => '#64748b',
        };
    }
}