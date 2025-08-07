<?php

namespace App\Exports;

use App\Models\PlFti;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PlFtiExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $no = 1;

    public function collection()
    {
        return PlFti::all();
    }

    public function headings(): array
    {
        return [
            ['LAPORAN PROFIL LULUSAN PROGRAM STUDI UCIC'],
            ['Tanggal Cetak: ' . now()->format('d/m/Y')],
            [],
            ['No', 'Kode PL', 'Profil Lulusan', 'Aspek', 'Profesi', 'Level KKNI'],
        ];
    }

    public function map($row): array
    {
        return [
            $this->no++,
            $row->kode_pl,
            $row->profil_lulusan,
            $row->aspek,
            $row->profesi,
            $row->level_kkni,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->mergeCells('A1:F1');
                $event->sheet->mergeCells('A2:F2');
                $event->sheet->mergeCells('A3:F3');

                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $event->sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $event->sheet->getStyle('A4:F4')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF4472C4'],
                    ],
                    'font' => ['color' => ['argb' => 'FFFFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                foreach (range('A', 'F') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
