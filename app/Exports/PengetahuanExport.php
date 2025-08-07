<?php

namespace App\Exports;

use App\Models\Pengetahuan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PengetahuanExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $no = 1;
    protected $data;

    /**
     * Ambil seluruh data dari tabel pengetahuan.
     */
    public function collection()
    {
        return $this->data = Pengetahuan::select('kode', 'deskripsi', 'sumber')->get();
    }

    /**
     * Heading Excel (termasuk judul dan header tabel).
     */
    public function headings(): array
    {
        return [
            ['LAPORAN DATA PENGETAHUAN'],
            ['Admin - Universitas Catur Insan Cendekia'],
            ['Tanggal Cetak: ' . now()->format('d M Y')],
            [],
            ['No', 'Kode CPL SN-DIKTI', 'Deskripsi', 'Sumber'],
        ];
    }

    /**
     * Mapping setiap baris data agar ditambahkan nomor urut.
     */
    public function map($row): array
    {
        return [
            $this->no++,
            $row->kode,
            $row->deskripsi,
            $row->sumber,
        ];
    }

    /**
     * Styling setelah data ditulis ke sheet.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge untuk judul dan subjudul
                $event->sheet->mergeCells('A1:D1');
                $event->sheet->mergeCells('A2:D2');
                $event->sheet->mergeCells('A3:D3');

                // Style judul utama
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Style subjudul
                $event->sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Style tanggal
                $event->sheet->getStyle('A3')->applyFromArray([
                    'font' => ['size' => 10],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Style header tabel
                $event->sheet->getStyle('A5:D5')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF4472C4'],
                    ],
                    'font' => ['color' => ['argb' => 'FFFFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Auto-size kolom
                foreach (range('A', 'D') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
