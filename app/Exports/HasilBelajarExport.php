<?php

namespace App\Exports;

use App\Models\HasilLatihan;
use App\Models\AktivitasBelajar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HasilBelajarExport implements FromCollection, WithHeadings, WithTitle, WithStyles
{
    protected $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function collection()
    {
        return HasilLatihan::where('user_id', $this->userId)
            ->get()
            ->map(function ($item, $index) {
                return [
                    'No' => $index + 1,
                    'Mata Pelajaran' => $item->mata_pelajaran,
                    'Nilai' => $item->nilai,
                    'Jumlah Soal' => $item->jumlah_soal,
                    'Soal Benar' => $item->soal_benar,
                    'Durasi (menit)' => $item->durasi_menit,
                    'Tanggal' => $item->created_at->format('d M Y'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'No',
            'Mata Pelajaran',
            'Nilai',
            'Jumlah Soal',
            'Soal Benar',
            'Durasi (menit)',
            'Tanggal',
        ];
    }

    public function title(): string
    {
        return 'Hasil Belajar';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1e3a5f'],
                ],
                'font' => ['color' => ['rgb' => 'FFFFFF'], 'bold' => true],
            ],
        ];
    }
}