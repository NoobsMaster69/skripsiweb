<?php

namespace App\Exports;

use App\Models\SertifkompMahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class RekapserkomExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithColumnWidths
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
        $query = SertifkompMahasiswa::query();

        foreach (['tahun', 'fakultas', 'prodi', 'tingkatan', 'kegiatan'] as $field) {
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

        $this->data = $query->get();

        return $this->data;
    }

    public function headings(): array
    {
        return [
            ['LAPORAN SERTIFIKASI KOMPETENSI MAHASISWA'],
            ['Admin - Universitas Catur Insan Cendekia'],
            ['Tanggal Cetak: ' . now()->format('d M Y')],
            [],
            [ // header tabel mulai baris ke-5
                'No',
                'NIM Mahasiswa',
                'Nama Mahasiswa',
                'Tahun',
                'Fakultas',
                'Program Studi',
                'Judul Karya',
                'Kegiatan',
                'Tingkatan',
                'Tanggal Perolehan',
                'File Upload',
            ]
        ];
    }

    public function map($item): array
    {
        return [
            $this->no++,
            $item->nim,
            $item->nm_mhs,
            $item->tahun,
            $item->fakultas,
            $item->prodi,
            $item->judul_karya,
            $item->kegiatan,
            ucfirst($item->tingkatan),
            $item->tanggal_perolehan ? \Carbon\Carbon::parse($item->tanggal_perolehan)->format('d/m/Y') : '-',
            $item->file_upload ? asset('storage/' . $item->file_upload) : 'Tidak ada file',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Merge judul dan subjudul
                $event->sheet->mergeCells('A1:K1');
                $event->sheet->mergeCells('A2:K2');
                $event->sheet->mergeCells('A3:K3');

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
                $event->sheet->getStyle('A5:K5')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => '1c3a9e'],
                    ],
                    'font' => ['color' => ['argb' => 'FFFFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Autofit kolom A–K
                foreach (range('A', 'K') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 18,
            'C' => 25,
            'D' => 10,
            'E' => 15,
            'F' => 20,
            'G' => 40,
            'H' => 20,
            'I' => 15,
            'J' => 18,
            'K' => 40,
        ];
    }
}
