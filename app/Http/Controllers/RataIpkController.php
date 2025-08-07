<?php

namespace App\Http\Controllers;

use App\Models\RataIpk;
use Illuminate\Http\Request;
use App\Exports\RataIpkExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class RataIpkController extends Controller
{
    public function index(Request $request)
    {
        $query = RataIpk::query();

        if ($request->filled('tahun_lulus')) {
            $query->byTahun($request->tahun_lulus);
        }

        if ($request->filled('prodi')) {
            $query->byProdi($request->prodi);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $rataIpk = $query->orderBy('created_at', 'desc')->paginate(10);

        $tahunOptions = RataIpk::distinct()->pluck('tahun_lulus')->filter()->sort()->values();
        $prodiOptions = RataIpk::distinct()->pluck('prodi')->filter()->sort()->values();

        $averageIpk = $query->avg('ipk') ?: 0;

        return view('admin/dok-pendidikan/rata-ipk/index', [
            'title' => 'Rata-Rata IPK',
            'menuProdiCpl' => 'active',
            'rataIpk' => $rataIpk,
            'tahunOptions' => $tahunOptions,
            'prodiOptions' => $prodiOptions,
            'averageIpk' => $averageIpk,
            'filters' => $request->only(['tahun_lulus', 'prodi', 'search'])
        ]);
    }

    public function create()
    {
        return view('admin/dok-pendidikan/rata-ipk/create', [
            'title' => 'Tambah Data Rata-Rata IPK',
            'menuProdiCpl' => 'active',
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|string|max:20|unique:rata_ipk,nim',
            'nama' => 'required|string|max:100',
            'prodi' => 'required|string|max:100',
            'tahun_lulus' => 'required|string|max:10',
            'tanggal_lulus' => 'required|date',
            'ipk' => 'required|numeric|between:0,4.00',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        RataIpk::create($request->all());

        return redirect()->route('RataIpk')->with('success', 'Data berhasil ditambahkan');
    }

    public function show($id)
    {
        $rataIpk = RataIpk::findOrFail($id);
        return view('admin/dok-pendidikan/rata-ipk/show', [
            'title' => 'Detail Data Rata-Rata IPK',
            'menuProdiCpl' => 'active',
            'rataIpk' => $rataIpk
        ]);
    }

    public function edit($id)
    {
        $rataIpk = RataIpk::findOrFail($id);
        return view('admin/dok-pendidikan/rata-ipk/edit', [
            'title' => 'Edit Data Rata-Rata IPK',
            'menuProdiCpl' => 'active',
            'rataIpk' => $rataIpk
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nim' => 'required|string|max:20',
            'nama' => 'required|string|max:100',
            'prodi' => 'required|string|max:100',
            'tahun_lulus' => 'required|digits:4',
            'tanggal_lulus' => 'required|date',
            'ipk' => 'required|numeric|between:0,4.00',
            'predikat' => 'required|string|max:50',
        ]);

        $rataIpk = RataIpk::findOrFail($id);
        $rataIpk->update([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'prodi' => $request->prodi,
            'tahun_lulus' => $request->tahun_lulus,
            'tanggal_lulus' => $request->tanggal_lulus,
            'ipk' => $request->ipk,
            'predikat' => $request->predikat,
        ]);


        return redirect()->route('RataIpk')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $data = RataIpk::findOrFail($id);
        $data->delete();

        return redirect()->route('RataIpk')->with('success', 'Data berhasil dihapus!');
    }

    public function export(Request $request)
    {
        $query = RataIpk::query();

        if ($request->filled('tahun_lulus')) {
            $query->byTahun($request->tahun_lulus);
        }

        if ($request->filled('prodi')) {
            $query->byProdi($request->prodi);
        }

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $filename = 'rata-ipk-' . date('Y-m-d-H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'NIM', 'Nama', 'Prodi', 'Tahun Lulus', 'Tanggal Lulus', 'IPK', 'Predikat']);
            foreach ($data as $index => $row) {
                fputcsv($file, [
                    $index + 1,
                    $row->nim,
                    $row->nama,
                    $row->prodi,
                    $row->tahun_lulus,
                    $row->tanggal_lulus->format('d-m-Y'),
                    $row->ipk,
                    $row->predikat
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportExcel(Request $request)
    {
        $query = RataIpk::query();

        if ($request->filled('tahun_lulus')) {
            $query->where('tahun_lulus', $request->tahun_lulus);
        }

        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('nim', 'like', '%' . $request->search . '%');
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $filename = 'rata-ipk-mahasiswa-' . date('Y-m-d-H-i-s') . '.xlsx';

        return Excel::download(new RataIpkExport($data), $filename);
    }


    public function exportPDF()
    {
        $data = RataIpk::orderBy('tahun_lulus', 'desc')->get();

        $pdf = Pdf::loadView('admin.dok-pendidikan.rata-ipk.pdf', [
            'rataipk' => $data,
            'title' => 'Laporan Rata-Rata IPK Mahasiswa',
            'tanggal' => now()
        ]);

        return $pdf->download('laporan-rata-ipk-' . now()->format('Ymd-His') . '.pdf');
    }



    public function statistics(Request $request)
    {
        $prodi = $request->get('prodi');
        $tahun = $request->get('tahun_lulus');

        $avgIpk = RataIpk::getAverageIpkByProdi($prodi, $tahun);
        $predikatStats = RataIpk::getPredikatStats($prodi, $tahun);
        $totalMahasiswa = RataIpk::when($prodi, fn($q) => $q->byProdi($prodi))
            ->when($tahun, fn($q) => $q->byTahun($tahun))
            ->count();

        return view('admin/dok-pendidikan/rata-ipk/statistics', [
            'title' => 'Statistik Rata-Rata IPK',
            'menuProdiCpl' => 'active',
            'rata_rata_ipk' => round($avgIpk, 2),
            'total_mahasiswa' => $totalMahasiswa,
            'statistik_predikat' => $predikatStats,
            'prodi' => $prodi,
            'tahun' => $tahun
        ]);
    }
}
