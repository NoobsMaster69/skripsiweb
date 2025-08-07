<?php

namespace App\Exports;

use App\Models\DokRek;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;

class DokRekExport implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $dokReks;
    protected $no = 1;

    public function __construct($dokReks = null)
    {
        $this->dokReks = $dokReks;
    }

    public function collection()
    {
        return collect($this->dokReks ?: DokRek::with(['createdBy', 'updatedBy'])->get());
    }

    public function headings(): array
    {
        return [
            ['LAPORAN DATA DOKUMEN KEBIJAKAN UNIVERSITAS CATUR INSAN CENDEKIA'],
            ['Tanggal Cetak: ' . now()->format('d/m/Y')],
            [],
            ['No', 'Nomor Dokumen', 'Nama Dokumen', 'Di Upload Oleh', 'Tgl Upload', 'Tgl Pengesahan', 'Status', 'Deskripsi', 'File', 'Created At', 'Updated At'],
        ];
    }

    public function map($dokRek): array
    {
        return [
            $this->no++,
            $dokRek->nomor_dokumen,
            $dokRek->nama_dokumen,
            $dokRek->di_upload,
            $dokRek->tanggal_upload ? date('d/m/Y', strtotime($dokRek->tanggal_upload)) : '-',
            $dokRek->tanggal_pengesahan ? date('d/m/Y', strtotime($dokRek->tanggal_pengesahan)) : '-',
            $this->getStatusLabel($dokRek->status),
            $dokRek->deskripsi ?? '-',
            $dokRek->file_path ? 'Ada' : 'Tidak Ada',
            $dokRek->created_at ? date('d/m/Y H:i') : '-',
            $dokRek->updated_at ? date('d/m/Y H:i') : '-',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Merge header
                $event->sheet->mergeCells('A1:M1');
                $event->sheet->mergeCells('A2:M2');
                $event->sheet->mergeCells('A3:M3');

                // Style title rows
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $event->sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $event->sheet->getStyle('A4:M4')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['argb' => 'FF4472C4'],
                    ],
                    'font' => ['color' => ['argb' => 'FFFFFFFF']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Auto-size all columns
                foreach (range('A', 'M') as $col) {
                    $event->sheet->getColumnDimension($col)->setAutoSize(true);
                }
            }
        ];
    }

    private function getStatusLabel($status)
    {
        return match ($status) {
            'belum_validasi' => 'Belum Validasi',
            'validasi' => 'Validasi',
            'ditolak' => 'Ditolak',
            default => $status,
        };
    }
}
