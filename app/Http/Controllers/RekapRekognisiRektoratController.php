<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekognisiDosen;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekognisiDosenExport;

class RekapRekognisiRektoratController extends Controller
{
    private function applyFilters(Request $request, $query)
    {
        $query->whereNotIn('status', ['menunggu', 'ditolak']);

        if ($request->filled('periode')) {
            $startYear = (int) $request->periode;
            $endYear = $startYear + 2;
            $query->whereBetween('tahun_akademik', [$startYear, $endYear]);
        } elseif ($request->filled('periode_awal') && $request->filled('periode_akhir')) {
            $query->whereBetween('tahun_akademik', [$request->periode_awal, $request->periode_akhir]);
        } elseif ($request->filled('tahun')) {
            $query->where('tahun_akademik', $request->tahun);
        }

        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        if ($request->filled('bidang')) {
            $query->where('bidang_rekognisi', $request->bidang);
        }

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_rekognisi', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_rekognisi', '<=', $request->tanggal_akhir);
        }

        return $query;
    }

    public function index(Request $request)
    {
        $query = RekognisiDosen::query();
        $this->applyFilters($request, $query);
        $data = $query->latest()->get();

        return view('rektorat.rekapRekognisi.index', [
            'title' => 'Rekap Rekognisi - Rektorat',
            'rekognisiDosens' => $data,
            'listProdi' => RekognisiDosen::select('prodi')->distinct()->pluck('prodi'),
            'listBidang' => RekognisiDosen::select('bidang_rekognisi')->distinct()->pluck('bidang_rekognisi'),
            'listTahun' => RekognisiDosen::select('tahun_akademik')->distinct()->pluck('tahun_akademik'),
            'filters' => $request->all()
        ]);
    }

    public function exportExcel(Request $request)
    {
        $query = RekognisiDosen::query();
        $this->applyFilters($request, $query);
        $data = $query->latest()->get();

        return Excel::download(new RekognisiDosenExport($data), 'rekap-rektorat-rekognisi-' . now()->format('Ymd_His') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = RekognisiDosen::query();
        $this->applyFilters($request, $query);
        $data = $query->latest()->get();

        $pdf = Pdf::loadView('rektorat.rekapRekognisi.pdf', [
            'rekognisiDosens' => $data,
            'title' => 'Laporan Rekap Rekognisi Dosen - Rektorat'
        ]);

        return $pdf->download('rekap-rektorat-rekognisi-' . now()->format('Ymd_His') . '.pdf');
    }

    public function grafik(Request $request)
    {
        $title = 'Grafik Rekognisi Dosen - Rektorat';
        $query = RekognisiDosen::query();
        $this->applyFilters($request, $query);
        $rekognisi = $query->get();

        // Data utama untuk grafik
        if ($request->filled('tahun') && !$request->filled('bidang')) {
            $data = $rekognisi->groupBy('prodi')->map(function ($group) {
                return [
                    'label' => $group->first()->prodi,
                    'total' => $group->count()
                ];
            })->values();
        } elseif ($request->filled('bidang') || $request->filled('periode') || ($request->filled('periode_awal') && $request->filled('periode_akhir'))) {
            $data = $rekognisi->groupBy('tahun_akademik')->map(function ($group) {
                return [
                    'label' => $group->first()->tahun_akademik,
                    'total' => $group->count()
                ];
            })->values();
        } else {
            $data = $rekognisi->groupBy('bidang_rekognisi')->map(function ($group) {
                return [
                    'label' => $group->first()->bidang_rekognisi,
                    'total' => $group->count()
                ];
            })->values();
        }

        // Tambahkan groupedChartData untuk kebutuhan ChartJS (misalnya grouped by tahun & bidang)
        $groupedChartData = $rekognisi->groupBy('tahun_akademik')->map(function ($group) {
            return $group->groupBy('bidang_rekognisi')->map->count();
        });

        return view('rektorat.rekapRekognisi.grafikCPL', [
            'title' => $title,
            'data' => $data,
            'groupedChartData' => $groupedChartData, // ✅ sudah aman sekarang
            'listTahun' => RekognisiDosen::select('tahun_akademik')->distinct()->pluck('tahun_akademik'),
            'listBidang' => RekognisiDosen::select('bidang_rekognisi')->distinct()->pluck('bidang_rekognisi'),
            'filters' => $request->all()
        ]);
    }
}
