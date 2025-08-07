<?php

namespace App\Exports;

use App\Models\RataIpk;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RekapIpkExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $filters;
    protected $data;
    protected $no = 1;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = RataIpk::query();

        if (!empty($this->filters['tahun_lulus'])) {
            $query->where('tahun_lulus', $this->filters['tahun_lulus']);
        }

        if (!empty($this->filters['prodi'])) {
            $query->where('prodi', $this->filters['prodi']);
        }

        return $this->data = $query->get();
    }

    public function headings(): array
    {
        return [
            ['LAPORAN DATA IPK MAHASISWA'],
            ['Admin - Universitas Catur Insan Cendekia'],
            ['Tanggal Cetak: ' . now()->format('d M Y')],
            [],
            ['No', 'NIM', 'Nama', 'Program Studi', 'Tahun Lulus', 'Tanggal Lulus', 'IPK', 'Predikat']
        ];
    }

    public function map($row): array
    {
        return [
            $this->no++,
            $row->nim,
            $row->nama,
            $row->prodi,
            $row->tahun_lulus,
            \Carbon\Carbon::parse($row->tanggal_lulus)->format('d/m/Y'),
            number_format($row->ipk, 2),
            $row->predikat,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge judul dan subjudul
                $event->sheet->mergeCells('A1:H1');
                $event->sheet->mergeCells('A2:H2');
                $event->sheet->mergeCells('A3:H3');

                // Style untuk judul
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

                // Style header tabel
                $event->sheet->getStyle('A5:H5')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF4472C4'],
                    ],
                    'font' => ['color' => ['argb' => 'FFFFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Autofit semua kolom
                foreach (range('A', 'H') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}
