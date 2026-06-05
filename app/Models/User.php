<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_hp',
        'avatar',
        'tanggal_lahir',
        'jenjang',
        'kelas',
        'kota',
        'provinsi',
        'tujuan_belajar',
        'bio',
        'pendidikan',
        'jurusan',
        'tahun_mengajar',
        'mode_mengajar',
        'notif_permintaan_jadwal',
        'notif_pengingat_sesi',
        'notif_pembayaran',
        'notif_ulasan',
        'notif_newsletter',
        'mata_pelajaran_tutor',
        'jenjang_tutor',
        'tarif_per_sesi',
        'maks_siswa_per_hari',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'       => 'datetime',
            'password'                => 'hashed',
            'notif_permintaan_jadwal' => 'boolean',
            'notif_pengingat_sesi'    => 'boolean',
            'notif_pembayaran'        => 'boolean',
            'notif_ulasan'            => 'boolean',
            'notif_newsletter'        => 'boolean',
            'mata_pelajaran_tutor' => 'array',
            'jenjang_tutor'        => 'array',
        ];
    }

    public function hasilLatihan()
    {
        return $this->hasMany(HasilLatihan::class);
    }

    public function aktivitasBelajar()
    {
        return $this->hasMany(AktivitasBelajar::class);
    }

    public function lesPrivat()
    {
        return $this->hasMany(LesPrivat::class);
    }

    public function materi()
    {
        return $this->hasMany(Materi::class, 'tutor_id');
    }

    public function soal()
    {
        return $this->hasMany(Soal::class, 'tutor_id');
    }
    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }
}
