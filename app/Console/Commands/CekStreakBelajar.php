<?php

namespace App\Console\Commands;

use App\Models\AktivitasBelajar;
use App\Models\User;
use App\Services\NotifikasiService;
use Illuminate\Console\Command;

class CekStreakBelajar extends Command
{
    protected $signature   = 'streak:cek';
    protected $description = 'Cek streak belajar siswa dan kirim notifikasi milestone';

    public function handle(NotifikasiService $service): void
    {
        $siswaList = User::where('role', 'siswa')->get();

        foreach ($siswaList as $siswa) {
            $streak = 0;
            $hari   = now();

            // Hitung streak mundur dari hari ini
            while (true) {
                $ada = AktivitasBelajar::where('user_id', $siswa->id)
                    ->whereDate('tanggal', $hari->toDateString())
                    ->exists();

                if (!$ada) break;
                $streak++;
                $hari->subDay();
            }

            if ($streak > 0) {
                $service->streakBelajar($siswa->id, $streak);
            }
        }

        $this->info('Cek streak selesai.');
    }
}