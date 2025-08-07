<?php

namespace App\Exports;

use App\Models\CplBpm;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CplBpmExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       return CplBpm::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tahun Akademik',
            'Program Studi',
            'Mata Kuliah',
            'Target Pencapaian (%)',
            'Keterangan'
        ];
    }

    public function map($target): array
    {
        static $no = 1;

        return [
            $no++,
            $target->tahun_akademik,
            $target->program_studi,
            $target->mata_kuliah,
            number_format(floatval($target->target_pencapaian ?? 0), 1),
            $target->keterangan ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF4472C4']
                ],
                'font' => ['color' => ['argb' => 'FFFFFFFF']]
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 15,
            'C' => 25,
            'D' => 30,
            'E' => 15,
            'F' => 25,
        ];
    }
}
