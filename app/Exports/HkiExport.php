<?php

namespace App\Exports;

use App\Models\HkiMahasiswa;
use App\Models\MahasiswaHki;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class HkiExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $filter;
    protected $no = 1;
    protected $data;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function collection()
    {
        $query = MahasiswaHki::query();

        foreach (['tahun', 'fakultas', 'prodi'] as $field) {
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
            ['LAPORAN MAHASISWA PENERIMA HKI'],
            ['Universitas Catur Insan Cendekia'],
            ['Tanggal Cetak: ' . now()->format('d M Y')],
            [],
            ['No', 'Nama Mahasiswa', 'NIM', 'Program Studi', 'Fakultas', 'Judul Karya', 'Kegiatan', 'Tanggal Perolehan', 'File Upload']
        ];
    }

    public function map($item): array
    {
        return [
            $this->no++,
            $item->nm_mhs,
            $item->nim,
            $item->prodi,
            $item->fakultas,
            $item->judul_karya,
            'HKI',
            $item->tanggal_perolehan ? \Carbon\Carbon::parse($item->tanggal_perolehan)->format('d/m/Y') : '-',
            $item->file_upload ? asset('storage/' . $item->file_upload) : 'Tidak ada file',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->mergeCells('A1:I1');
                $event->sheet->mergeCells('A2:I2');
                $event->sheet->mergeCells('A3:I3');

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
                $event->sheet->getStyle('A5:I5')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF4472C4'],
                    ],
                    'font' => ['color' => ['argb' => 'FFFFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                foreach (range('A', 'I') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
