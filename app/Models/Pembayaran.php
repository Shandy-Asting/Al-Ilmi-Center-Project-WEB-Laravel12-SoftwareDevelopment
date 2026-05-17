<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasUuids;

    protected $table = 'pembayaran';

    protected $fillable = [
        'les_privat_id',
        'siswa_id',
        'tutor_id',
        'nomor_invoice',
        'jumlah',
        'bank_tujuan',
        'nomor_rekening_tujuan',
        'bukti_transfer',
        'status',
        'catatan_tutor',
        'dikonfirmasi_at',
    ];

    protected $casts = [
        'dikonfirmasi_at' => 'datetime',
    ];

    public function lesPrivat()
    {
        return $this->belongsTo(LesPrivat::class, 'les_privat_id');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function tutor()
    {
        return $this->belongsTo(User::class, 'tutor_id');
    }

    public function getBuktiUrlAttribute(): ?string
    {
        return $this->bukti_transfer ? asset('storage/' . $this->bukti_transfer) : null;
    }

    public static function generateInvoice(): string
    {
        $tahun  = now()->format('Y');
        $bulan  = now()->format('m');
        $urutan = self::whereYear('created_at', $tahun)->whereMonth('created_at', $bulan)->count() + 1;
        return 'INV-' . $tahun . '-' . str_pad($urutan, 4, '0', STR_PAD_LEFT);
    }
}