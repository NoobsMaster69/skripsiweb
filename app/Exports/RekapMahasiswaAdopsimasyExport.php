<?php

namespace App\Exports;

use App\Models\MahasiswaDiadop;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RekapMahasiswaAdopsimasyExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $filter;
    protected $data;
    protected $no = 1;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function collection()
    {
        $query = MahasiswaDiadop::query();

        foreach (['tahun', 'fakultas', 'prodi', 'kegiatan'] as $field) {
            if (!empty($this->filter[$field])) {
                $query->where($field, $this->filter[$field]);
            }
        }

        if (!empty($this->filter['tanggal_awal'])) {
            $query->whereDate('tanggal_perolehan', '>=', $this->filter['tanggal_awal']);
        }

        if (!empty($this->filter['tanggal_akhir'])) {
            $query->whereDate('tanggal_perolehan', '<=', $this->filter['tanggal_akhir']);
        }

        $this->data = $query->orderBy('tanggal_perolehan', 'desc')->get();

        return $this->data;
    }

    public function headings(): array
    {
        return [
            ['LAPORAN MAHASISWA YANG KARYANYA DIADOPSI MASYARAKAT'],
            ['Universitas Catur Insan Cendekia'],
            ['Tanggal Cetak: ' . now()->format('d/m/Y')],
            [],
            ['No', 'Nama Mahasiswa', 'NIM', 'Fakultas', 'Program Studi', 'Judul Karya', 'Kegiatan', 'Tanggal Perolehan']
        ];
    }

    public function map($item): array
    {
        return [
            $this->no++,
            $item->nm_mhs,
            $item->nim,
            $item->fakultas,
            $item->prodi,
            $item->judul_karya,
            $item->kegiatan,
            optional($item->tanggal_perolehan)->format('d/m/Y'),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Merge & Style Header
                $event->sheet->mergeCells('A1:H1');
                $event->sheet->mergeCells('A2:H2');
                $event->sheet->mergeCells('A3:H3');

                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $event->sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $event->sheet->getStyle('A3')->applyFromArray([
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $event->sheet->getStyle('A5:H5')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => '0f5aca'], // warna biru

                    ],
                    'font' => ['color' => ['argb' => 'FFFFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Autofit
                foreach (range('A', 'H') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
