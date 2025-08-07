<?php

namespace App\Exports;

use App\Models\KeterampilanUmum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class KUExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $no = 1;
    protected $data;

    public function collection()
    {
        return $this->data = KeterampilanUmum::select('kode', 'deskripsi', 'sumber')->get();
    }

    public function headings(): array
    {
        return [
            ['LAPORAN DATA KETERAMPILAN UMUM'],
            ['Prodi - Universitas Catur Insan Cendekia'],
            ['Tanggal Cetak: ' . now()->format('d M Y')],
            [],
            ['No', 'Kode CPL', 'Deskripsi', 'Sumber'],
        ];
    }

    public function map($row): array
    {
        return [
            $this->no++,
            $row->kode,
            $row->deskripsi,
            $row->sumber,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge cell untuk header utama
                $event->sheet->mergeCells('A1:D1');
                $event->sheet->mergeCells('A2:D2');
                $event->sheet->mergeCells('A3:D3');

                // Styling judul
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

                // Header kolom
                $event->sheet->getStyle('A5:D5')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF4472C4'],
                    ],
                    'font' => ['color' => ['argb' => 'FFFFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Autofit kolom
                foreach (range('A', 'D') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
