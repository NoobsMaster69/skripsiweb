<?php

namespace App\Exports;

use App\Models\MahasiswaLainnya;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class MhsKaryaLainnyaExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $filters;
    protected $no = 1;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = MahasiswaLainnya::query();

        if (!empty($this->filters['tahun'])) {
            $query->where('tahun', $this->filters['tahun']);
        }

        if (!empty($this->filters['fakultas'])) {
            $query->where('fakultas', $this->filters['fakultas']);
        }

        if (!empty($this->filters['prodi'])) {
            $query->where('prodi', $this->filters['prodi']);
        }

        if (!empty($this->filters['kegiatan'])) {
            $query->where('kegiatan', $this->filters['kegiatan']);
        }

        if (!empty($this->filters['tanggal_awal'])) {
            $query->whereDate('tanggal_perolehan', '>=', $this->filters['tanggal_awal']);
        }

        if (!empty($this->filters['tanggal_akhir'])) {
            $query->whereDate('tanggal_perolehan', '<=', $this->filters['tanggal_akhir']);
        }

        return $query->orderByDesc('tanggal_perolehan')->get();
    }

    public function headings(): array
    {
        return [
            ['REKAP KARYA MAHASISWA LAINNYA'],
            ['Universitas Catur Insan Cendekia'],
            ['Tanggal Cetak: ' . now()->format('d/m/Y')],
            [],
            ['No', 'Nama Mahasiswa', 'NIM', 'Kegiatan', 'Judul Karya', 'Tahun', 'Fakultas', 'Program Studi', 'Tanggal Perolehan', 'Status Validasi']
        ];
    }

    public function map($row): array
    {
        return [
            $this->no++,
            $row->nm_mhs,
            $row->nim,
            $row->kegiatan,
            $row->judul_karya,
            $row->tahun,
            $row->fakultas,
            $row->prodi,
            optional($row->tanggal_perolehan)->format('d/m/Y'),
            ucfirst($row->status)
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge title rows
                $event->sheet->mergeCells('A1:J1');
                $event->sheet->mergeCells('A2:J2');
                $event->sheet->mergeCells('A3:J3');

                // Style title
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

                // Style header
                $event->sheet->getStyle('A5:J5')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF2140A3'],
                    ],
                    'font' => ['color' => ['argb' => 'FFFFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Autosize columns
                foreach (range('A', 'J') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
