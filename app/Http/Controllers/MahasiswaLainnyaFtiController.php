<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\MahasiswaLainnya;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\mahasiswaLainnyaExport;
use Illuminate\Support\Facades\Storage;

class MahasiswaLainnyaFtiController extends Controller
{
    public function index(Request $request)
    {
        $query = MahasiswaLainnya::query()
            ->whereNotNull('status')
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nm_mhs', 'like', '%' . $request->search . '%')
                    ->orWhere('nim', 'like', '%' . $request->search . '%')
                    ->orWhere('judul_karya', 'like', '%' . $request->search . '%');
            });
        }

        $karya = $query->get();
        $jumlahProduk = MahasiswaLainnya::where('kegiatan', 'Produk')->count();
        $jumlahJasa = MahasiswaLainnya::where('kegiatan', 'Jasa')->count();

        $data = [
            'title' => 'Karya Mahasiswa Lainnya',
            'mahasiswaLainnya' => $karya,
            // ✅ DIPERBAIKI: Menghitung berdasarkan jenis_publikasi, bukan kegiatan
            'jumlahProduk' => $jumlahProduk,
            'jumlahJasa' => $jumlahJasa,
        ];

        return view('prodi.fti.karyamahasiswa.karyalainnya.index', $data);
    }

    public function create()
    {
        return view('prodi.fti.karyamahasiswa.karyalainnya.create', [
            'title' => 'Tambah Karya Mahasiswa Lainnya'
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
            'kegiatan' => 'required|in:Produk,Jasa',
            'tanggal_perolehan' => 'required|date',
            'file_upload' => 'required|file|mimes:pdf,docx,jpg,jpeg|max:2048'
        ]);

        $fileName = null;
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $fileName = time() . '_' . Str::slug($request->nm_mhs) . '.' . $file->extension();
            $file->storeAs('mahasiswalainnya', $fileName, 'public');
        }

        MahasiswaLainnya::create([
            'nm_mhs' => $request->nm_mhs,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'fakultas' => $request->fakultas,
            'tahun' => $request->tahun,
            'judul_karya' => $request->judul_karya,
            'kegiatan' => $request->kegiatan,
            'tanggal_perolehan' => $request->tanggal_perolehan,
            'file_upload' => $fileName ? 'mahasiswalainnya/' . $fileName : null
        ]);

        return redirect()->route('mahasiswa-lainnya-fti')->with('success', 'Data karya mahasiswa lainnya berhasil ditambahkan!');
    }

    public function show(MahasiswaLainnya $mahasiswaLainnya)
    {
        return view('mahasiswa-lainnya-fti.show', [
            'title' => 'Detail Mahasiswa Lainnya',
            'karya' => $mahasiswaLainnya
        ]);
    }

    public function edit(MahasiswaLainnya $mahasiswaLainnya)
    {
        return view('prodi.fti.karyamahasiswa.karyalainnya.edit', [
            'title' => 'Edit Karya Mahasiswa Lainnya',
            'karya' => $mahasiswaLainnya // <== penting!
        ]);
    }


    public function update(Request $request, MahasiswaLainnya $mahasiswaLainnya)
    {
        $request->validate([
            'nm_mhs' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'prodi' => 'required|string|max:255',
            'fakultas' => 'required|string|max:255',
            'tahun' => 'required|string|max:20',
            'judul_karya' => 'required|string|max:500',
            'kegiatan' => 'required|in:Produk,Jasa',
            'tanggal_perolehan' => 'required|date_format:Y-m-d',
            'file_upload' => 'nullable|file|mimes:pdf,docx,jpg,jpeg|max:2048'
        ]);

        $fileName = $mahasiswaLainnya->file_upload;
        if ($request->hasFile('file_upload')) {
            if ($fileName && Storage::disk('public')->exists($fileName)) {
                Storage::disk('public')->delete($fileName);
            }

            $file = $request->file('file_upload');
            $fileName = time() . '_' . Str::slug($request->nm_mhs) . '.' . $file->extension();
            $file->storeAs('mahasiswalainnya', $fileName, 'public');
            $fileName = 'mahasiswalainnya/' . $fileName;
        }

        $mahasiswaLainnya->update([
            'nm_mhs' => $request->nm_mhs,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'fakultas' => $request->fakultas,
            'tahun' => $request->tahun,
            'judul_karya' => $request->judul_karya,
            'kegiatan' => $request->kegiatan,
            'tanggal_perolehan' => $request->tanggal_perolehan,
            'file_upload' => $fileName
        ]);

        return redirect()->route('mahasiswa-lainnya-fti')->with('success', 'Data karya mahasiswa Lainnya berhasil diupdate!');
    }

    public function destroy(MahasiswaLainnya $mahasiswalainnya)
    {
        try {
            if ($mahasiswalainnya->file_upload && Storage::disk('public')->exists($mahasiswalainnya->file_upload)) {
                Storage::disk('public')->delete($mahasiswalainnya->file_upload);
            }

            $mahasiswalainnya->delete();

            return redirect()->route('mahasiswa-lainnya-fti')->with('success', 'Data karya mahasiswa lainnya berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('mahasiswa-lainnya-fti')->with('error', 'Terjadi kesalahan saat menghapus data!');
        }
    }


    public function exportPdf(Request $request)
    {
        $query = MahasiswaLainnya::query();

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('publikasi')) {
            $query->where('jenis_publikasi', $request->jenis_publikasi);
        }

        if ($request->filled('search')) {
            $query->where('nm_mhs', 'like', '%' . $request->search . '%')
                ->orWhere('judul_karya', 'like', '%' . $request->search . '%');
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('prodi.fti.karyamahasiswa.karyalainnya.pdf', [
            'mahasiswalainnya' => $data,
            'title' => 'Laporan Karya Mahasiswa Lainnya',
            'tanggal' => date('d F Y')
        ]);

        $filename = 'karyamahasiswa-Lainnya-fti-' . date('Y-m-d-H-i-s') . '.pdf';

        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        $query = MahasiswaLainnya::query();

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('publikasi')) {
            $query->where('jenis_publikasi', $request->jenis_publikasi);
        }

        if ($request->filled('search')) {
            $query->where('nm_mhs', 'like', '%' . $request->search . '%')
                ->orWhere('judul_karya', 'like', '%' . $request->search . '%');
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $filename = 'karyamahasiswa-lainnya-fti-' . date('Y-m-d-H-i-s') . '.xlsx';

        return Excel::download(new mahasiswaLainnyaExport($data), $filename);
    }

    public function validateDokumen()
    {
        return view('admin/dok-pendidikan/karya-mahasiswa/validate', [
            'title' => 'Validasi Dokumen Karya Mahasiswa'
        ]);
    }
}
