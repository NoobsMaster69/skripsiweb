<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RekapCplExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $data;
    protected $no = 1;

    public function __construct(Collection $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            ['REKAPITULASI CAPAIAN PEMBELAJARAN LULUSAN (CPL)'],
            ['Universitas Catur Insan Cendekia'],
            ['Tanggal Cetak: ' . now()->format('d M Y')],
            [],
            ['No', 'Tahun Akademik', 'Program Studi', 'Mata Kuliah', 'Target', 'Ketercapaian']
        ];
    }

    public function map($row): array
    {
        return [
            $this->no++,
            $row->tahun_akademik,
            $row->program_studi,
            $row->mata_kuliah,
            $row->target_pencapaian . '%',
            optional($row->cplDosen)->ketercapaian !== null
                ? number_format($row->cplDosen->ketercapaian, 1) . '%'
                : '-',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge judul
                $event->sheet->mergeCells('A1:F1');
                $event->sheet->mergeCells('A2:F2');
                $event->sheet->mergeCells('A3:F3');

                // Style judul
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $event->sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
                $event->sheet->getStyle('A3')->applyFromArray([
                    'font' => ['size' => 10],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Style header tabel (baris ke-5)
                $event->sheet->getStyle('A5:F5')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF4472C4'],
                    ],
                    'font' => ['color' => ['argb' => 'FFFFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Autofit kolom
                foreach (range('A', 'F') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
