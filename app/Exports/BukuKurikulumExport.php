<?php

namespace App\Exports;

use App\Models\BukuKurikulum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BukuKurikulumExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $no = 1;

    public function collection()
    {
        return BukuKurikulum::all();
    }

    public function headings(): array
    {
        return [
            ['LAPORAN DATA BUKU KURIKULUM - UCIC'],
            ['Tanggal Cetak: ' . now()->format('d/m/Y')],
            [],
            ['No', 'Nomor Dokumen', 'Nama Dokumen', 'Di Upload Oleh', 'Tgl Upload', 'Tgl Pengesahan', 'Status', 'Deskripsi', 'Lampiran']
        ];
    }

    public function map($row): array
    {
        return [
            $this->no++,
            $row->nomor_dokumen,
            $row->nama_dokumen,
            $row->di_upload,
            $row->tanggal_upload ? date('d/m/Y', strtotime($row->tanggal_upload)) : '-',
            $row->tanggal_pengesahan ? date('d/m/Y', strtotime($row->tanggal_pengesahan)) : '-',
            ucfirst($row->status),
            $row->deskripsi ?? '-',
            $row->file_path ? 'Ada' : 'Tidak Ada',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge headers
                $event->sheet->mergeCells('A1:I1');
                $event->sheet->mergeCells('A2:I2');
                $event->sheet->mergeCells('A3:I3');

                // Style title
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $event->sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Header row
                $event->sheet->getStyle('A4:I4')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF4472C4'],
                    ],
                    'font' => ['color' => ['argb' => 'FFFFFFFF']],
                ]);

                // Auto-size columns
                foreach (range('A', 'I') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
