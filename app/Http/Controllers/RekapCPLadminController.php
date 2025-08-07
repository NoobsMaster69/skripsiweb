<?php

namespace App\Http\Controllers;

use App\Models\MasterCpl;
use Illuminate\Http\Request;
use App\Exports\RekapCplExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class RekapCPLadminController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Rekap CPL Admin';

        $targets = collect(); // Kosongkan data default

        if ($request->has('submit_filter')) {
            $query = MasterCpl::with('cplDosen');

            if ($request->filled('tahun')) {
                $query->where('tahun_akademik', $request->tahun);
            }

            if ($request->filled('program_studi')) {
                $query->where('program_studi', $request->program_studi);
            }

            if ($request->filled('mata_kuliah')) {
                $query->where('mata_kuliah', $request->mata_kuliah);
            }


            $targets = $query->orderBy('created_at', 'desc')->get();
        }

        $listTahun = MasterCpl::select('tahun_akademik')->distinct()->pluck('tahun_akademik');
        $listProdi = MasterCpl::select('program_studi')->distinct()->pluck('program_studi');
        $listMatkul = MasterCpl::select('mata_kuliah')->distinct()->pluck('mata_kuliah');

        return view('admin.rekapCpl.rekapCpl', compact('title', 'targets', 'listTahun', 'listProdi', 'listMatkul'));
    }
    public function exportExcel(Request $request)
    {
        $query = MasterCpl::with('cplDosen');

        if ($request->filled('tahun')) {
            $query->where('tahun_akademik', $request->tahun);
        }
        if ($request->filled('program_studi')) {
            $query->where('program_studi', $request->program_studi);
        }
        if ($request->filled('mata_kuliah')) {
            $query->where('mata_kuliah', $request->mata_kuliah);
        }

        $data = $query->get();

        return Excel::download(new RekapCplExport($data), 'rekap_cpl_' . date('Y-m-d_H-i-s') . '.xlsx');
    }

    public function exportPdf(Request $request)
    {
        $query = MasterCpl::with('cplDosen');

        if ($request->filled('tahun')) {
            $query->where('tahun_akademik', $request->tahun);
        }
        if ($request->filled('program_studi')) {
            $query->where('program_studi', $request->program_studi);
        }
        if ($request->filled('mata_kuliah')) {
            $query->where('mata_kuliah', $request->mata_kuliah);
        }

        $data = $query->get();

        $pdf = Pdf::loadView('admin.rekapCpl.rekapCPL_pdf', compact('data'));
        return $pdf->download('rekap_cpl.pdf');
    }

    public function grafik(Request $request)
    {
        $title = 'Grafik Rekap CPL';

        $query = MasterCpl::with('cplDosen');

        // Tambahan: filter mata kuliah
        if ($request->filled('mata_kuliah')) {
            $query->where('mata_kuliah', $request->mata_kuliah);
        }

        // Filter berdasarkan tahun atau periode
        if ($request->filled('tahun_awal') && $request->filled('tahun_akhir')) {
            $query->whereBetween('tahun_akademik', [$request->tahun_awal, $request->tahun_akhir]);
        } elseif ($request->filled('tahun')) {
            $query->where('tahun_akademik', $request->tahun);
        }

        $masterCpl = $query->get();

        $parseAngka = function ($value) {
            if (is_null($value)) return 0;
            if (is_numeric($value)) return floatval($value);
            $clean = preg_replace('/[^0-9.]/', '', $value);
            return is_numeric($clean) ? floatval($clean) : 0;
        };

        if ($request->filled('tahun') && !$request->filled('tahun_awal') && !$request->filled('tahun_akhir')) {
            $data = $masterCpl->map(function ($item) use ($parseAngka) {
                return [
                    'tahun' => $item->tahun_akademik,
                    'matkul' => $item->mata_kuliah,
                    'rata_target' => $parseAngka($item->target_pencapaian),
                    'rata_ketercapaian' => $parseAngka(optional($item->cplDosen)->ketercapaian),
                ];
            })->filter(fn($d) => $d['rata_target'] > 0 || $d['rata_ketercapaian'] > 0)->values();
        } else {
            $data = $masterCpl->groupBy('tahun_akademik')->map(function ($group) use ($parseAngka) {
                return [
                    'tahun' => $group->first()->tahun_akademik,
                    'rata_target' => $group->avg(fn($item) => $parseAngka($item->target_pencapaian)),
                    'rata_ketercapaian' => $group->avg(fn($item) => $parseAngka(optional($item->cplDosen)->ketercapaian)),
                ];
            })->values();
        }

        $listTahun = MasterCpl::select('tahun_akademik')->distinct()->pluck('tahun_akademik');
        $listMatkul = MasterCpl::select('mata_kuliah')->distinct()->pluck('mata_kuliah'); // Tambah ini

        return view('admin.rekapCpl.grafikCpl', compact('title', 'data', 'listTahun', 'listMatkul'));
    }
}
