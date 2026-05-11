<?php

namespace App\Livewire\Siswa;

use App\Models\Notifikasi as NotifikasiModel;
use Livewire\Component;

class Notifikasi extends Component
{
    public string $filterAktif = 'semua';
    public int $totalLoad = 10;
    public int $perPage = 10;

    public array $filterList = [
        'semua'      => 'Semua',
        'belum'      => 'Belum Dibaca',
        'les_privat' => 'Les Privat',
        'pembayaran' => 'Pembayaran',
        'belajar'    => 'Belajar',
        'sistem'     => 'Sistem',
    ];

    public function getJumlahBelumDibacaProperty(): int
    {
        return NotifikasiModel::untukUser(auth()->id())->belumDibaca()->count();
    }

    public function getNotifikasiProperty()
    {
        $query = NotifikasiModel::untukUser(auth()->id())->orderBy('created_at', 'desc');

        if ($this->filterAktif === 'belum') {
            $query->belumDibaca();
        } elseif ($this->filterAktif !== 'semua') {
            $query->tipe($this->filterAktif);
        }

        return $query->take($this->totalLoad)->get();
    }

    public function getTotalNotifikasiProperty(): int
    {
        $query = NotifikasiModel::untukUser(auth()->id());

        if ($this->filterAktif === 'belum') {
            $query->belumDibaca();
        } elseif ($this->filterAktif !== 'semua') {
            $query->tipe($this->filterAktif);
        }

        return $query->count();
    }

    public function getNotifikasiGroupProperty(): array
    {
        $semua = $this->notifikasi;
        return [
            'hariIni'   => $semua->filter(fn($n) => $n->created_at->isToday()),
            'kemarin'   => $semua->filter(fn($n) => $n->created_at->isYesterday()),
            'mingguIni' => $semua->filter(fn($n) => !$n->created_at->isToday() && !$n->created_at->isYesterday() && $n->created_at->diffInDays(now()) <= 7),
            'lebihLama' => $semua->filter(fn($n) => $n->created_at->diffInDays(now()) > 7),
        ];
    }

    public function setFilter(string $filter): void
    {
        $this->filterAktif = $filter;
        $this->totalLoad   = $this->perPage;
    }

    public function tandaiDanBuka(string $id): void
    {
        $notif = NotifikasiModel::untukUser(auth()->id())->findOrFail($id);
        $notif->tandaiDibaca();
        if ($notif->url_aksi) {
            $this->redirect($notif->url_aksi);
        }
    }

    public function tandaiSemuaDibaca(): void
    {
        NotifikasiModel::untukUser(auth()->id())->belumDibaca()->update(['sudah_dibaca' => true]);
    }

    public function muatLebih(): void
    {
        $this->totalLoad += $this->perPage;
    }

    public function hapus(string $id): void
    {
        NotifikasiModel::untukUser(auth()->id())->where('id', $id)->delete();
    }

    public function render()
    {
        return view('livewire.siswa.notifikasi', [
            'jumlahBelumDibaca' => $this->jumlahBelumDibaca,
            'notifikasiGroup'   => $this->notifikasiGroup,
            'adaLebih'          => $this->totalLoad < $this->totalNotifikasi,
        ]);
    }
}