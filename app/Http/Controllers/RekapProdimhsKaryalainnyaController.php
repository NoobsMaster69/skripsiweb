<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MahasiswaLainnya;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MhsKaryaLainnyaExport;

class RekapProdimhsKaryalainnyaController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Rekap Prodi "Karya Mahasiswa Lainnya"';
        $hasFilter = $request->has('submit_filter');
        $data = null;

        if ($hasFilter) {
            $query = MahasiswaLainnya::query();

            // Filter status ≠ menunggu
            $query->where('status', '!=', 'menunggu');

            if ($request->filled('tahun')) {
                $query->where('tahun', $request->tahun);
            }

            if ($request->filled('fakultas')) {
                $query->where('fakultas', $request->fakultas);
            }

            if ($request->filled('prodi')) {
                $query->where('prodi', $request->prodi);
            }

            if ($request->filled('kegiatan')) {
                $query->where('kegiatan', $request->kegiatan);
            }

            if ($request->filled('tanggal_awal')) {
                $query->whereDate('tanggal_perolehan', '>=', $request->tanggal_awal);
            }

            if ($request->filled('tanggal_akhir')) {
                $query->whereDate('tanggal_perolehan', '<=', $request->tanggal_akhir);
            }

            $data = $query->orderByDesc('tanggal_perolehan')->get();
        }

        $listTahun = MahasiswaLainnya::distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $listProdi = MahasiswaLainnya::distinct()->pluck('prodi')->filter()->values();

        return view('prodi.fti.rekap.rekapKaryaLain', compact('title', 'data', 'request', 'listProdi', 'listTahun'));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new MhsKaryaLainnyaExport($request->all()), 'karya_mahasiswa_lainnya.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $query = MahasiswaLainnya::query();

        $query->where('status', '!=', 'menunggu');

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }

        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        if ($request->filled('kegiatan')) {
            $query->where('kegiatan', $request->kegiatan);
        }

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_perolehan', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_perolehan', '<=', $request->tanggal_akhir);
        }

        $data = $query->get();

        $pdf = Pdf::loadView('prodi.fti.rekap.karyalainnya_pdf', compact('data'))->setPaper('A4', 'landscape');
        return $pdf->download('karya_mahasiswa_lainnya.pdf');
    }

    public function grafik(Request $request)
    {
        $title = 'Grafik Karya Mahasiswa Lainnya';
        $query = MahasiswaLainnya::query();

        $query->where('status', '!=', 'menunggu');

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('tahun_awal') && $request->filled('tahun_akhir')) {
            $query->whereBetween('tahun', [$request->tahun_awal, $request->tahun_akhir]);
        }

        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }

        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        if ($request->filled('kegiatan')) {
            $query->where('kegiatan', $request->kegiatan);
        }

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_perolehan', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_perolehan', '<=', $request->tanggal_akhir);
        }

        $rawData = $query->selectRaw('tahun, kegiatan, COUNT(*) as total')
            ->groupBy('tahun', 'kegiatan')
            ->orderBy('tahun')
            ->get();

        $grafikData = [];
        foreach ($rawData as $row) {
            $grafikData[$row->tahun][$row->kegiatan] = $row->total;
        }

        $listTahun = MahasiswaLainnya::distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $listProdi = MahasiswaLainnya::distinct()->pluck('prodi')->filter()->values();

        return view('admin.rekap.grafik.grafikKaryamhsLainnya', compact(
            'title',
            'grafikData',
            'listTahun',
            'listProdi',
            'request'
        ));
    }
}
