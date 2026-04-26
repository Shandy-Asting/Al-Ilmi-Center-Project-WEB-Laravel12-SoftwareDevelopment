<?php

namespace App\Livewire\Siswa;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\HasilLatihan;
use App\Models\AktivitasBelajar;
use App\Models\LesPrivat;

class Dashboard extends Component
{
    public $namaUser;
    public $rataRataNilai;
    public $soalDiselesaikan;
    public $jamBelajar;
    public $lesPrivat;

    public function mount()
    {
        $user = Auth::user();
        $this->namaUser = $user->name;

        $this->rataRataNilai = HasilLatihan::where('user_id', $user->id)->avg('nilai') ?? 0;
        $this->soalDiselesaikan = HasilLatihan::where('user_id', $user->id)->sum('soal_benar') ?? 0;
        $this->jamBelajar = round(AktivitasBelajar::where('user_id', $user->id)->sum('durasi_menit') / 60, 1) ?? 0;
        $this->lesPrivat = LesPrivat::where('user_id', $user->id)->whereMonth('created_at', now()->month)->count() ?? 0;
    }

    public function render()
    {
        return view('siswa.dashboard', [
            'namaUser' => $this->namaUser,
            'rataRataNilai' => $this->rataRataNilai,
            'soalDiselesaikan' => $this->soalDiselesaikan,
            'jamBelajar' => $this->jamBelajar,
            'lesPrivat' => $this->lesPrivat,
        ]);
    }
}