<?php

namespace App\Services;

use App\Models\LesPrivat;
use App\Models\Materi;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Support\Str;

class NotifikasiService
{
    // Dipanggil saat tutor konfirmasi les
    public function jadwalDikonfirmasi(LesPrivat $les): void
    {
        $jadwal = \Carbon\Carbon::parse($les->jadwal)->translatedFormat('l, d F Y · H:i') . ' WIB';
        Notifikasi::create([
            'user_id'        => $les->user_id,
            'judul'          => '✅ Jadwal Les Dikonfirmasi',
            'pesan'          => "Les privat {$les->mata_pelajaran} dengan <strong>{$les->tutor->name}</strong> pada <strong>{$jadwal}</strong> telah dikonfirmasi. Siapkan dirimu ya!",
            'tipe'           => 'les_privat',
            'ikon'           => 'bi-calendar-check-fill',
            'warna'          => 'success',
            'url_aksi'       => '/siswa/les-privat/' . $les->id,
            'label_aksi'     => 'Lihat Detail',
            'referensi_id'   => $les->id,
            'referensi_tipe' => LesPrivat::class,
        ]);
    }

    // Dipanggil saat tutor tolak/batalkan les
    public function jadwalDibatalkan(LesPrivat $les): void
    {
        Notifikasi::create([
            'user_id'        => $les->user_id,
            'judul'          => '❌ Jadwal Les Dibatalkan',
            'pesan'          => "Maaf, les privat <strong>{$les->mata_pelajaran}</strong> dengan {$les->tutor->name} telah dibatalkan.",
            'tipe'           => 'les_privat',
            'ikon'           => 'bi-calendar-x-fill',
            'warna'          => 'danger',
            'url_aksi'       => '/siswa/les-privat',
            'label_aksi'     => 'Pesan Ulang',
            'referensi_id'   => $les->id,
            'referensi_tipe' => LesPrivat::class,
        ]);
    }

    // Dipanggil saat les ditandai selesai → minta ulasan
    public function mintaUlasan(LesPrivat $les): void
    {
        Notifikasi::create([
            'user_id'        => $les->user_id,
            'judul'          => '⭐ Beri Ulasan Sesi Belajar',
            'pesan'          => "Bagaimana sesi {$les->mata_pelajaran} dengan <strong>{$les->tutor->name}</strong>? Berikan ulasan untuk membantu tutor berkembang!",
            'tipe'           => 'ulasan',
            'ikon'           => 'bi-star-fill',
            'warna'          => 'warning',
            'url_aksi'       => '/siswa/les-privat',
            'label_aksi'     => 'Beri Ulasan',
            'referensi_id'   => $les->id,
            'referensi_tipe' => LesPrivat::class,
        ]);
    }

    // Dipanggil saat pembayaran berhasil
    public function pembayaranBerhasil(LesPrivat $les, string $metode = 'Transfer'): void
    {
        $harga = 'Rp ' . number_format($les->harga, 0, ',', '.');
        Notifikasi::create([
            'user_id'        => $les->user_id,
            'judul'          => '✅ Pembayaran Berhasil',
            'pesan'          => "Pembayaran <strong>{$harga}</strong> untuk les privat {$les->mata_pelajaran} dengan {$les->tutor->name} telah berhasil diproses via <strong>{$metode}</strong>.",
            'tipe'           => 'pembayaran',
            'ikon'           => 'bi-check-circle-fill',
            'warna'          => 'success',
            'url_aksi'       => '/siswa/pembayaran',
            'label_aksi'     => 'Lihat Invoice',
            'referensi_id'   => $les->id,
            'referensi_tipe' => LesPrivat::class,
        ]);
    }

    // Dipanggil saat nilai kuis tersimpan
    public function nilaiKuis(\App\Models\HasilKuis $hasil): void
    {
        $nilaiLabel = $hasil->nilai >= 90 ? "{$hasil->nilai}/100 — Sempurna! 🎉"
            : ($hasil->nilai >= 70 ? "{$hasil->nilai}/100 — Bagus!" : "{$hasil->nilai}/100 — Terus semangat!");

        Notifikasi::create([
            'user_id'        => $hasil->user_id,
            'judul'          => '🏆 Nilai Kuis Diterbitkan',
            'pesan'          => "Hasil kuis <strong>\"{$hasil->materi->judul}\"</strong> telah tersedia. Kamu mendapat nilai <strong>{$nilaiLabel}</strong>",
            'tipe'           => 'belajar',
            'ikon'           => 'bi-trophy-fill',
            'warna'          => 'success',
            'url_aksi'       => "/siswa/belajar-tka/{$hasil->materi_id}/hasil/{$hasil->id}",
            'label_aksi'     => 'Lihat Hasil',
            'referensi_id'   => $hasil->id,
            'referensi_tipe' => \App\Models\HasilKuis::class,
        ]);
    }

    // Dipanggil saat tutor upload materi baru → broadcast ke semua siswa
    public function materiBaru(Materi $materi): void
    {
        $siswaList = User::where('role', 'siswa')->pluck('id');
        $rows = $siswaList->map(fn($userId) => [
            'id'             => (string) Str::uuid(),
            'user_id'        => $userId,
            'judul'          => '📚 Materi Baru Tersedia!',
            'pesan'          => "Tutor <strong>{$materi->tutor->name}</strong> mengunggah materi baru <strong>\"{$materi->judul}\"</strong>. Yuk mulai belajar!",
            'tipe'           => 'belajar',
            'ikon'           => 'bi-book-fill',
            'warna'          => 'primary',
            'url_aksi'       => '/siswa/belajar-tka',
            'label_aksi'     => 'Buka Materi',
            'referensi_id'   => $materi->id,
            'referensi_tipe' => Materi::class,
            'sudah_dibaca'   => false,
            'created_at'     => now(),
            'updated_at'     => now(),
        ])->toArray();

        foreach (array_chunk($rows, 100) as $chunk) {
            Notifikasi::insert($chunk);
        }
    }

    // Dipanggil saat register berhasil
    public function selamatDatang(User $user): void
    {
        Notifikasi::create([
            'user_id'    => $user->id,
            'judul'      => '👋 Selamat Datang di Al Ilmi Center!',
            'pesan'      => 'Akun kamu berhasil diverifikasi. Mulai perjalanan belajarmu sekarang — latihan soal TKA, les privat, dan pantau progresmu!',
            'tipe'       => 'sistem',
            'ikon'       => 'bi-person-check-fill',
            'warna'      => 'primary',
            'url_aksi'   => '/siswa/belajar-tka',
            'label_aksi' => 'Mulai Belajar',
        ]);
    }

    // Dipanggil dari scheduler harian untuk cek streak
    public function streakBelajar(string $userId, int $hari): void
    {
        if (!in_array($hari, [3, 5, 7, 14, 30])) return;

        Notifikasi::create([
            'user_id'    => $userId,
            'judul'      => "⚡ Streak Belajar {$hari} Hari!",
            'pesan'      => "Keren! Kamu sudah belajar <strong>{$hari} hari berturut-turut</strong>. Pertahankan streak-mu dan dapatkan badge \"Rajin Belajar\"!",
            'tipe'       => 'streak',
            'ikon'       => 'bi-lightning-charge-fill',
            'warna'      => 'info',
            'url_aksi'   => '/siswa/hasil-progres',
            'label_aksi' => 'Lihat Badge',
        ]);
    }
}