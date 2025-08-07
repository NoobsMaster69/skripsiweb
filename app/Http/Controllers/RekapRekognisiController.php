<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekognisiDosen;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekognisiDosenExport;

class RekapRekognisiController extends Controller
{
    private function applyFilters(Request $request, $query)
    {
        $query->whereNotIn('status', ['menunggu', 'ditolak']);

        // Perbaiki logika filter periode agar cocok dengan string seperti "2021/2022"
        if ($request->filled('periode')) {
            $startYear = (int) $request->periode;
            $endYear = $startYear + 2;

            $query->where(function ($q) use ($startYear, $endYear) {
                for ($year = $startYear; $year <= $endYear; $year++) {
                    $q->orWhere('tahun_akademik', 'like', "{$year}%");
                }
            });
        } elseif ($request->filled('periode_awal') && $request->filled('periode_akhir')) {
            $startYear = (int) $request->periode_awal;
            $endYear = (int) $request->periode_akhir;

            $query->where(function ($q) use ($startYear, $endYear) {
                for ($year = $startYear; $year <= $endYear; $year++) {
                    $q->orWhere('tahun_akademik', 'like', "{$year}%");
                }
            });
        } elseif ($request->filled('tahun')) {
            $query->where('tahun_akademik', 'like', "{$request->tahun}%");
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

        return view('admin.rekapRekognisi.index', [
            'title' => 'Rekap Rekognisi',
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

        return Excel::download(new RekognisiDosenExport($data), 'rekap-admin-rekognisi-' . now()->format('Ymd_His') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = RekognisiDosen::query();
        $this->applyFilters($request, $query);
        $data = $query->latest()->get();

        $pdf = Pdf::loadView('admin.rekapRekognisi.pdf', [
            'rekognisiDosens' => $data,
            'title' => 'Laporan Rekap Rekognisi Dosen'
        ]);

        return $pdf->download('rekap-admin-rekognisi-' . now()->format('Ymd_His') . '.pdf');
    }

    public function grafik(Request $request)
    {
        $title = 'Grafik Rekognisi Dosen';

        $query = RekognisiDosen::query();
        $this->applyFilters($request, $query);

        $rekognisi = $query->get();

        // Data tabel & ringkasan tetap
        $data = $rekognisi->groupBy('bidang_rekognisi')->map(function ($group) {
            return [
                'label' => $group->first()->bidang_rekognisi,
                'total' => $group->count()
            ];
        })->values();

        // ✅ Tambahan: struktur data grouped chart [tahun => [bidang => total]]
        $groupedChartData = $rekognisi
            ->groupBy(['tahun_akademik', 'bidang_rekognisi'])
            ->map(function ($bidangGroup) {
                return $bidangGroup->map->count();
            });

        return view('admin.rekapRekognisi.grafikCPL', [
            'title' => $title,
            'data' => $data, // untuk tabel
            'groupedChartData' => $groupedChartData, // untuk grafik grouped bar
            'listTahun' => RekognisiDosen::select('tahun_akademik')->distinct()->pluck('tahun_akademik'),
            'listBidang' => RekognisiDosen::select('bidang_rekognisi')->distinct()->pluck('bidang_rekognisi'),
            'filters' => $request->all()
        ]);
    }
}
