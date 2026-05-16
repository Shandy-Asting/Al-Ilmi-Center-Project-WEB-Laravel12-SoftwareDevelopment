<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class RekeningBank extends Model
{
    use HasUuids;
    protected $table = 'rekening_banks';
    protected $fillable = ['nama_bank', 'nomor_rekening', 'atas_nama', 'logo_bank', 'aktif'];
    protected $casts = ['aktif' => 'boolean'];
}