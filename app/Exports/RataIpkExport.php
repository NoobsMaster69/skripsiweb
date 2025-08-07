<?php

namespace App\Exports;

use App\Models\RataIpk;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RataIpkExport implements FromCollection, WithHeadings, WithMapping, WithEvents, ShouldAutoSize
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
            ['LAPORAN DATA IPK MAHASISWA LULUSAN'],
            ['Admin - Universitas Catur Insan Cendekia'],
            ['Tanggal Cetak: ' . now()->format('d M Y')],
            [],
            ['No', 'NIM', 'Nama', 'Program Studi', 'Tahun Lulus', 'Tanggal Lulus', 'IPK', 'Predikat'],
        ];
    }

    public function map($item): array
    {
        return [
            $this->no++,
            $item->nim,
            $item->nama,
            $item->prodi,
            $item->tahun_lulus,
            $item->tanggal_lulus ? \Carbon\Carbon::parse($item->tanggal_lulus)->format('d-m-Y') : '-',
            $item->ipk,
            $item->predikat,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge judul
                $event->sheet->mergeCells('A1:H1');
                $event->sheet->mergeCells('A2:H2');
                $event->sheet->mergeCells('A3:H3');

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
                $event->sheet->getStyle('A5:H5')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF4472C4'],
                    ],
                    'font' => ['color' => ['argb' => 'FFFFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);
            }
        ];
    }
}
