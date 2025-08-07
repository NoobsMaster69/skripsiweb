<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\SerkomExport;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SertifkompMahasiswa;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class SertifikasiKompFtiController extends Controller
{
    public function index(Request $request)
    {
        $query = SertifkompMahasiswa::query()
            ->whereNotNull('status')
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nm_mhs', 'like', "%$search%")
                    ->orWhere('nim', 'like', "%$search%")
                    ->orWhere('judul_karya', 'like', "%$search%");
            });
        }

        $karya = $query->get(); // <- gunakan hasil dari query yang sudah difilter

        // Dalam method index()
        $data = [
            'title' => 'Karya Sertifikasi Kompetensi Mahasiswa',
            'sertifikasiKomp' => $karya,
            // Optional: kalau ingin hitung berdasarkan tingkatan tertentu, ganti sesuai nilai tingkatan
            'jumlahInternasional' => $karya->where('tingkatan', 'internasional')->count(),
            'jumlahNasional' => $karya->where('tingkatan', 'nasional')->count(),
            'jumlahLokal' => $karya->where('tingkatan', 'lokal')->count(),
        ];


        return view('prodi.fti.karyamahasiswa.sertifikasikomp.index', $data);
    }

    public function create()
    {
        return view('prodi.fti.karyamahasiswa.sertifikasikomp.create', [
            'title' => 'Tambah Karya Sertifikasi Kompetensi Mahasiswa'
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
            'tingkatan' => 'required|in:internasional,nasional,lokal',
            'tanggal_perolehan' => 'required|date',
            'file_upload' => 'required|file|mimes:pdf,docx,jpg,jpeg|max:2048'
        ]);

        $fileName = null;
        if ($request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            $fileName = time() . '_' . Str::slug($request->nm_mhs) . '.' . $file->extension();
            $file->storeAs('sertifikasiKomp', $fileName, 'public');
        }

        SertifkompMahasiswa::create([
            'nm_mhs' => $request->nm_mhs,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'fakultas' => $request->fakultas,
            'tahun' => $request->tahun,
            'judul_karya' => $request->judul_karya,
            'kegiatan' => 'Sertifikasi Kompetensi',
            'tingkatan' => $request->tingkatan,
            'tanggal_perolehan' => $request->tanggal_perolehan,
            'file_upload' => $fileName ? 'sertifikasiKomp/' . $fileName : null
        ]);

        return redirect()->route('Sertifikasi-komp-fti')->with('success', 'Data berhasil ditambahkan!');
    }


    public function show(SertifkompMahasiswa $sertifikasiKomp)
    {
        return view('Sertifikasi-komp-fti.show', [
            'title' => 'Detail karya Sertifikasi Kompetensi Mahasiswa',
            'karya' => $sertifikasiKomp
        ]);
    }

    public function edit(SertifkompMahasiswa $sertifikasiKomp)
    {
        return view('prodi.fti.karyamahasiswa.sertifikasikomp.edit', [
            'title' => 'Edit karya Sertifikasi Kompetensi Mahasiswa',
            'karya' => $sertifikasiKomp
        ]);
    }

    public function update(Request $request, SertifkompMahasiswa $sertifikasiKomp)
    {
        $request->validate([
            'nm_mhs' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'tahun' => 'required|string|max:20',
            'judul_karya' => 'required|string|max:500',
            'tingkatan' => 'required|in:internasional,nasional,lokal',
            'tanggal_perolehan' => 'required|date',
            'file_upload' => 'nullable|file|mimes:pdf,docx,jpg,jpeg|max:2048'
        ]);

        $fileName = $sertifikasiKomp->file_upload;
        if ($request->hasFile('file_upload')) {
            if ($fileName && Storage::disk('public')->exists($fileName)) {
                Storage::disk('public')->delete($fileName);
            }

            $file = $request->file('file_upload');
            $fileName = time() . '_' . Str::slug($request->nm_mhs) . '.' . $file->extension();
            $file->storeAs('sertifikasiKomp', $fileName, 'public');
            $fileName = 'sertifikasiKomp/' . $fileName;
        }

        $sertifikasiKomp->update([
            'nm_mhs' => $request->nm_mhs,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'fakultas' => $request->fakultas,
            'tahun' => $request->tahun,
            'judul_karya' => $request->judul_karya,
            'kegiatan' => 'Sertifikasi Kompetensi',
            'tingkatan' => $request->tingkatan,
            'tanggal_perolehan' => $request->tanggal_perolehan,
            'file_upload' => $fileName
        ]);

        return redirect()->route('Sertifikasi-komp')->with('success', 'Data berhasil diupdate!');
    }


    public function destroy(SertifkompMahasiswa $sertifikasiKomp)
    {
        try {
            if ($sertifikasiKomp->file_upload && Storage::disk('public')->exists($sertifikasiKomp->file_upload)) {
                Storage::disk('public')->delete($sertifikasiKomp->file_upload);
            }

            $sertifikasiKomp->delete();

            return redirect()->route('Sertifikasi-komp-fti')->with('success', 'Data karya sertifikasi kompetensi mahasiswa berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('Sertifikasi-komp-fti')->with('error', 'Terjadi kesalahan saat menghapus data!');
        }
    }



    public function exportPdf(Request $request)
    {
        $query = SertifkompMahasiswa::query();

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('tingkatan')) {
            $query->where('tingkatan', $request->tingkatan);
        }


        if ($request->filled('search')) {
            $query->where('nm_mhs', 'like', '%' . $request->search . '%')
                ->orWhere('judul_karya', 'like', '%' . $request->search . '%');
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('prodi.fti.karyamahasiswa.sertifikasikomp.pdf', [
            'sertifikasiKomp' => $data,
            'title' => 'Laporan Karya Sertifikasi Kompetensi Mahasiswa ',
            'tanggal' => date('d F Y'),
            'publikasiMahasiswa' => $data, // <--- ini penting
        ]);

        $filename = 'karya-sertifikasi-kompetensi-' . date('Y-m-d-H-i-s') . '.pdf';

        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        $query = SertifkompMahasiswa::query();

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

        $filename = 'karya-sertifikasi-kompetensi-mhs-' . date('Y-m-d-H-i-s') . '.xlsx';

        return Excel::download(new SerkomExport($data), $filename);
    }

    public function validateDokumen()
    {
        return view('admin/dok-pendidikan/karya-mahasiswa/validate', [
            'title' => 'Validasi Dokumen Karya Mahasiswa'
        ]);
    }
}
