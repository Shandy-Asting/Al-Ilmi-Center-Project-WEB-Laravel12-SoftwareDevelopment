<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paket;

class PaketSeeder extends Seeder
{
    public function run(): void
    {
        Paket::create([
            'nama' => 'Paket SD',
            'tipe' => 'sd',
            'harga_min' => 25000,
            'harga_max' => null,
            'jumlah_soal' => 30,
            'jumlah_les' => 2,
            'feedback_tutor' => false,
            'akses_penuh' => false,
        ]);

        Paket::create([
            'nama' => 'Paket SMP',
            'tipe' => 'smp',
            'harga_min' => 45000,
            'harga_max' => null,
            'jumlah_soal' => 50,
            'jumlah_les' => 3,
            'feedback_tutor' => true,
            'akses_penuh' => false,
        ]);

        Paket::create([
            'nama' => 'Paket SMA',
            'tipe' => 'sma',
            'harga_min' => 60000,
            'harga_max' => 80000,
            'jumlah_soal' => 100,
            'jumlah_les' => 4,
            'feedback_tutor' => true,
            'akses_penuh' => true,
        ]);
    }
}