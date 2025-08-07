<?php

namespace App\Exports;

use App\Models\CplDosen;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CplDosenExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $no = 1;
    protected $data;

    public function collection(): Collection
    {
        return $this->data = CplDosen::with('masterCpl')->get();
    }

    public function headings(): array
    {
        return [
            ['LAPORAN TARGET & KETERCAPAIAN CPL DOSEN'],
            [' Universitas Catur Insan Cendekia'],
            ['Tanggal Cetak: ' . now()->format('d M Y')],
            [],
            [
                'No',
                'Tahun Akademik',
                'Program Studi',
                'Mata Kuliah',
                'Target (%)',
                'Ketercapaian (%)',
                'Dokumen Pendukung',
                'Link',
                'Keterangan'
            ],
        ];
    }

    public function map($row): array
    {
        return [
            $this->no++,
            $row->masterCpl->tahun_akademik ?? '-',
            $row->masterCpl->program_studi ?? '-',
            $row->masterCpl->mata_kuliah ?? '-',
            number_format(floatval($row->masterCpl->target_pencapaian ?? 0), 1),
            number_format(floatval($row->ketercapaian ?? 0), 1),
            $row->dokumen_pendukung ? 'Tersedia' : 'Tidak Ada',
            $row->link ?? '-',
            $row->keterangan ?? '-',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge judul & subjudul
                $event->sheet->mergeCells('A1:I1');
                $event->sheet->mergeCells('A2:I2');
                $event->sheet->mergeCells('A3:I3');

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
                $event->sheet->getStyle('A5:I5')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF4472C4'],
                    ],
                    'font' => ['color' => ['argb' => 'FFFFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Autofit semua kolom
                foreach (range('A', 'I') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
