<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\RekapserkomExport;
use App\Models\SertifkompMahasiswa;
use Maatwebsite\Excel\Facades\Excel;

class RekapProdiSerkomController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Rekap Prodi "Sertifikasi Kompetensi Mahasiswa"';

        // Default nilai kosong
        $sertifikasi = collect();
        $jumlahInternasional = 0;
        $jumlahNasional = 0;
        $jumlahLokal = 0;

        // Tampilkan data hanya jika tombol filter diklik
        if ($request->has('submit_filter')) {
            $query = SertifkompMahasiswa::query();

            if ($request->filled('tahun')) {
                $query->where('tahun', $request->tahun);
            }

            if ($request->filled('prodi')) {
                $query->where('prodi', $request->prodi);
            }

            if ($request->filled('fakultas')) {
                $query->where('fakultas', $request->fakultas);
            }

            if ($request->filled('tingkatan')) {
                $query->where('tingkatan', $request->tingkatan);
            }

            if ($request->filled('kegiatan')) {
                $query->where('kegiatan', $request->kegiatan);
            }

            if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
                $query->whereBetween('tanggal_perolehan', [
                    $request->tanggal_awal,
                    $request->tanggal_akhir
                ]);
            }

            $sertifikasi = $query->orderByDesc('created_at')->get();

            // Hitung rekap jumlah
            $jumlahInternasional = $sertifikasi->where('tingkatan', 'internasional')->count();
            $jumlahNasional = $sertifikasi->where('tingkatan', 'nasional')->count();
            $jumlahLokal = $sertifikasi->where('tingkatan', 'lokal')->count();
        }

        $listTahun = SertifkompMahasiswa::distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $listProdi = SertifkompMahasiswa::distinct()->pluck('prodi')->filter()->values();
        return view('prodi.fti.rekap.rekapSerkom', compact(
            'title',
            'sertifikasi',
            'jumlahInternasional',
            'jumlahNasional',
            'jumlahLokal',
            'listProdi',
            'listTahun'
        ));
    }

    public function grafik(Request $request)
    {
        $title = 'Grafik Sertifikasi Kompetensi Mahasiswa';

        $query = SertifkompMahasiswa::whereNotIn('status', ['menunggu', 'belum_verifikasi']);

        if ($request->filled('tahun')) $query->where('tahun', $request->tahun);
        if ($request->filled('fakultas')) $query->where('fakultas', $request->fakultas);
        if ($request->filled('prodi')) $query->where('prodi', $request->prodi);
        if ($request->filled('tingkatan')) $query->where('tingkatan', $request->tingkatan);
        if ($request->filled('kegiatan')) $query->where('kegiatan', $request->kegiatan);

        if ($request->filled('tahun_awal') && $request->filled('tahun_akhir')) {
            $query->whereBetween('tahun', [$request->tahun_awal, $request->tahun_akhir]);
        } elseif ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        $result = $query->selectRaw('tahun, tingkatan, COUNT(*) as total')
            ->groupBy('tahun', 'tingkatan')
            ->orderBy('tahun')
            ->get();

        // Transform ke format grouped per tahun
        $grouped = [];

        foreach ($result as $item) {
            $tahun = $item->tahun;
            $tingkatan = strtolower($item->tingkatan);

            if (!isset($grouped[$tahun])) {
                $grouped[$tahun] = ['lokal' => 0, 'nasional' => 0, 'internasional' => 0];
            }

            $grouped[$tahun][$tingkatan] = $item->total;
        }

        // Ambil list tahun dan isi dataset per tingkatan
        $labels = array_keys($grouped);
        $datasetLokal = [];
        $datasetNasional = [];
        $datasetInternasional = [];

        foreach ($labels as $tahun) {
            $datasetLokal[] = $grouped[$tahun]['lokal'];
            $datasetNasional[] = $grouped[$tahun]['nasional'];
            $datasetInternasional[] = $grouped[$tahun]['internasional'];
        }

        // Dropdown filter
        $listTahun = SertifkompMahasiswa::distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $listProdi = SertifkompMahasiswa::distinct()->pluck('prodi')->filter()->values();

        return view('prodi.fti.rekap.grafik.grafikSerkom', compact(
            'title',
            'labels',
            'datasetLokal',
            'datasetNasional',
            'datasetInternasional',
            'listTahun',
            'listProdi',
            'request'
        ));
    }
    public function exportExcel(Request $request)
    {
        $filter = $request->all();
        return Excel::download(new RekapserkomExport($filter), 'sertifikasi_mahasiswa.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $query = SertifkompMahasiswa::query();

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }
        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }
        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }
        if ($request->filled('tingkatan')) {
            $query->where('tingkatan', $request->tingkatan);
        }
        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_perolehan', '>=', $request->tanggal_awal);
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_perolehan', '<=', $request->tanggal_akhir);
        }
        if ($request->filled('kegiatan')) {
            $query->where('kegiatan', $request->kegiatan);
        }

        $data = $query->get();

        // ⬇ Ini bagian yang kamu tanya
        $pdf = Pdf::loadView('prodi.fti.rekap.serkom_pdf', ['data' => $data])
            ->setPaper('A4', 'landscape');

        return $pdf->download('sertifikasi_mahasiswa.pdf');
    }
}
