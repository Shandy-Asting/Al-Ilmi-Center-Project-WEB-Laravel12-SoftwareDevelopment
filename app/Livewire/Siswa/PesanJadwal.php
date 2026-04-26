<?php

namespace App\Livewire\Siswa;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\LesPrivat;
use App\Models\User;

class PesanJadwal extends Component
{
    public $tutor_id;
    public $mata_pelajaran;
    public $jadwal;
    public $mode;
    public $tutors;
    public $sukses = false;

    protected array $rules = [
        'tutor_id' => 'required|exists:users,id',
        'mata_pelajaran' => 'required|string',
        'jadwal' => 'required|date|after:now',
        'mode' => 'required|in:online,tatap_muka',
    ];

    protected array $messages = [
        'tutor_id.required' => 'Pilih tutor terlebih dahulu.',
        'mata_pelajaran.required' => 'Mata pelajaran wajib diisi.',
        'jadwal.required' => 'Jadwal wajib diisi.',
        'jadwal.after' => 'Jadwal harus lebih dari waktu sekarang.',
        'mode.required' => 'Mode belajar wajib dipilih.',
    ];

    public function mount()
    {
        $this->tutors = User::where('role', 'tutor')->get();
    }

    public function pesan()
    {
        $this->validate();

        LesPrivat::create([
            'user_id' => Auth::user()->id,
            'tutor_id' => $this->tutor_id,
            'mata_pelajaran' => $this->mata_pelajaran,
            'jadwal' => $this->jadwal,
            'status' => 'menunggu',
            'mode' => $this->mode,
        ]);

        $this->sukses = true;
        $this->reset(['tutor_id', 'mata_pelajaran', 'jadwal', 'mode']);
    }

    public function render()
    {
        return view('livewire.siswa.pesan-jadwal')
            ->layout('layouts.app', [
                'title' => 'Pesan Jadwal Les',
            ]);
    }
}