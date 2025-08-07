<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PublikasiMahasiswa;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Exports\PublikasiMahasiswaExport;

class PublikasiMhsFtiController extends Controller
{
    public function index(Request $request)
    {
        $query = PublikasiMahasiswa::query()
            ->whereNotNull('status')
            ->where('kegiatan', 'Publikasi Mahasiswa')
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nm_mhs', 'like', "%$search%")
                    ->orWhere('nim', 'like', "%$search%")
                    ->orWhere('judul_karya', 'like', "%$search%");
            });
        }

        $karya = $query->get();

        $data = [
            'title' => 'Publikasi Mahasiswa ',
            'prestasiMahasiswa' => $karya,
            // ✅ DIPERBAIKI: Menghitung berdasarkan jenis_publikasi, bukan kegiatan
            'jumlahJurnalArtikel' => $karya->where('jenis_publikasi', 'jurnal_artikel')->count(),
            'jumlahBuku' => $karya->where('jenis_publikasi', 'buku')->count(),
            'jumlahMediaMassa' => $karya->where('jenis_publikasi', 'media_massa')->count(),

        ];

        return view('prodi.fti.karyamahasiswa.publikasimahasiswa.index', $data);
    }

    public function create()
    {
        return view('prodi.fti.karyamahasiswa.publikasimahasiswa.create', [
            'title' => 'Tambah Publikasi Mahasiswa'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_mhs' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'prodi' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'tahun' => 'required|string|max:20',
            'judul_karya' => 'required|string|max:500',
            'kegiatan' => 'required|in:Publikasi Mahasiswa',
            'jenis_publikasi' => 'required|in:jurnal_artikel,buku,media_massa',
            'tanggal_perolehan' => 'required|date',
            'file_upload' => 'required|file|mimes:pdf,docx,jpg,jpeg|max:2048'
        ]);

        $fileName = null;
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $fileName = time() . '_' . Str::slug($request->nm_mhs) . '.' . $file->extension();
            $file->storeAs('publikasimahasiswa', $fileName, 'public');
        }

        PublikasiMahasiswa::create([
            'nm_mhs' => $request->nm_mhs,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'fakultas' => $request->fakultas,
            'tahun' => $request->tahun,
            'judul_karya' => $request->judul_karya,
            'kegiatan' => $request->kegiatan,
            'jenis_publikasi' => $request->jenis_publikasi,
            'tanggal_perolehan' => $request->tanggal_perolehan,
            'file_upload' => $fileName ? 'publikasimahasiswa/' . $fileName : null
        ]);

        return redirect()->route('publikasi-mahasiswa-fti')->with('success', 'Data karya mahasiswa publikasi berhasil ditambahkan!');
    }

    public function show(PublikasiMahasiswa $publikasiMahasiswa)
    {
        return view('publikasi-mahasiswa-fti.show', [
            'title' => 'Detail Karya Publikasi Mahasiswa',
            'karya' => $publikasiMahasiswa
        ]);
    }

    public function edit(PublikasiMahasiswa $publikasiMahasiswa)
    {
        return view('prodi.fti.karyamahasiswa.publikasimahasiswa.edit', [
            'title' => 'Edit Karya Publikasi Mahasiswa',
            'karya' => $publikasiMahasiswa
        ]);
    }

    public function update(Request $request, PublikasiMahasiswa $publikasiMahasiswa)
    {
        $request->validate([
            'nm_mhs' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'prodi' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'tahun' => 'required|string|max:20',
            'judul_karya' => 'required|string|max:500',
            'kegiatan' => 'required|in:Publikasi Mahasiswa',
            // ✅ DIPERBAIKI: Konsisten menggunakan jenis_publikasi (huruf kecil)
            'jenis_publikasi' => 'required|in:jurnal_artikel,buku,media_massa',
            'tanggal_perolehan' => 'required|date_format:Y-m-d',
            'file_upload' => 'nullable|file|mimes:pdf,docx,jpg,jpeg|max:2048'
        ]);

        $fileName = $publikasiMahasiswa->file_upload;
        if ($request->hasFile('file_upload')) {
            if ($fileName && Storage::disk('public')->exists($fileName)) {
                Storage::disk('public')->delete($fileName);
            }

            $file = $request->file('file_upload');
            $fileName = time() . '_' . Str::slug($request->nm_mhs) . '.' . $file->extension();
            $file->storeAs('publikasimahasiswa', $fileName, 'public');
            $fileName = 'publikasimahasiswa/' . $fileName;
        }

        $publikasiMahasiswa->update([
            'nm_mhs' => $request->nm_mhs,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'fakultas' => $request->fakultas,
            'tahun' => $request->tahun,
            'judul_karya' => $request->judul_karya,
            'kegiatan' => $request->kegiatan,
            // ✅ DIPERBAIKI: Konsisten menggunakan jenis_publikasi
            'jenis_publikasi' => $request->jenis_publikasi,
            'tanggal_perolehan' => $request->tanggal_perolehan,
            'file_upload' => $fileName
        ]);

        return redirect()->route('publikasi-mahasiswa-fti')->with('success', 'Data karya mahasiswa berhasil diupdate!');
    }

    public function destroy(PublikasiMahasiswa $publikasiMahasiswa)
    {
        try {
            if ($publikasiMahasiswa->file_upload && Storage::disk('public')->exists($publikasiMahasiswa->file_upload)) {
                Storage::disk('public')->delete($publikasiMahasiswa->file_upload);
            }

            $publikasiMahasiswa->delete();

            return redirect()->route('publikasi-mahasiswa-fti')->with('success', 'Data karya publikasi mahasiswa berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('publikasi-mahasiswa-fti')->with('error', 'Terjadi kesalahan saat menghapus data!');
        }
    }

    public function exportPdf(Request $request)
    {
        $query = PublikasiMahasiswa::query();

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('jenis_publikasi')) {
            $query->where('jenis_publikasi', $request->jenis_publikasi);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nm_mhs', 'like', '%' . $request->search . '%')
                    ->orWhere('judul_karya', 'like', '%' . $request->search . '%');
            });
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('prodi.fti.karyamahasiswa.publikasimahasiswa.pdf', [
            'publikasiMahasiswa' => $data,
            'title' => 'Laporan Karya Publikasi Mahasiswa',
            'tanggal' => date('d F Y')
        ]);

        $filename = 'publikasi-mahasiswa-' . date('Y-m-d-H-i-s') . '.pdf';

        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        $query = PublikasiMahasiswa::query();

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('publikasi')) {
            $query->where('jenis_publikasi', $request->publikasi); // ✅ diperbaiki
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nm_mhs', 'like', '%' . $request->search . '%')
                    ->orWhere('judul_karya', 'like', '%' . $request->search . '%');
            });
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $filename = 'publikasi-mahasiswa-' . date('Y-m-d-H-i-s') . '.xlsx';

        return Excel::download(new PublikasiMahasiswaExport($data), $filename);
    }


    public function validateDokumen()
    {
        return view('admin/dok-pendidikan/karya-mahasiswa/validate', [
            'title' => 'Validasi Dokumen Karya Mahasiswa'
        ]);
    }
}
