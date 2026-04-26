<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\HasilLatihan;
use App\Models\AktivitasBelajar;
use App\Models\LesPrivat;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        // Buat user siswa
        $siswa = User::create([
            'name' => 'Andi Pratama',
            'email' => 'andi@gmail.com',
            'no_hp' => '081234567890',
            'role' => 'siswa',
            'password' => Hash::make('password123'),
        ]);

        // Buat user tutor
        $tutor = User::create([
            'name' => 'Pak Budi Santoso',
            'email' => 'budi@gmail.com',
            'no_hp' => '089876543210',
            'role' => 'tutor',
            'password' => Hash::make('password123'),
        ]);

        // Hasil latihan
        $mataPelajaran = ['Matematika', 'Fisika', 'Kimia', 'Biologi', 'Bahasa Indonesia'];
        foreach ($mataPelajaran as $mapel) {
            HasilLatihan::create([
                'user_id' => $siswa->id,
                'mata_pelajaran' => $mapel,
                'nilai' => rand(70, 100),
                'jumlah_soal' => 10,
                'soal_benar' => rand(7, 10),
                'durasi_menit' => rand(20, 60),
            ]);
        }

        // Aktivitas belajar 7 hari terakhir
        for ($i = 6; $i >= 0; $i--) {
            AktivitasBelajar::create([
                'user_id' => $siswa->id,
                'tanggal' => now()->subDays($i)->toDateString(),
                'durasi_menit' => rand(30, 120),
                'mata_pelajaran' => $mataPelajaran[array_rand($mataPelajaran)],
            ]);
        }

        // Les privat bulan ini
        for ($i = 0; $i < 3; $i++) {
            LesPrivat::create([
                'user_id' => $siswa->id,
                'tutor_id' => $tutor->id,
                'mata_pelajaran' => $mataPelajaran[array_rand($mataPelajaran)],
                'jadwal' => now()->addDays($i + 1),
                'status' => 'dikonfirmasi',
                'mode' => $i % 2 == 0 ? 'online' : 'tatap_muka',
            ]);
        }
    }
}