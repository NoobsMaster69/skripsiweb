<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RataIpk;
use App\Exports\RekapIpkExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf; // Perbaikan: gunakan facade PDF yang benar

class RekapIpkController extends Controller
{
    public function index(Request $request)
    {
        $query = RataIpk::query();

        // Filter berdasarkan Tahun Lulus
        if ($request->filled('tahun_lulus')) {
            $query->where('tahun_lulus', $request->tahun_lulus);
        }

        // Filter berdasarkan Prodi
        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        // Ambil data dan urutkan
        $data = $query->orderBy('created_at', 'desc')->get();

        // Ambil pilihan tahun dan prodi unik
        $tahunOptions = RataIpk::select('tahun_lulus')->distinct()->pluck('tahun_lulus');
        $prodiOptions = RataIpk::select('prodi')->distinct()->pluck('prodi');

        // Hitung rata-rata IPK
        $averageIpk = $query->avg('ipk') ?: 0;

        return view('admin.rekapIPK.index', [
            'title' => 'Rekap Data IPK Mahasiswa',
            'dataIpk' => $data,
            'averageIpk' => $averageIpk,
            'tahunOptions' => $tahunOptions,
            'prodiOptions' => $prodiOptions,
            'filters' => $request->only(['tahun_lulus', 'prodi'])
        ]);
    }

    public function exportExcel(Request $request)
    {
        $filters = $request->only(['tahun_lulus', 'prodi']);
        return Excel::download(new RekapIpkExport($filters), 'rekap_ipk.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = RataIpk::query();

        if ($request->filled('tahun_lulus')) {
            $query->where('tahun_lulus', $request->tahun_lulus);
        }

        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        $data = $query->get();

        $pdf = Pdf::loadView('admin.rekapIPK.pdf', compact('data'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('rekap_ipk.pdf');
    }
}
