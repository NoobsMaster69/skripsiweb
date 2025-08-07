<?php

namespace App\Exports;

use App\Models\PeninjauanKurikulum;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class PeninjauanKurikulumExport implements FromCollection, WithMapping, WithHeadings, WithEvents
{
    protected $no = 1;

    public function collection()
    {
        return PeninjauanKurikulum::all();
    }

    public function headings(): array
    {
        return [
            ['LAPORAN DATA PENINJAUAN KURIKULUM - UCIC'],
            ['Tanggal Cetak: ' . now()->format('d/m/Y')],
            [],
            ['No', 'Nomor Dokumen', 'Nama Dokumen', 'Di Upload Oleh', 'Tanggal Upload', 'Tanggal Pengesahan', 'Status', 'Deskripsi', 'Lampiran']
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
                // Merge title and subtitle
                $event->sheet->mergeCells('A1:I1');
                $event->sheet->mergeCells('A2:I2');
                $event->sheet->mergeCells('A3:I3');

                // Style for title
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Style for subtitle
                $event->sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Style for header
                $event->sheet->getStyle('A4:I4')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF4472C4'],
                    ],
                    'font' => ['color' => ['argb' => 'FFFFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Auto-size for all columns A–I
                foreach (range('A', 'I') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
