<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\MahasiswaLainnya;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MhsKaryaLainnyaExport;

class RekapFakulmhsKaryalainnyaController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Rekap Fakultas "Karya Mahasiswa Lainnya"';

        // Tampilkan data saat tombol submit ditekan, meskipun filter kosong
        $showData = $request->isMethod('GET') && $request->has('submit_filter');

        $data = null;

        if ($showData) {
            $query = MahasiswaLainnya::query();

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

        return view('fakultas.rekap.rekapKaryaLain', compact('title', 'data', 'request', 'listProdi', 'listTahun'));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new MhsKaryaLainnyaExport($request->all()), 'karya_mahasiswa_lainnya.xlsx');
    }
    public function exportPDF(Request $request)
    {
        $query = MahasiswaLainnya::query();

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

        // $query->where('kegiatan', 'Karya Mahasiswa Lainnya');
        // $query->where('status', 'terverifikasi');

        $data = $query->get();

        $pdf = Pdf::loadView('fakultas.rekap.karyalainnya_pdf', compact('data'))->setPaper('A4', 'landscape');
        return $pdf->download('karya_mahasiswa_lainnya.pdf');
    }
    public function grafik(Request $request)
    {
        $title = 'Grafik Karya Mahasiswa Lainnya';

        $query = MahasiswaLainnya::query();

        if ($request->filled('tahun')) $query->where('tahun', $request->tahun);

        if ($request->filled('tahun_awal') && $request->filled('tahun_akhir')) {
            $query->whereBetween('tahun', [$request->tahun_awal, $request->tahun_akhir]);
        } else {
            if ($request->filled('tahun')) {
                $query->where('tahun', $request->tahun);
            }
        }


        if ($request->filled('fakultas')) $query->where('fakultas', $request->fakultas);
        if ($request->filled('prodi')) $query->where('prodi', $request->prodi);
        if ($request->filled('kegiatan')) $query->where('kegiatan', $request->kegiatan);
        if ($request->filled('tanggal_awal')) $query->whereDate('tanggal_perolehan', '>=', $request->tanggal_awal);
        if ($request->filled('tanggal_akhir')) $query->whereDate('tanggal_perolehan', '<=', $request->tanggal_akhir);

        // Grouped by tahun + kegiatan
        $rawData = $query->selectRaw('tahun, kegiatan, COUNT(*) as total')
            ->groupBy('tahun', 'kegiatan')
            ->orderBy('tahun')
            ->get();

        // Reformatted to grouped bar chart format
        $grafikData = [];
        foreach ($rawData as $row) {
            $grafikData[$row->tahun][$row->kegiatan] = $row->total;
        }

        $listTahun = MahasiswaLainnya::distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $listProdi = MahasiswaLainnya::distinct()->pluck('prodi')->filter()->values();

        return view('fakultas.rekap.grafik.grafikKaryamhsLainnya', compact(
            'title',
            'grafikData',
            'listTahun',
            'listProdi',
            'request'
        ));
    }
}
