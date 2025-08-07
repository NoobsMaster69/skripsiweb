<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PublikasiExport;
use App\Models\PublikasiMahasiswa;
use Maatwebsite\Excel\Facades\Excel;

class RekapRektoratpublikasiController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Rekap Rektorat "Publikasi Mahasiswa"';

        $query = PublikasiMahasiswa::query()
            ->where('kegiatan', 'Publikasi Mahasiswa')
            ->where('status', 'terverifikasi');

        // Filter dinamis
        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        if ($request->filled('fakultas')) {
            $query->where('fakultas', $request->fakultas);
        }

        if ($request->filled('jenis_publikasi')) {
            $query->where('jenis_publikasi', $request->jenis_publikasi);
        }

        if ($request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_perolehan', '>=', $request->tanggal_awal);
        }

        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_perolehan', '<=', $request->tanggal_akhir);
        }

        // Ambil data, filter atau tidak tetap tampil
        $publikasi = $query->orderBy('tanggal_perolehan', 'desc')->get();

        $listTahun = PublikasiMahasiswa::distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $listProdi = PublikasiMahasiswa::distinct()->pluck('prodi')->filter()->values();

        return view('rektorat.rekap.rekapPublikasi', compact('title', 'publikasi', 'request', 'listProdi', 'listTahun'));
    }

    public function exportExcel(Request $request)
    {
        $query = PublikasiMahasiswa::query();

        if ($request->filled('tahun')) $query->where('tahun', $request->tahun);
        if ($request->filled('prodi')) $query->where('prodi', $request->prodi);
        if ($request->filled('fakultas')) $query->where('fakultas', $request->fakultas);
        if ($request->filled('jenis_publikasi')) $query->where('jenis_publikasi', $request->jenis_publikasi);
        if ($request->filled('tanggal_awal')) $query->whereDate('tanggal_perolehan', '>=', $request->tanggal_awal);
        if ($request->filled('tanggal_akhir')) $query->whereDate('tanggal_perolehan', '<=', $request->tanggal_akhir);

        $query->where('kegiatan', 'Publikasi Mahasiswa');
        $query->where('status', 'terverifikasi');

        $data = $query->orderBy('tanggal_perolehan', 'desc')->get();


        return Excel::download(new PublikasiExport($data), 'publikasi_mahasiswa.xlsx');
    }


    public function exportPDF(Request $request)
    {
        $query = PublikasiMahasiswa::query();

        if ($request->filled('tahun')) $query->where('tahun', $request->tahun);
        if ($request->filled('prodi')) $query->where('prodi', $request->prodi);
        if ($request->filled('fakultas')) $query->where('fakultas', $request->fakultas);
        if ($request->filled('jenis_publikasi')) $query->where('jenis_publikasi', $request->jenis_publikasi);
        if ($request->filled('tanggal_awal')) $query->whereDate('tanggal_perolehan', '>=', $request->tanggal_awal);
        if ($request->filled('tanggal_akhir')) $query->whereDate('tanggal_perolehan', '<=', $request->tanggal_akhir);

        $query->where('kegiatan', 'Publikasi Mahasiswa');
        $query->where('status', 'terverifikasi');

        $data = $query->get();

        $pdf = Pdf::loadView('rektorat.rekap.publikasi_pdf', compact('data'))->setPaper('A4', 'landscape');
        return $pdf->download('publikasi_mahasiswa.pdf');
    }

    public function grafik(Request $request)
    {
        $title = 'Grafik Publikasi Mahasiswa';

        $query = PublikasiMahasiswa::query()
            ->where('kegiatan', 'Publikasi Mahasiswa')
            ->where('status', 'terverifikasi');

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
        if ($request->filled('jenis_publikasi')) $query->where('jenis_publikasi', $request->jenis_publikasi);
        if ($request->filled('tanggal_awal')) $query->whereDate('tanggal_perolehan', '>=', $request->tanggal_awal);
        if ($request->filled('tanggal_akhir')) $query->whereDate('tanggal_perolehan', '<=', $request->tanggal_akhir);

        // Ambil data terstruktur per tahun dan jenis publikasi
        $rawData = $query->selectRaw('tahun, jenis_publikasi, COUNT(*) as total')
            ->groupBy('tahun', 'jenis_publikasi')
            ->orderBy('tahun')
            ->get();

        $grafikData = [];
        $allJenis = ['jurnal_artikel', 'buku', 'media_massa'];

        foreach ($rawData as $row) {
            $tahun = $row->tahun;
            $jenis = $row->jenis_publikasi;
            $total = $row->total;

            $grafikData[$tahun][$jenis] = $total;
        }

        // Pastikan semua jenis ada untuk tiap tahun (agar grafik tidak kosong sebagian)
        foreach ($grafikData as $tahun => &$jenisData) {
            foreach ($allJenis as $jenis) {
                if (!isset($jenisData[$jenis])) {
                    $jenisData[$jenis] = 0;
                }
            }
            ksort($jenisData); // Urutkan agar tampilannya rapi
        }

        $listTahun = PublikasiMahasiswa::distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        $listProdi = PublikasiMahasiswa::distinct()->pluck('prodi')->filter()->values();
        $listFakultas = PublikasiMahasiswa::distinct()->pluck('fakultas')->filter()->values();

        return view('rektorat.rekap.grafik.grafikPublikasi', compact(
            'title',
            'grafikData',
            'listTahun',
            'listProdi',
            'listFakultas',
            'request'
        ));
    }
}
