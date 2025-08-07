<?php
namespace App\Http\Controllers;

use App\Exports\HkiExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\MahasiswaHki;
use Maatwebsite\Excel\Facades\Excel;

class RekapFakulmhsHkiController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Rekap Fakultas "Mahasiswa yang mendapatkan HKI"';

        // Tampilkan data saat tombol filter diklik, meskipun tidak ada filter diisi
        $showData = $request->isMethod('GET') && $request->has('submit_filter');

        $data = null;

        if ($showData) {
            $query = MahasiswaHki::query()
                ->where('kegiatan', 'HKI')
                ->where('status', 'terverifikasi');

            if ($request->filled('tahun')) {
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
        $listProdi = MahasiswaHki::distinct()->pluck('prodi')->filter()->values();

        return view('fakultas.rekap.rekapMhsHki', compact('title', 'data', 'request', 'listProdi', 'listTahun'));
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

        if ($request->filled('tahun')) {
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

        return Pdf::loadView('fakultas.rekap.hki_pdf', compact('data', 'tanggalCetak'))
            ->setPaper('A4', 'landscape')
            ->download('hki_mahasiswa.pdf');
    }

    public function grafik(Request $request)
    {
        $title = 'Grafik Mahasiswa yang Mendapatkan HKI';

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

        $grafikData = $query->selectRaw('tahun, fakultas, COUNT(*) as total')
            ->groupBy('tahun', 'fakultas')
            ->orderBy('tahun')
            ->get();

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

        $listTahun = MahasiswaHki::distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $listFakultas = MahasiswaHki::distinct()->pluck('fakultas')->filter()->values();
        $listProdi = MahasiswaHki::distinct()->pluck('prodi')->filter()->values();

        return view('fakultas.rekap.grafik.grafikMhsHki', compact(
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
