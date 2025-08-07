<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MahasiswaDiadop;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapMahasiswaAdopsimasyExport;


class RekapFakulmhsAdopsiController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Rekap Fakultas "Karya Mahasiswa yang di Adopsi oleh Masyarakat"';

        $query = MahasiswaDiadop::query();

        if ($request->has('submit_filter')) {
            if ($request->filled('tahun')) {
                $query->where('tahun', $request->tahun);
            }

            if ($request->filled('prodi')) {
                $query->where('prodi', $request->prodi);
            }

            if ($request->filled('fakultas')) {
                $query->where('fakultas', $request->fakultas);
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
        } else {
            $data = collect(); // kosongkan jika belum submit filter
        }

        $listTahun = MahasiswaDiadop::distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $listProdi = MahasiswaDiadop::distinct()->pluck('prodi')->filter()->values();
        return view('fakultas.rekap.rekapMhsAdop', compact('title', 'data', 'request','listProdi','listTahun'));
    }
    public function exportExcel(Request $request)
    {
        $filters = $request->only([
            'tahun',
            'prodi',
            'fakultas',
            'kegiatan',
            'tanggal_awal',
            'tanggal_akhir'
        ]);

        return Excel::download(new RekapMahasiswaAdopsimasyExport($filters), 'Rekap_Mahasiswa_Adopsi.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $filters = $request->only([
            'tahun',
            'prodi',
            'fakultas',
            'kegiatan',
            'tanggal_awal',
            'tanggal_akhir'
        ]);

        $query = MahasiswaDiadop::query();

        foreach (['tahun', 'prodi', 'fakultas', 'kegiatan'] as $field) {
            if (!empty($filters[$field])) {
                $query->where($field, $filters[$field]);
            }
        }

        if (!empty($filters['tanggal_awal'])) {
            $query->whereDate('tanggal_perolehan', '>=', $filters['tanggal_awal']);
        }

        if (!empty($filters['tanggal_akhir'])) {
            $query->whereDate('tanggal_perolehan', '<=', $filters['tanggal_akhir']);
        }

        $data = $query->orderByDesc('tanggal_perolehan')->get();

        $pdf = Pdf::loadView('fakultas.rekap.mhsadopsi_pdf', [
            'data' => $data,
            'tanggal_cetak' => now()->format('d/m/Y'),
        ])->setPaper('A4', 'landscape');

        return $pdf->download('Rekap_Mahasiswa_Adopsi.pdf');
    }
    public function grafik(Request $request)
    {
        $title = 'Grafik Karya Mahasiswa yang Diadopsi oleh Masyarakat';

        $query = MahasiswaDiadop::query();

        // Apply filter
        if ($request->filled('tahun')) $query->where('tahun', $request->tahun);
        if ($request->filled('tahun_awal') && $request->filled('tahun_akhir')) {
            $query->whereBetween('tahun', [$request->tahun_awal, $request->tahun_akhir]);
        } else {
            if ($request->filled('tahun')) {
                $query->where('tahun', $request->tahun);
            }
        }

        if ($request->filled('prodi')) $query->where('prodi', $request->prodi);
        if ($request->filled('fakultas')) $query->where('fakultas', $request->fakultas);
        if ($request->filled('kegiatan')) $query->where('kegiatan', $request->kegiatan);
        if ($request->filled('tanggal_awal')) $query->whereDate('tanggal_perolehan', '>=', $request->tanggal_awal);
        if ($request->filled('tanggal_akhir')) $query->whereDate('tanggal_perolehan', '<=', $request->tanggal_akhir);

        // Grouped by tahun + kegiatan
        $rawData = $query->selectRaw('tahun, kegiatan, COUNT(*) as total')
            ->groupBy('tahun', 'kegiatan')
            ->orderBy('tahun')
            ->get();

        // Reformat untuk grafik grouped-bar
        $grafikData = [];
        foreach ($rawData as $row) {
            $grafikData[$row->tahun][$row->kegiatan] = $row->total;
        }

        $listTahun = MahasiswaDiadop::distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $listProdi = MahasiswaDiadop::distinct()->pluck('prodi')->filter()->values();
        $listFakultas = MahasiswaDiadop::distinct()->pluck('fakultas')->filter()->values();

        return view('fakultas.rekap.grafik.grafikMhsAdopsi', compact(
            'title',
            'grafikData',
            'listTahun',
            'listProdi',
            'listFakultas',
            'request'
        ));
    }
}

