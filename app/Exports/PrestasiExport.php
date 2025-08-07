<?php
namespace App\Exports;

use App\Models\PrestasiMahasiswa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PrestasiExport implements FromCollection, WithHeadings, WithMapping, WithEvents
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
        $query = PrestasiMahasiswa::query();

        if (!empty($this->filter['tahun'])) {
            $query->where('tahun', $this->filter['tahun']);
        }
        if (!empty($this->filter['fakultas'])) {
            $query->where('fakultas', $this->filter['fakultas']);
        }
        if (!empty($this->filter['prodi'])) {
            $query->where('prodi', $this->filter['prodi']);
        }
        if (!empty($this->filter['tingkat'])) {
            $map = ['1' => 'local-wilayah', '2' => 'nasional', '3' => 'internasional'];
            if (isset($map[$this->filter['tingkat']])) {
                $query->where('tingkat', $map[$this->filter['tingkat']]);
            }
        }
        if (!empty($this->filter['tanggal_awal'])) {
            $query->whereDate('tanggal_perolehan', '>=', $this->filter['tanggal_awal']);
        }
        if (!empty($this->filter['tanggal_akhir'])) {
            $query->whereDate('tanggal_perolehan', '<=', $this->filter['tanggal_akhir']);
        }

        $query->where('status', 'terverifikasi');

        return $this->data = $query->get();
    }

    public function headings(): array
    {
        return [
            ['LAPORAN PRESTASI MAHASISWA'], // Judul besar
            ['Admin- Universitas Catur Insan Cendekia'], // Subjudul
            ['Tanggal Cetak: ' . now()->format('d M Y')], // Tanggal cetak
            [], // Kosong 1 baris
            ['No', 'Nama Mahasiswa', 'NIM', 'Program Studi', 'Judul Karya', 'Kegiatan', 'Tingkat', 'Tanggal Perolehan']
        ];
    }

    public function map($row): array
    {
        return [
            $this->no++,
            $row->nm_mhs,
            $row->nim,
            $row->prodi,
            $row->judul_karya,
            $row->kegiatan,
            ucwords($row->tingkat),
            \Carbon\Carbon::parse($row->tanggal_perolehan)->format('d/m/Y'),
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                // Merge untuk judul dan subjudul
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

                // Autofit kolom
                foreach (range('A', 'H') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }
}
