<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\KaryaMahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KaryaMahasiswaExport;
use Illuminate\Support\Facades\Storage;

class KaryaMhsFtiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karya = KaryaMahasiswa::orderBy('created_at', 'desc')->get();

        $data = [
            'title' => 'Karya Mahasiswa FTI',
            'karyaMahasiswa' => $karya,
            'jumlahPublikasi' => $karya->where('kegiatan', 'Publikasi')->count(),
            'jumlahKarya' => $karya->where('kegiatan', 'Karya')->count(),
            'jumlahProduk' => $karya->where('kegiatan', 'Produk')->count(),
            'jumlahHki' => $karya->where('kegiatan', 'Hki')->count()
        ];

        return view('prodi.fti.karya-mahasiswa.index', $data);
    }

    public function create()
    {
        return view('prodi.fti.karya-mahasiswa.create', [
            'title' => 'Tambah Karya Mahasiswa FTI'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_mhs' => 'required|string|max:255',
            'tahun' => 'required|string|max:20',
            'judul_karya' => 'required|string|max:500',
            'kegiatan' => 'required|in:Publikasi,Karya,Produk,Hki',
            'tingkat' => 'required|in:local-wilayah,nasional,internasional',
            'file_upload' => 'required|file|mimes:pdf,docx,jpg,jpeg|max:2048'
        ]);

        $fileName = null;
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $fileName = time() . '_' . Str::slug($request->nm_mhs) . '.' . $file->extension();
            $file->storeAs('karya-mahasiswa', $fileName, 'public');
        }

        KaryaMahasiswa::create([
            'nm_mhs' => $request->nm_mhs,
            'tahun' => $request->tahun,
            'judul_karya' => $request->judul_karya,
            'kegiatan' => $request->kegiatan,
            'tingkat' => $request->tingkat,
            'file_upload' => $fileName ? 'karya-mahasiswa/' . $fileName : null
        ]);

        return redirect()->route('karya-mahasiswa-fti')->with('success', 'Data karya mahasiswa berhasil ditambahkan!');
    }

    public function show(KaryaMahasiswa $karyaMahasiswa)
    {
        return view('karya-mahasiswa-fti.show', [
            'title' => 'Detail Karya Mahasiswa',
            'karya' => $karyaMahasiswa
        ]);
    }

    public function edit(KaryaMahasiswa $karyaMahasiswa)
    {
        return view('prodi.fti.karya-mahasiswa.edit', [
            'title' => 'Edit Karya Mahasiswa',
            'karya' => $karyaMahasiswa
        ]);
    }

    public function update(Request $request, KaryaMahasiswa $karyaMahasiswa)
    {
        $request->validate([
            'nm_mhs' => 'required|string|max:255',
            'tahun' => 'required|string|max:20',
            'judul_karya' => 'required|string|max:500',
            'kegiatan' => 'required|in:Publikasi,Karya,Produk,Hki',
            'tingkat' => 'required|in:local-wilayah,nasional,internasional',
            'file_upload' => 'nullable|file|mimes:pdf,docx,jpg,jpeg|max:2048'
        ]);

        $fileName = $karyaMahasiswa->file_upload;
        if ($request->hasFile('file_upload')) {
            if ($fileName && Storage::disk('public')->exists($fileName)) {
                Storage::disk('public')->delete($fileName);
            }

            $file = $request->file('file_upload');
            $fileName = time() . '_' . Str::slug($request->nm_mhs) . '.' . $file->extension();
            $file->storeAs('karya-mahasiswa', $fileName, 'public');
            $fileName = 'karya-mahasiswa/' . $fileName;
        }

        $karyaMahasiswa->update([
            'nm_mhs' => $request->nm_mhs,
            'tahun' => $request->tahun,
            'judul_karya' => $request->judul_karya,
            'kegiatan' => $request->kegiatan,
            'tingkat' => $request->tingkat,
            'file_upload' => $fileName
        ]);

        return redirect()->route('karya-mahasiswa-fti')->with('success', 'Data karya mahasiswa berhasil diupdate!');
    }

    public function destroy(KaryaMahasiswa $karyaMahasiswa)
    {
        try {
            if ($karyaMahasiswa->file_upload && Storage::disk('public')->exists($karyaMahasiswa->file_upload)) {
                Storage::disk('public')->delete($karyaMahasiswa->file_upload);
            }

            $karyaMahasiswa->delete();

            return redirect()->route('karya-mahasiswa-fti')->with('success', 'Data karya mahasiswa berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('karya-mahasiswa-fti')->with('error', 'Terjadi kesalahan saat menghapus data!');
        }
    }

    public function exportPdf(Request $request)
    {
        $query = KaryaMahasiswa::query();

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where('nama_mahasiswa', 'like', '%' . $request->search . '%')
                ->orWhere('judul_karya', 'like', '%' . $request->search . '%');
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('prodi.fti.karya-mahasiswa.pdf', [
            'karyaMahasiswa' => $data,
            'title' => 'Laporan Karya Mahasiswa FTI',
            'tanggal' => date('d F Y')
        ]);

        $filename = 'karya-mahasiswa-fti-' . date('Y-m-d-H-i-s') . '.pdf';

        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        $query = KaryaMahasiswa::query();

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where('nama_mahasiswa', 'like', '%' . $request->search . '%')
                ->orWhere('judul_karya', 'like', '%' . $request->search . '%');
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $filename = 'karya-mahasiswa-fti-' . date('Y-m-d-H-i-s') . '.xlsx';

        return Excel::download(new KaryaMahasiswaExport($data), $filename);
    }

    public function validateDokumen()
    {
        return view('admin/dok-pendidikan/karya-mahasiswa/validate', [
            'title' => 'Validasi Dokumen Karya Mahasiswa'
        ]);
    }
}
