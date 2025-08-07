<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\Storage;

class PrestasiMahasiswaExport implements FromCollection, WithMapping, WithHeadings, WithEvents
{
    protected $data;
    protected $no = 1;

    public function __construct($data)
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
            ['LAPORAN DATA PRESTASI MAHASISWA - UCIC'],
            ['Tanggal Cetak: ' . now()->format('d/m/Y')],
            [],
            [
                'No',
                'NIM Mahasiswa',
                'Nama Mahasiswa',
                'Tahun',
                'Judul Karya',
                'Tingkat',
                'Jenis Prestasi',
                'Lampiran'
            ]
        ];
    }

    public function map($item): array
    {
        return [
            $this->no++,
            $item->nim ?? '-',
            $item->nm_mhs ?? '-',
            $item->tahun ?? '-',
            $item->judul_karya ?? '-',
            $item->tingkat ?? '-',
            $item->prestasi ?? '-',
            $item->file_upload ? Storage::url($item->file_upload) : 'Tidak ada file',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge title and subtitle
                $event->sheet->mergeCells('A1:H1');
                $event->sheet->mergeCells('A2:H2');
                $event->sheet->mergeCells('A3:H3');

                // Title style
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Subtitle style
                $event->sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Header style
                $event->sheet->getStyle('A4:H4')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF4472C4'],
                    ],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Auto-size for all columns A–H
                foreach (range('A', 'H') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
