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
        'topik',
        'catatan',
        'durasi_menit',
        'jadwal',
        'status',
        'mode',
        'lokasi',
        'harga',
        'link_meeting',
        'pembayaran_status',
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

    // Helper status label
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu'     => 'Menunggu Konfirmasi',
            'dikonfirmasi' => 'Dikonfirmasi',
            'selesai'      => 'Selesai',
            'dibatalkan'   => 'Dibatalkan',
            default        => $this->status,
        };
    }

    public function getModeLabel(): string
    {
        return $this->mode === 'online' ? 'Online' : 'Tatap Muka';
    }

    // Scope filter status
    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeDikonfirmasi($query)
    {
        return $query->where('status', 'dikonfirmasi');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }
    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'les_privat_id');
    }

    public function pembayaranTerakhir()
    {
        return $this->hasOne(Pembayaran::class, 'les_privat_id')->latestOfMany();
    }
    public function ulasan()
    {
        return $this->hasOne(\App\Models\Ulasan::class, 'les_privat_id');
    }
}
