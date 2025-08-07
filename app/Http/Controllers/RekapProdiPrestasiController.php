<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PrestasiExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PrestasiMahasiswa;
use Maatwebsite\Excel\Facades\Excel;

class RekapProdiPrestasiController extends Controller
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
        $title = 'Rekap Prodi Prestasi Mahasiswa';

        $prestasi = null;

        // Selalu jalankan jika tombol submit diklik
        if ($request->has('submit_filter')) {
            $query = PrestasiMahasiswa::query();

            // Filter dinamis
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
                    '3' => 'internasional',
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

            // Filter wajib
            $query->where('status', 'terverifikasi');

            $prestasi = $query->orderByDesc('tanggal_perolehan')->get();
        }

        $listTahun = PrestasiMahasiswa::distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $listProdi = PrestasiMahasiswa::distinct()->pluck('prodi')->filter()->values();

        return view('prodi.fti.rekap.rekapPrestasi', compact('title', 'prestasi', 'request', 'listProdi', 'listTahun'));
    }

    public function exportExcel(Request $request)
    {
        $filters = $request->only(['tahun', 'fakultas', 'prodi', 'tingkat', 'tanggal_awal', 'tanggal_akhir']);
        return Excel::download(new PrestasiExport($filters), 'rekap_prestasi_mahasiswa.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = PrestasiMahasiswa::query();

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
            $map = ['1' => 'local-wilayah', '2' => 'nasional', '3' => 'internasional'];
            if (isset($map[$request->tingkat])) {
                $query->where('tingkat', $map[$request->tingkat]);
            }
        }

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_perolehan', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_perolehan', '<=', $request->tanggal_akhir);
        }

        $query->where('status', 'terverifikasi');

        $data = $query->orderByDesc('tanggal_perolehan')->get();

        $pdf = Pdf::loadView('prodi.fti.rekap.pdf-prestasi', [
            'data' => $data,
            'tanggalCetak' => now()->format('d F Y H:i') . ' WIB',
        ])->setPaper('A4', 'landscape');

        return $pdf->download('laporan-prestasi-mahasiswa.pdf');
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

        return view('prodi.fti.rekap.grafik.grafikPrestasi', compact(
            'title',
            'dataChartByTahun',
            'rekapJenisPrestasi',
            'listTahun',
            'listProdi',
            'request'
        ));
    }
}
