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
        'no_hp',
        'role',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
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
}