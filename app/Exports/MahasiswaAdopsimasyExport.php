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

class MahasiswaAdopsimasyExport implements FromCollection, WithHeadings, WithMapping, WithEvents
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
            ['LAPORAN MAHASISWA KARYA YANG DIADOPSI OLEH MASYARAKAT'],
            ['Universitas Catur Insan Cendekia'],
            ['Tanggal Cetak: ' . now()->format('d M Y')],
            [],
            [
                'No', 'NIM', 'Nama Mahasiswa', 'Program Studi', 'Fakultas', 'Tahun',
                'Judul Karya', 'Jenis Kegiatan', 'Tanggal Perolehan', 'Lampiran'
            ]
        ];
    }

    public function map($item): array
    {
        return [
            $this->no++,
            $item->nim,
            $item->nm_mhs,
            $item->prodi,
            $item->fakultas,
            $item->tahun,
            $item->judul_karya,
            $item->kegiatan,
            \Carbon\Carbon::parse($item->tanggal_perolehan)->format('d/m/Y'),
            $item->file_upload ? 'Ada' : 'Tidak Ada',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Merge untuk header dan sub-header
                $event->sheet->mergeCells('A1:J1');
                $event->sheet->mergeCells('A2:J2');
                $event->sheet->mergeCells('A3:J3');

                // Judul utama
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Subjudul
                $event->sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Tanggal
                $event->sheet->getStyle('A3')->applyFromArray([
                    'font' => ['size' => 10],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Header tabel
                $event->sheet->getStyle('A5:J5')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF4472C4'],
                    ],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Auto-size semua kolom A–J
                foreach (range('A', 'J') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
