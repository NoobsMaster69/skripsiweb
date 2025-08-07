<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PrestasiExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PrestasiMahasiswa;
use Maatwebsite\Excel\Facades\Excel;

class RekapFakulPrestasiController extends Controller
{
    private function applyFilters(Request $request, $query)
    {
        // Periode tahun manual override filter tahun tunggal
        if ($request->filled('periode_dari') && $request->filled('periode_sampai')) {
            $dari = (int) $request->periode_dari;
            $sampai = (int) $request->periode_sampai;

            if ($dari <= $sampai) {
                $query->whereBetween('tahun', [$dari, $sampai]);
            }
        } elseif ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        // Filter lainnya tetap sama
        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }

        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        if ($request->filled('tingkat')) {
            $map = ['1' => 'local-wilayah', '2' => 'nasional', '3' => 'internasional'];
            if (isset($map[$request->tingkat])) {
                $query->where('tingkat', $map[$request->tingkat]);
            }
        }

        if ($request->filled('prestasi')) {
            $query->where('prestasi', $request->prestasi);
        }

        if ($request->filled('jenis_prestasi')) {
            $query->where('prestasi', $request->jenis_prestasi); // ✅ Sesuaikan dengan nama kolom yang ada
        }

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_perolehan', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_perolehan', '<=', $request->tanggal_akhir);
        }

        $query->where('status', 'terverifikasi');

        return $query;
    }
    public function index(Request $request)
    {
        $title = 'Rekap Fakultas "Prestasi Mahasiswa"';

        // Query dasar
        $query = PrestasiMahasiswa::where('kegiatan', 'Publikasi');

        // Terapkan filter jika ada
        $this->applyFilters($request, $query);

        // Ambil data hasil query
        $publikasi = $query->orderBy('tanggal_perolehan', 'desc')->get();

        $listTahun = PrestasiMahasiswa::distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $listProdi = PrestasiMahasiswa::distinct()->pluck('prodi')->filter()->values();

        return view('fakultas.rekap.rekapPrestasi', compact('title', 'publikasi', 'request', 'listProdi', 'listTahun'));
    }


    // Method untuk menampilkan detail publikasi
    public function show($id)
    {
        try {
            $publikasi = PrestasiMahasiswa::where('kegiatan', 'Publikasi')
                ->where('id', $id)
                ->firstOrFail();

            // Return HTML untuk modal
            return view('fakultas.rekap.partials.detail-publikasi', compact('publikasi'));
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Data tidak ditemukan',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    // Method untuk export single record
    public function exportSingle($id)
    {
        try {
            $publikasi = PrestasiMahasiswa::where('kegiatan', 'Publikasi')
                ->where('id', $id)
                ->firstOrFail();

            // Simple CSV export for single record
            $filename = 'publikasi_' . $publikasi->nim . '_' . date('Y-m-d') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];

            $csvData = "Field,Value\n";
            $csvData .= "Nama Mahasiswa,\"" . $publikasi->nm_mhs . "\"\n";
            $csvData .= "NIM,\"" . $publikasi->nim . "\"\n";
            $csvData .= "Program Studi,\"" . $publikasi->prodi . "\"\n";
            $csvData .= "Fakultas,\"" . $publikasi->fakultas . "\"\n";
            $csvData .= "Judul Karya,\"" . str_replace('"', '""', $publikasi->judul_karya) . "\"\n";
            $csvData .= "Tingkat,\"" . $publikasi->tingkat . "\"\n";
            $csvData .= "Tahun,\"" . $publikasi->tahun . "\"\n";
            $csvData .= "Tanggal,\"" . ($publikasi->tanggal_perolehan ? $publikasi->tanggal_perolehan->format('d/m/Y') : '') . "\"\n";

            return response($csvData, 200, $headers);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal export data', 'message' => $e->getMessage()], 500);
        }
    }

    // Method untuk handle export
    private function handleExport(Request $request)
    {
        $exportType = $request->get('export');

        // Get filtered data dengan filter yang sama seperti di index
        $query = PrestasiMahasiswa::where('kegiatan', 'Publikasi');

        // Apply filters
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }
        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }
        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }
        if ($request->filled('tingkat')) {
            $tingkatMap = [
                '1' => 'local-wilayah',
                '2' => 'nasional',
                '3' => 'internasional'
            ];
            if (isset($tingkatMap[$request->tingkat])) {
                $query->where('tingkat', $tingkatMap[$request->tingkat]);
            }
        }
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_perolehan', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_perolehan', '<=', $request->tanggal_akhir);
        }

        $publikasi = $query->where('status', 'terverifikasi')
            ->orderBy('tanggal_perolehan', 'desc')
            ->get();

        if ($exportType === 'excel') {
            return $this->exportToExcel($publikasi);
        } elseif ($exportType === 'pdf') {
            return $this->exportToPdf($publikasi);
        }

        return redirect()->back()->with('error', 'Format export tidak valid');
    }

    private function exportToExcel($publikasi)
    {
        $filters = request()->only([
            'tahun',
            'fakultas',
            'prodi',
            'tingkat',
            'tanggal_awal',
            'tanggal_akhir'
        ]);

        $filename = 'prestasi_mahasiswa_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(new PrestasiExport($filters), $filename);
    }

    private function exportToPdf($publikasi)
    {
        $pdf = Pdf::loadView('fakultas.rekap.pdf-prestasi', compact('publikasi'))
            ->setPaper('a4', 'portrait'); // 'landscape' jika dibutuhkan

        return $pdf->download('publikasi_mahasiswa_' . date('Y-m-d') . '.pdf');
    }
    public function grafikFilter(Request $request)
    {
        $title = 'Grafik Prestasi Mahasiswa';

        $query = PrestasiMahasiswa::query();
        $this->applyFilters($request, $query);
        $filteredData = $query->get();

        // Mapping tingkat real → label grafik
        $mapTingkat = [
            'local-wilayah' => 'Wilayah',
            'lokal' => 'Wilayah',
            'local' => 'Wilayah',
            'nasional' => 'Nasional',
            'internasional' => 'Internasional',
        ];

        // Siapkan data grafik per tahun & tingkat
        $dataChartByTahun = [];

        foreach ($filteredData as $item) {
            $rawTingkat = strtolower($item->tingkat);
            $tingkatKey = $mapTingkat[$rawTingkat] ?? null;
            $tahun = $item->tahun;

            if (!$tingkatKey || !in_array($item->prestasi, ['prestasi-akademik', 'prestasi-non-akademik'])) continue;

            if (!isset($dataChartByTahun[$tahun])) {
                $dataChartByTahun[$tahun] = ['Wilayah' => 0, 'Nasional' => 0, 'Internasional' => 0];
            }

            $dataChartByTahun[$tahun][$tingkatKey]++;
        }

        // Rekap jenis prestasi
        $rekapJenisPrestasi = PrestasiMahasiswa::query();
        $this->applyFilters($request, $rekapJenisPrestasi);
        $rekapJenisPrestasi = $rekapJenisPrestasi
            ->selectRaw('prestasi, COUNT(*) as total')
            ->groupBy('prestasi')
            ->pluck('total', 'prestasi')
            ->toArray();

        $listTahun = PrestasiMahasiswa::distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $listProdi = PrestasiMahasiswa::distinct()->pluck('prodi')->filter()->values();

        return view('fakultas.rekap.grafik.grafikPrestasi', compact(
            'title',
            'dataChartByTahun',
            'rekapJenisPrestasi',
            'listTahun',
            'listProdi',
            'request'
        ));
    }
}
