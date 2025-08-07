<?php

namespace App\Exports;

use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class KaryaDosenExport implements FromCollection, WithHeadings, WithMapping, WithEvents
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
            ['LAPORAN KARYA DOSEN'],
            ['Universitas Catur Insan Cendekia'],
            ['Tanggal Cetak: ' . now()->format('d M Y')],
            [],
            ['No', 'Nama Dosen', 'Judul Karya', 'Program Studi', 'Fakultas', 'Jenis Karya', 'Tahun Perolehan', 'Deskripsi', 'Lampiran'],
        ];
    }

    public function map($item): array
    {
        return [
            $this->no++,
            $item->nama_dosen,
            $item->judul_karya,
            $item->prodi,
            $item->fakultas,
            $item->jenis_karya,
            $item->tahun_pembuatan,
            $item->deskripsi,
            $item->file_karya ? Storage::url($item->file_karya) : 'Tidak ada file',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Merge untuk judul dan subjudul
                $event->sheet->mergeCells('A1:I1');
                $event->sheet->mergeCells('A2:I2');
                $event->sheet->mergeCells('A3:I3');

                // Style untuk judul
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Style subjudul
                $event->sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Style tanggal cetak
                $event->sheet->getStyle('A3')->applyFromArray([
                    'font' => ['size' => 10],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Style untuk baris header tabel
                $event->sheet->getStyle('A5:I5')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => '426bdb'], // Warna merah
                    ],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Auto-fit semua kolom A sampai I
                foreach (range('A', 'I') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
