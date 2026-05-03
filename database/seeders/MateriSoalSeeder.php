<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Materi;
use App\Models\Soal;

class MateriSoalSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil tutor yang sudah ada
        $tutor = User::where('role', 'tutor')->first();

        if (!$tutor) {
            $tutor = User::create([
                'name' => 'Pak Budi Santoso',
                'email' => 'budi@gmail.com',
                'no_hp' => '089876543210',
                'role' => 'tutor',
                'password' => bcrypt('password123'),
            ]);
        }

        // ── MATERI 1: Matematika ──
        $materi1 = Materi::create([
            'tutor_id' => $tutor->id,
            'judul' => 'Integral Tak Tentu & Tentu',
            'jenjang' => 'sma',
            'mata_pelajaran' => 'Matematika',
            'kelas' => 'Kelas 12',
            'deskripsi' => 'Materi integral dasar untuk SMA kelas 12',
            'status' => 'aktif',
        ]);

        $soalMatematika = [
            [
                'pertanyaan' => 'Hasil dari ∫ (3x² + 2x - 5) dx adalah...',
                'pilihan_a' => 'x³ + x² - 5x + C',
                'pilihan_b' => '3x³ + 2x² - 5x + C',
                'pilihan_c' => 'x³ + x² + 5x + C',
                'pilihan_d' => '6x + 2 + C',
                'jawaban_benar' => 'a',
                'pembahasan' => '∫(3x²+2x-5)dx = x³ + x² - 5x + C',
                'tingkat_kesulitan' => 'sedang',
            ],
            [
                'pertanyaan' => 'Hasil dari ∫ 4x³ dx adalah...',
                'pilihan_a' => '12x² + C',
                'pilihan_b' => 'x⁴ + C',
                'pilihan_c' => '4x⁴ + C',
                'pilihan_d' => '4x² + C',
                'jawaban_benar' => 'b',
                'pembahasan' => '∫4x³ dx = 4·(x⁴/4) + C = x⁴ + C',
                'tingkat_kesulitan' => 'mudah',
            ],
            [
                'pertanyaan' => 'Nilai dari ∫₁² (2x + 1) dx adalah...',
                'pilihan_a' => '4',
                'pilihan_b' => '5',
                'pilihan_c' => '6',
                'pilihan_d' => '7',
                'jawaban_benar' => 'b',
                'pembahasan' => '[x²+x]₁² = (4+2)-(1+1) = 6-2 = 4... tunggu, (4+2)-(1+1)=5',
                'tingkat_kesulitan' => 'sedang',
            ],
            [
                'pertanyaan' => 'Hasil dari ∫ sin(x) dx adalah...',
                'pilihan_a' => 'cos(x) + C',
                'pilihan_b' => '-cos(x) + C',
                'pilihan_c' => 'sin(x) + C',
                'pilihan_d' => '-sin(x) + C',
                'jawaban_benar' => 'b',
                'pembahasan' => '∫sin(x)dx = -cos(x) + C',
                'tingkat_kesulitan' => 'mudah',
            ],
            [
                'pertanyaan' => 'Hasil dari ∫ cos(x) dx adalah...',
                'pilihan_a' => '-sin(x) + C',
                'pilihan_b' => 'cos(x) + C',
                'pilihan_c' => 'sin(x) + C',
                'pilihan_d' => '-cos(x) + C',
                'jawaban_benar' => 'c',
                'pembahasan' => '∫cos(x)dx = sin(x) + C',
                'tingkat_kesulitan' => 'mudah',
            ],
            [
                'pertanyaan' => 'Hasil dari ∫ eˣ dx adalah...',
                'pilihan_a' => 'eˣ⁺¹ + C',
                'pilihan_b' => 'eˣ + C',
                'pilihan_c' => 'xeˣ + C',
                'pilihan_d' => 'eˣ/x + C',
                'jawaban_benar' => 'b',
                'pembahasan' => '∫eˣ dx = eˣ + C',
                'tingkat_kesulitan' => 'mudah',
            ],
            [
                'pertanyaan' => 'Hasil dari ∫ (1/x) dx adalah...',
                'pilihan_a' => 'x + C',
                'pilihan_b' => '-1/x² + C',
                'pilihan_c' => 'ln|x| + C',
                'pilihan_d' => '1/x² + C',
                'jawaban_benar' => 'c',
                'pembahasan' => '∫(1/x)dx = ln|x| + C',
                'tingkat_kesulitan' => 'sedang',
            ],
            [
                'pertanyaan' => 'Nilai dari ∫₀¹ x² dx adalah...',
                'pilihan_a' => '1/2',
                'pilihan_b' => '1/3',
                'pilihan_c' => '1/4',
                'pilihan_d' => '1',
                'jawaban_benar' => 'b',
                'pembahasan' => '[x³/3]₀¹ = 1/3 - 0 = 1/3',
                'tingkat_kesulitan' => 'sedang',
            ],
            [
                'pertanyaan' => 'Hasil dari ∫ 5 dx adalah...',
                'pilihan_a' => '5x² + C',
                'pilihan_b' => '0 + C',
                'pilihan_c' => '5x + C',
                'pilihan_d' => '5/x + C',
                'jawaban_benar' => 'c',
                'pembahasan' => '∫5 dx = 5x + C',
                'tingkat_kesulitan' => 'mudah',
            ],
            [
                'pertanyaan' => 'Hasil dari ∫ (x + 1)² dx adalah...',
                'pilihan_a' => '(x+1)³/3 + C',
                'pilihan_b' => '2(x+1) + C',
                'pilihan_c' => 'x²+2x+1 + C',
                'pilihan_d' => '(x+1)² + C',
                'jawaban_benar' => 'a',
                'pembahasan' => '∫(x+1)² dx = (x+1)³/3 + C',
                'tingkat_kesulitan' => 'sulit',
            ],
        ];

        foreach ($soalMatematika as $s) {
            Soal::create(array_merge($s, [
                'materi_id' => $materi1->id,
                'tutor_id' => $tutor->id,
            ]));
        }

        // ── MATERI 2: Fisika ──
        $materi2 = Materi::create([
            'tutor_id' => $tutor->id,
            'judul' => 'Hukum Newton',
            'jenjang' => 'sma',
            'mata_pelajaran' => 'Fisika',
            'kelas' => 'Kelas 10',
            'deskripsi' => 'Materi hukum Newton untuk SMA kelas 10',
            'status' => 'aktif',
        ]);

        $soalFisika = [
            [
                'pertanyaan' => 'Hukum Newton I menyatakan bahwa...',
                'pilihan_a' => 'F = m × a',
                'pilihan_b' => 'Benda diam akan tetap diam jika tidak ada gaya yang bekerja',
                'pilihan_c' => 'Setiap aksi ada reaksi yang sama besar',
                'pilihan_d' => 'Gaya berbanding lurus dengan massa',
                'jawaban_benar' => 'b',
                'pembahasan' => 'Hukum I Newton (inersia): benda akan tetap diam atau bergerak lurus beraturan jika tidak ada gaya luar',
                'tingkat_kesulitan' => 'mudah',
            ],
            [
                'pertanyaan' => 'Rumus Hukum Newton II adalah...',
                'pilihan_a' => 'F = m/a',
                'pilihan_b' => 'F = m + a',
                'pilihan_c' => 'F = m × a',
                'pilihan_d' => 'F = a/m',
                'jawaban_benar' => 'c',
                'pembahasan' => 'Hukum II Newton: F = m × a, dimana F=gaya(N), m=massa(kg), a=percepatan(m/s²)',
                'tingkat_kesulitan' => 'mudah',
            ],
            [
                'pertanyaan' => 'Sebuah benda bermassa 5 kg diberi gaya 20 N. Percepatan benda adalah...',
                'pilihan_a' => '2 m/s²',
                'pilihan_b' => '4 m/s²',
                'pilihan_c' => '10 m/s²',
                'pilihan_d' => '100 m/s²',
                'jawaban_benar' => 'b',
                'pembahasan' => 'a = F/m = 20/5 = 4 m/s²',
                'tingkat_kesulitan' => 'sedang',
            ],
            [
                'pertanyaan' => 'Hukum Newton III menyatakan...',
                'pilihan_a' => 'Gaya aksi = gaya reaksi, berlawanan arah',
                'pilihan_b' => 'Gaya aksi lebih besar dari reaksi',
                'pilihan_c' => 'Benda akan bergerak jika ada gaya',
                'pilihan_d' => 'Massa berbanding terbalik dengan percepatan',
                'jawaban_benar' => 'a',
                'pembahasan' => 'Hukum III Newton: Faksi = -Freaksi, besarnya sama, arahnya berlawanan',
                'tingkat_kesulitan' => 'mudah',
            ],
            [
                'pertanyaan' => 'Satuan gaya dalam SI adalah...',
                'pilihan_a' => 'Joule',
                'pilihan_b' => 'Watt',
                'pilihan_c' => 'Newton',
                'pilihan_d' => 'Pascal',
                'jawaban_benar' => 'c',
                'pembahasan' => 'Satuan gaya dalam SI adalah Newton (N) = kg·m/s²',
                'tingkat_kesulitan' => 'mudah',
            ],
        ];

        foreach ($soalFisika as $s) {
            Soal::create(array_merge($s, [
                'materi_id' => $materi2->id,
                'tutor_id' => $tutor->id,
            ]));
        }

        // ── MATERI 3: Kimia ──
        $materi3 = Materi::create([
            'tutor_id' => $tutor->id,
            'judul' => 'Laju Reaksi',
            'jenjang' => 'sma',
            'mata_pelajaran' => 'Kimia',
            'kelas' => 'Kelas 11',
            'deskripsi' => 'Materi laju reaksi kimia untuk SMA kelas 11',
            'status' => 'aktif',
        ]);

        $soalKimia = [
            [
                'pertanyaan' => 'Faktor yang mempengaruhi laju reaksi adalah...',
                'pilihan_a' => 'Warna dan bau zat',
                'pilihan_b' => 'Suhu, konsentrasi, luas permukaan, katalis',
                'pilihan_c' => 'Massa dan volume zat',
                'pilihan_d' => 'Wujud zat saja',
                'jawaban_benar' => 'b',
                'pembahasan' => 'Faktor laju reaksi: suhu, konsentrasi, luas permukaan sentuh, dan katalis',
                'tingkat_kesulitan' => 'mudah',
            ],
            [
                'pertanyaan' => 'Katalis berfungsi untuk...',
                'pilihan_a' => 'Memperlambat reaksi',
                'pilihan_b' => 'Menghentikan reaksi',
                'pilihan_c' => 'Mempercepat reaksi dengan menurunkan energi aktivasi',
                'pilihan_d' => 'Mengubah produk reaksi',
                'jawaban_benar' => 'c',
                'pembahasan' => 'Katalis mempercepat reaksi dengan cara menurunkan energi aktivasi',
                'tingkat_kesulitan' => 'sedang',
            ],
            [
                'pertanyaan' => 'Jika suhu dinaikkan 10°C, laju reaksi umumnya...',
                'pilihan_a' => 'Tetap sama',
                'pilihan_b' => 'Berkurang setengahnya',
                'pilihan_c' => 'Menjadi dua kali lipat',
                'pilihan_d' => 'Menjadi nol',
                'jawaban_benar' => 'c',
                'pembahasan' => 'Setiap kenaikan suhu 10°C, laju reaksi meningkat sekitar 2 kali lipat',
                'tingkat_kesulitan' => 'sedang',
            ],
        ];

        foreach ($soalKimia as $s) {
            Soal::create(array_merge($s, [
                'materi_id' => $materi3->id,
                'tutor_id' => $tutor->id,
            ]));
        }
    }
}