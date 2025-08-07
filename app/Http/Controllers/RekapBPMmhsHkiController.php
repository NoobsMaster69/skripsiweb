<?php

namespace App\Http\Controllers;

use App\Exports\HkiExport;
use App\Models\MahasiswaHki;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class RekapBPMmhsHkiController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Rekap BPM Mahasiswa yang mendapatkan HKI';
        $shouldShowData = $request->isMethod('GET') && $request->has('submit_filter');

        $data = null;

        if ($shouldShowData) {
            $query = MahasiswaHki::query()
                ->where('kegiatan', 'HKI')
                ->where('status', 'terverifikasi');

            // Filter berdasarkan periode tahun
            if ($request->filled('periode_awal') && $request->filled('periode_akhir')) {
                $query->whereBetween('tahun', [$request->periode_awal, $request->periode_akhir]);
            } elseif ($request->filled('tahun')) {
                $query->where('tahun', $request->tahun);
            }

            if ($request->filled('fakultas')) {
                $query->where('fakultas', $request->fakultas);
            }

            if ($request->filled('prodi')) {
                $query->where('prodi', $request->prodi);
            }

            if ($request->filled('tanggal_awal')) {
                $query->whereDate('tanggal_perolehan', '>=', $request->tanggal_awal);
            }

            if ($request->filled('tanggal_akhir')) {
                $query->whereDate('tanggal_perolehan', '<=', $request->tanggal_akhir);
            }

            $data = $query->orderBy('tanggal_perolehan', 'desc')->get();
        }

        $listTahun = MahasiswaHki::distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $listFakultas = MahasiswaHki::distinct()->pluck('fakultas')->filter()->values();
        $listProdi = MahasiswaHki::distinct()->pluck('prodi')->filter()->values();

        return view('admin.rekap.rekapMhsHki', compact(
            'title',
            'data',
            'request',
            'listTahun',
            'listProdi',
            'listFakultas'
        ));
    }

    public function exportExcel(Request $request)
    {
        return Excel::download(new HkiExport($request->all()), 'hki_mahasiswa.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $query = MahasiswaHki::query()
            ->where('kegiatan', 'HKI')
            ->where('status', 'terverifikasi');

        if ($request->filled('periode_awal') && $request->filled('periode_akhir')) {
            $query->whereBetween('tahun', [$request->periode_awal, $request->periode_akhir]);
        } elseif ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }

        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_perolehan', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_perolehan', '<=', $request->tanggal_akhir);
        }

        $data = $query->orderBy('tanggal_perolehan', 'desc')->get();
        $tanggalCetak = now()->format('d M Y');

        return Pdf::loadView('admin.rekap.hki_pdf', compact('data', 'tanggalCetak'))
            ->setPaper('A4', 'landscape')
            ->download('hki_mahasiswa.pdf');
    }

    public function grafik(Request $request)
    {
        $title = 'Grafik Mahasiswa yang Mendapatkan HKI';

        $query = MahasiswaHki::query()
            ->where('kegiatan', 'HKI')
            ->where('status', 'terverifikasi');

        // Filter waktu
        if ($request->filled('periode_awal') && $request->filled('periode_akhir')) {
            $query->whereBetween('tahun', [$request->periode_awal, $request->periode_akhir]);
        } elseif ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }

        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_perolehan', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_perolehan', '<=', $request->tanggal_akhir);
        }

        // Ambil data: jumlah per fakultas per tahun
        $grafikData = $query->selectRaw('tahun, fakultas, COUNT(*) as total')
            ->groupBy('tahun', 'fakultas')
            ->orderBy('tahun')
            ->get();

        // Transformasi data ke format Chart.js
        $labels = $grafikData->pluck('tahun')->unique()->sort()->values()->all();
        $fakultasList = $grafikData->pluck('fakultas')->unique()->values()->all();

        $dataChart = [];

        foreach ($fakultasList as $fakultas) {
            $dataChart[$fakultas] = [];

            foreach ($labels as $tahun) {
                $item = $grafikData->firstWhere(fn($row) => $row->fakultas === $fakultas && $row->tahun == $tahun);
                $dataChart[$fakultas][] = $item ? $item->total : 0;
            }
        }

        // Kirim ke view
        $listTahun = MahasiswaHki::distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $listFakultas = MahasiswaHki::distinct()->pluck('fakultas')->filter()->values();
        $listProdi = MahasiswaHki::distinct()->pluck('prodi')->filter()->values();

        return view('admin.rekap.grafik.grafikMhsHki', compact(
            'title',
            'labels',
            'dataChart',
            'listTahun',
            'listProdi',
            'listFakultas',
            'request'
        ));
    }
}
