<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasUuids;

    protected $table = 'notifikasi';

    protected $fillable = [
        'user_id', 'judul', 'pesan', 'tipe',
        'ikon', 'warna', 'url_aksi', 'label_aksi',
        'sudah_dibaca', 'referensi_id', 'referensi_tipe',
    ];

    protected $casts = [
        'sudah_dibaca' => 'boolean',
        'created_at'   => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ── Scopes ──────────────────────────────
    public function scopeUntukUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeBelumDibaca($query)
    {
        return $query->where('sudah_dibaca', false);
    }

    public function scopeTipe($query, string $tipe)
    {
        return $query->where('tipe', $tipe);
    }

    // ── Helper ──────────────────────────────
    public function tandaiDibaca(): void
    {
        if (!$this->sudah_dibaca) {
            $this->update(['sudah_dibaca' => true]);
        }
    }
}