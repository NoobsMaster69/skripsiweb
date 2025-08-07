<?php

namespace App\Http\Controllers;

use App\Models\MasterCpl;
use App\Models\MahasiswaHki;
use Illuminate\Http\Request;
use App\Models\RekognisiDosen;
use App\Models\PrestasiMahasiswa;
use App\Models\SertifkompMahasiswa;

class DashbordFakultasController extends Controller
{
    public function dashboard(Request $request)
    {
        $title = 'Dashboard Fakultas';

        // ===== CPL (seperti sebelumnya)
        $masterCpl = MasterCpl::with('cplDosen')->get();
        $parseAngka = fn($value) => is_numeric($value) ? floatval($value) : floatval(preg_replace('/[^0-9.]/', '', $value ?? '0'));
        $dataCPL = $masterCpl->groupBy('tahun_akademik')->map(function ($group) use ($parseAngka) {
            $targets = $group->map(fn($item) => $parseAngka($item->target_pencapaian))->filter(fn($v) => $v > 0);
            $capaians = $group->map(fn($item) => $parseAngka(optional($item->cplDosen)->ketercapaian))->filter(fn($v) => $v > 0);
            return [
                'tahun' => $group->first()->tahun_akademik,
                'rata_target' => $targets->avg() ?? 0,
                'rata_ketercapaian' => $capaians->avg() ?? 0,
            ];
        })->values();

        // ===== Grafik Rekognisi Dosen
        $rekognisi = RekognisiDosen::whereNotIn('status', ['menunggu', 'ditolak'])->get();

        $rekognisiGrouped = [];

        foreach ($rekognisi as $item) {
            $tahun = $item->tahun_akademik;
            $bidang = $item->bidang_rekognisi;

            if (!isset($rekognisiGrouped[$tahun])) {
                $rekognisiGrouped[$tahun] = [];
            }

            if (!isset($rekognisiGrouped[$tahun][$bidang])) {
                $rekognisiGrouped[$tahun][$bidang] = 0;
            }

            $rekognisiGrouped[$tahun][$bidang]++;
        }

        // ===== Grafik Prestasi Mahasiswa
        $prestasi = PrestasiMahasiswa::where('status', 'terverifikasi')->get();

        $mapTingkat = [
            'local-wilayah' => 'Wilayah',
            'lokal' => 'Wilayah',
            'local' => 'Wilayah',
            'nasional' => 'Nasional',
            'internasional' => 'Internasional',
        ];

        $dataChartPrestasi = [];

        foreach ($prestasi as $item) {
            $rawTingkat = strtolower($item->tingkat);
            $tingkatKey = $mapTingkat[$rawTingkat] ?? null;
            $tahun = $item->tahun;

            if (!$tingkatKey || !in_array($item->prestasi, ['prestasi-akademik', 'prestasi-non-akademik'])) {
                continue;
            }

            if (!isset($dataChartPrestasi[$tahun])) {
                $dataChartPrestasi[$tahun] = ['Wilayah' => 0, 'Nasional' => 0, 'Internasional' => 0];
            }

            $dataChartPrestasi[$tahun][$tingkatKey]++;
        }

        // ===== Grafik Serkom
        $sertifikasi = SertifkompMahasiswa::selectRaw('YEAR(tanggal_perolehan) as tahun, tingkatan, COUNT(*) as total')
            ->groupByRaw('YEAR(tanggal_perolehan), tingkatan')
            ->orderByRaw('YEAR(tanggal_perolehan)')
            ->get();

        // Buat struktur data grafik grouped bar chart
        $labels = $sertifikasi->pluck('tahun')->unique()->values()->all();

        $datasetLokal = [];
        $datasetNasional = [];
        $datasetInternasional = [];

        foreach ($labels as $tahun) {
            $datasetLokal[] = $sertifikasi->where('tahun', $tahun)->where('tingkatan', 'lokal')->sum('total');
            $datasetNasional[] = $sertifikasi->where('tahun', $tahun)->where('tingkatan', 'nasional')->sum('total');
            $datasetInternasional[] = $sertifikasi->where('tahun', $tahun)->where('tingkatan', 'internasional')->sum('total');
        }

        // ===== Grafik Mahasiswa HKI
        $hkiData = MahasiswaHki::where('kegiatan', 'HKI')
            ->where('status', 'terverifikasi')
            ->selectRaw('tahun, fakultas, COUNT(*) as total')
            ->groupBy('tahun', 'fakultas')
            ->orderBy('tahun')
            ->get();

        // Ambil labels tahun dan fakultas unik
        $labelsHki = $hkiData->pluck('tahun')->unique()->sort()->values()->all();
        $fakultasList = $hkiData->pluck('fakultas')->unique()->values()->all();

        // Siapkan struktur data untuk Chart.js
        $dataChartHki = [];

        foreach ($fakultasList as $fakultas) {
            $dataChartHki[$fakultas] = [];

            foreach ($labelsHki as $tahun) {
                $item = $hkiData->firstWhere(fn($row) => $row->fakultas === $fakultas && $row->tahun == $tahun);
                $dataChartHki[$fakultas][] = $item ? $item->total : 0;
            }
        }

        // ===== Grafik Publikasi Mahasiswa
        $publikasi = \App\Models\PublikasiMahasiswa::where('kegiatan', 'Publikasi Mahasiswa')
            ->where('status', 'terverifikasi')
            ->selectRaw('tahun, jenis_publikasi, COUNT(*) as total')
            ->groupBy('tahun', 'jenis_publikasi')
            ->orderBy('tahun')
            ->get();

        $grafikPublikasi = [];
        $jenisPublikasi = ['jurnal_artikel', 'buku', 'media_massa'];

        foreach ($publikasi as $row) {
            $tahun = $row->tahun;
            $jenis = $row->jenis_publikasi;
            $grafikPublikasi[$tahun][$jenis] = $row->total;
        }

        // Pastikan semua jenis ada di setiap tahun
        foreach ($grafikPublikasi as $tahun => &$jenisData) {
            foreach ($jenisPublikasi as $jenis) {
                if (!isset($jenisData[$jenis])) {
                    $jenisData[$jenis] = 0;
                }
            }
            ksort($jenisData);
        }

        $labelsPublikasi = array_keys($grafikPublikasi);


        // ===== Grafik Adopsi Mahasiswa
        $adopsiData = \App\Models\MahasiswaDiadop::selectRaw('tahun, kegiatan, COUNT(*) as total')
            ->groupBy('tahun', 'kegiatan')
            ->orderBy('tahun')
            ->get();

        $grafikAdopsi = [];
        $jenisAdopsi = ['Produk', 'Jasa'];

        foreach ($adopsiData as $row) {
            $tahun = $row->tahun;
            $kegiatan = $row->kegiatan;
            $grafikAdopsi[$tahun][$kegiatan] = $row->total;
        }

        // Pastikan semua jenis ada di setiap tahun
        foreach ($grafikAdopsi as $tahun => &$data) {
            foreach ($jenisAdopsi as $jenis) {
                if (!isset($data[$jenis])) {
                    $data[$jenis] = 0;
                }
            }
            ksort($data);
        }

        $labelsAdopsi = array_keys($grafikAdopsi);

        // ===== Grafik Karya Mahasiswa Lainnya
        $karyaLainnya = \App\Models\MahasiswaLainnya::selectRaw('tahun, kegiatan, COUNT(*) as total')
            ->groupBy('tahun', 'kegiatan')
            ->orderBy('tahun')
            ->get();

        $grafikKaryaLain = [];
        $jenisKaryaLain = ['Produk', 'Jasa', 'Karya Inovatif', 'Karya Sosial'];

        foreach ($karyaLainnya as $row) {
            $tahun = $row->tahun;
            $jenis = $row->kegiatan;
            $grafikKaryaLain[$tahun][$jenis] = $row->total;
        }

        // Pastikan setiap jenis muncul di setiap tahun
        foreach ($grafikKaryaLain as $tahun => &$item) {
            foreach ($jenisKaryaLain as $jenis) {
                if (!isset($item[$jenis])) {
                    $item[$jenis] = 0;
                }
            }
            ksort($item);
        }
        $labelsKaryaLain = array_keys($grafikKaryaLain);


        return view('dashboardFakul', compact(
            'title',
            'dataCPL',
            'labels',
            'datasetLokal',
            'datasetNasional',
            'datasetInternasional',
            'rekognisiGrouped',
            'dataChartPrestasi',
            'labelsHki',
            'dataChartHki',
            'labelsPublikasi',
            'grafikPublikasi',
            'grafikAdopsi',
            'labelsAdopsi',
            'grafikKaryaLain',
            'labelsKaryaLain',

        ));
    }
}

