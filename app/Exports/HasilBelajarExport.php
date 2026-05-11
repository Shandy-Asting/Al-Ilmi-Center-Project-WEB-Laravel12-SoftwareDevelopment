<?php

namespace App\Exports;

use App\Models\HasilKuis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class HasilBelajarExport implements WithMultipleSheets
{
    protected $userId;
    protected $periode;
    protected $labelPeriode;
    protected $startDate;
    protected $endDate;
    protected $hasilKuis;

    public function __construct($userId, $periode = 'bulan_ini')
    {
        $this->userId  = $userId;
        $this->periode = $periode;
        $this->endDate = Carbon::now();

        switch ($periode) {
            case '3_bulan':
                $this->startDate    = Carbon::now()->subMonths(3)->startOfDay();
                $this->labelPeriode = '3 Bulan Terakhir';
                break;
            case '6_bulan':
                $this->startDate    = Carbon::now()->subMonths(6)->startOfDay();
                $this->labelPeriode = '6 Bulan Terakhir';
                break;
            case 'semua':
                $this->startDate    = null;
                $this->labelPeriode = 'Semua Waktu';
                break;
            default:
                $this->startDate    = Carbon::now()->startOfMonth();
                $this->labelPeriode = 'Bulan ' . Carbon::now()->translatedFormat('F Y');
                break;
        }

        $query = HasilKuis::where('user_id', $userId)
            ->with('materi')
            ->orderBy('created_at', 'desc');

        if ($this->startDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        $this->hasilKuis = $query->get();
    }

    public function sheets(): array
    {
        return [
            new DetailSheet($this->hasilKuis, $this->labelPeriode),
            new RingkasanSheet($this->hasilKuis, $this->labelPeriode),
        ];
    }
}

// ── Sheet 1: Detail ──
class DetailSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    protected $data;
    protected $label;

    public function __construct($data, $label)
    {
        $this->data  = $data;
        $this->label = $label;
    }

    public function collection()
    {
        return $this->data->map(function ($item, $index) {
            $akurasi  = $item->total_soal > 0
                ? round(($item->soal_benar / $item->total_soal) * 100) . '%'
                : '0%';
            $ket      = $item->nilai >= 80 ? 'Baik' : ($item->nilai >= 60 ? 'Cukup' : 'Perlu Belajar');
            $grade    = $item->nilai >= 87 ? 'A' : ($item->nilai >= 70 ? 'B' : ($item->nilai >= 55 ? 'C' : 'D'));

            return [
                'No'              => $index + 1,
                'Mata Pelajaran'  => $item->materi->mata_pelajaran ?? '-',
                'Judul Materi'    => $item->materi->judul ?? '-',
                'Tipe'            => ucfirst($item->tipe),
                'Nilai'           => $item->nilai,
                'Grade'           => $grade,
                'Benar'           => $item->soal_benar,
                'Total Soal'      => $item->total_soal,
                'Akurasi'         => $akurasi,
                'Durasi (menit)'  => $item->durasi_menit,
                'Keterangan'      => $ket,
                'Tanggal'         => $item->created_at->format('d M Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No', 'Mata Pelajaran', 'Judul Materi', 'Tipe',
            'Nilai', 'Grade', 'Benar', 'Total Soal',
            'Akurasi', 'Durasi (menit)', 'Keterangan', 'Tanggal',
        ];
    }

    public function title(): string { return 'Detail Hasil'; }

    public function columnWidths(): array
    {
        return [
            'A' => 5,  'B' => 18, 'C' => 28, 'D' => 10,
            'E' => 8,  'F' => 8,  'G' => 8,  'H' => 10,
            'I' => 10, 'J' => 15, 'K' => 16, 'L' => 20,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $this->data->count() + 4;

        // Sisipkan 3 baris info di atas
        $sheet->insertNewRowBefore(1, 3);
        $sheet->setCellValue('A1', 'Al Ilmi Center — Laporan Hasil Belajar');
        $sheet->setCellValue('A2', 'Periode: ' . $this->label . '  |  Dicetak: ' . now()->format('d M Y H:i'));
        $sheet->setCellValue('A3', 'Sheet: Detail Semua Pengerjaan');
        $sheet->mergeCells('A1:L1');
        $sheet->mergeCells('A2:L2');
        $sheet->mergeCells('A3:L3');

        return [
            1 => [
                'font' => ['bold' => true, 'size' => 13, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1e3a5f']],
                'alignment' => ['horizontal' => 'center'],
            ],
            2 => [
                'font' => ['italic' => true, 'color' => ['rgb' => '1e3a5f']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'dbeafe']],
                'alignment' => ['horizontal' => 'center'],
            ],
            3 => [
                'font' => ['color' => ['rgb' => '64748b'], 'size' => 9],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'f1f5f9']],
                'alignment' => ['horizontal' => 'center'],
            ],
            4 => [ // header kolom
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1e3a5f']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}

// ── Sheet 2: Ringkasan Per Mapel ──
class RingkasanSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, WithColumnWidths
{
    protected $data;
    protected $label;

    public function __construct($data, $label)
    {
        $this->data  = $data;
        $this->label = $label;
    }

    public function collection()
    {
        $perMapel = $this->data
            ->groupBy(fn($h) => $h->materi->mata_pelajaran ?? 'Lainnya');

        return $perMapel->map(function ($list, $mapel) {
            $rata       = round($list->avg('nilai'));
            $totalSoal  = $list->sum('total_soal');
            $totalBenar = $list->sum('soal_benar');
            $akurasi    = $totalSoal > 0 ? round($totalBenar / $totalSoal * 100) . '%' : '0%';
            $tren       = $rata >= 80 ? 'Bagus' : ($rata >= 60 ? 'Stabil' : 'Butuh Perhatian');

            return [
                'Mata Pelajaran'  => $mapel,
                'Total Latihan'   => $list->count(),
                'Rata-rata Nilai' => $rata,
                'Nilai Tertinggi' => $list->max('nilai'),
                'Nilai Terendah'  => $list->min('nilai'),
                'Total Soal'      => $totalSoal,
                'Total Benar'     => $totalBenar,
                'Akurasi'         => $akurasi,
                'Tren'            => $tren,
            ];
        })->values();
    }

    public function headings(): array
    {
        return [
            'Mata Pelajaran', 'Total Latihan', 'Rata-rata Nilai',
            'Nilai Tertinggi', 'Nilai Terendah', 'Total Soal',
            'Total Benar', 'Akurasi', 'Tren',
        ];
    }

    public function title(): string { return 'Ringkasan per Mapel'; }

    public function columnWidths(): array
    {
        return [
            'A' => 20, 'B' => 14, 'C' => 16,
            'D' => 16, 'E' => 14, 'F' => 12,
            'G' => 12, 'H' => 10, 'I' => 18,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->insertNewRowBefore(1, 3);
        $sheet->setCellValue('A1', 'Al Ilmi Center — Ringkasan Per Mata Pelajaran');
        $sheet->setCellValue('A2', 'Periode: ' . $this->label . '  |  Dicetak: ' . now()->format('d M Y H:i'));
        $sheet->setCellValue('A3', 'Sheet: Ringkasan per Mata Pelajaran');
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A3:I3');

        return [
            1 => [
                'font' => ['bold' => true, 'size' => 13, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1e3a5f']],
                'alignment' => ['horizontal' => 'center'],
            ],
            2 => [
                'font' => ['italic' => true, 'color' => ['rgb' => '1e3a5f']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'dbeafe']],
                'alignment' => ['horizontal' => 'center'],
            ],
            3 => [
                'font' => ['color' => ['rgb' => '64748b'], 'size' => 9],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'f1f5f9']],
                'alignment' => ['horizontal' => 'center'],
            ],
            4 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '1e3a5f']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }
}