<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PrestasiMahasiswa;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Exports\PrestasiMahasiswaExport;

class PrestasiMhsFtiController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Prestasi Mahasiswa';

        $query = PrestasiMahasiswa::query()
            ->whereNotNull('status');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nm_mhs', 'like', "%$search%")
                    ->orWhere('nim', 'like', "%$search%")
                    ->orWhere('judul_karya', 'like', "%$search%");
            });
        }

        $karya = $query->orderByDesc('created_at')->get();

        return view('prodi.fti.karyamahasiswa.prestasimahasiswa.index', [
            'title' => $title,
            'prestasiMahasiswa' => $karya,
            'jumlahPrestasiAkademik' => $karya->where('prestasi', 'prestasi-akademik')->count(),
            'jumlahPrestasiNon' => $karya->where('prestasi', 'prestasi-non-akademik')->count(),
        ]);
    }

    public function create()
    {
        return view('prodi.fti.karyamahasiswa.prestasimahasiswa.create', [
            'title' => 'Tambah Prestasi Mahasiswa'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_mhs' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:20'],
            'prodi' => ['required', 'string', 'max:100'],
            'fakultas' => ['required', 'string', 'max:100'],
            'tahun' => ['required', 'string', 'max:20'],
            'judul_karya' => ['required', 'string', 'max:500'],
            'tingkat' => ['required', 'in:local-wilayah,nasional,internasional'],
            'prestasi' => ['required', 'in:prestasi-akademik,prestasi-non-akademik'],
            'tanggal_perolehan' => ['required', 'date'],
            'file_upload' => ['required', 'file', 'mimes:pdf,docx,jpg,jpeg,png', 'max:2048'],
        ]);

        $fileName = null;
        if ($request->hasFile('file_upload')) {
            try {
                $file = $request->file('file_upload');
                $fileName = time() . '_' . Str::slug($request->nm_mhs) . '.' . $file->guessExtension();
                $file->storeAs('prestasimahasiswa', $fileName, 'public');
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal mengunggah file.');
            }
        }

        PrestasiMahasiswa::create([
            'nm_mhs' => $request->nm_mhs,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'fakultas' => $request->fakultas,
            'tahun' => $request->tahun,
            'judul_karya' => $request->judul_karya,
            'tingkat' => $request->tingkat,
            'prestasi' => $request->prestasi,
            'tanggal_perolehan' => $request->tanggal_perolehan,
            'file_upload' => $fileName ? 'prestasimahasiswa/' . $fileName : null
        ]);

        return redirect()->route('prestasi-mahasiswa-fti')->with('success', 'Data karya mahasiswa berhasil ditambahkan!');
    }

    public function edit(PrestasiMahasiswa $prestasiMahasiswa)
    {
        return view('prodi.fti.karyamahasiswa.prestasimahasiswa.edit', [
            'title' => 'Edit Prestasi Mahasiswa',
            'karya' => $prestasiMahasiswa
        ]);
    }

    public function update(Request $request, PrestasiMahasiswa $prestasiMahasiswa)
    {
        $request->validate([
            'nm_mhs' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:20'],
            'prodi' => ['required', 'string', 'max:100'],
            'fakultas' => ['required', 'string', 'max:100'],
            'tahun' => ['required', 'string', 'max:20'],
            'judul_karya' => ['required', 'string', 'max:500'],
            'tingkat' => ['required', 'in:local-wilayah,nasional,internasional'],
            'prestasi' => ['required', 'in:prestasi-akademik,prestasi-non-akademik'],
            'tanggal_perolehan' => ['required', 'date'],
            'file_upload' => ['nullable', 'file', 'mimes:pdf,docx,jpg,jpeg,png', 'max:2048'],
        ]);

        $fileName = $prestasiMahasiswa->file_upload;

        if ($request->hasFile('file_upload')) {
            if ($fileName && Storage::disk('public')->exists($fileName)) {
                Storage::disk('public')->delete($fileName);
            }

            try {
                $file = $request->file('file_upload');
                $fileNameOnly = time() . '_' . Str::slug($request->nm_mhs) . '.' . $file->guessExtension();
                $file->storeAs('prestasimahasiswa', $fileNameOnly, 'public');
                $fileName = 'prestasimahasiswa/' . $fileNameOnly;
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal mengunggah file.');
            }
        }

        $prestasiMahasiswa->update([
            'nm_mhs' => $request->nm_mhs,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'fakultas' => $request->fakultas,
            'tahun' => $request->tahun,
            'judul_karya' => $request->judul_karya,
            'tingkat' => $request->tingkat,
            'prestasi' => $request->prestasi,
            'tanggal_perolehan' => $request->tanggal_perolehan,
            'file_upload' => $fileName
        ]);

        return redirect()->route('prestasi-mahasiswa-fti')->with('success', 'Data karya mahasiswa berhasil diupdate!');
    }

    public function show(PrestasiMahasiswa $prestasiMahasiswa)
    {
        return view('prestasi-mahasiswa-fti.show', [
            'title' => 'Detail Karya Mahasiswa',
            'karya' => $prestasiMahasiswa
        ]);
    }

    public function destroy(PrestasiMahasiswa $prestasiMahasiswa)
    {
        try {
            if ($prestasiMahasiswa->file_upload && Storage::disk('public')->exists($prestasiMahasiswa->file_upload)) {
                Storage::disk('public')->delete($prestasiMahasiswa->file_upload);
            }

            $prestasiMahasiswa->delete();

            return redirect()->route('prestasi-mahasiswa-fti')->with('success', 'Data karya mahasiswa berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('prestasi-mahasiswa-fti')->with('error', 'Terjadi kesalahan saat menghapus data!');
        }
    }

    public function exportPdf(Request $request)
    {
        $query = PrestasiMahasiswa::query();

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        if ($request->filled('prestasi')) {
            $query->where('prestasi', $request->prestasi);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nm_mhs', 'like', '%' . $request->search . '%')
                    ->orWhere('judul_karya', 'like', '%' . $request->search . '%');
            });
        }

        $data = $query->orderByDesc('created_at')->get();

        if (!view()->exists('prodi.fti.karyamahasiswa.prestasimahasiswa.pdf')) {
            return back()->with('error', 'View PDF tidak ditemukan.');
        }

        $pdf = Pdf::loadView('prodi.fti.karyamahasiswa.prestasimahasiswa.pdf', [
            'prestasiMahasiswa' => $data,
            'title' => 'Laporan Prestasi Mahasiswa',
            'tanggal' => now()->format('d F Y')
        ]);

        return $pdf->download('prestasi-mahasiswa-fti-' . now()->format('Y-m-d-H-i-s') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = PrestasiMahasiswa::query();

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        if ($request->filled('prestasi')) {
            $query->where('prestasi', $request->prestasi);
        }

        if ($request->filled('search')) {
            $query->where('nm_mhs', 'like', '%' . $request->search . '%')
                ->orWhere('judul_karya', 'like', '%' . $request->search . '%');
        }

        $data = $query->orderByDesc('created_at')->get();
        return Excel::download(new PrestasiMahasiswaExport($data), 'prestasi-mahasiswa-fti-' . now()->format('Y-m-d-H-i-s') . '.xlsx');
    }

    public function rekap()
    {
        $data = PrestasiMahasiswa::orderBy('tahun')->get();

        return view('prodi.fti.karyamahasiswa.prestasimahasiswa.rekap', [
            'title' => 'Rekapitulasi Prestasi Mahasiswa',
            'data' => $data
        ]);
    }

    public function totalrekap()
    {
        $rekap = PrestasiMahasiswa::selectRaw('tahun,
            SUM(CASE WHEN prestasi = "prestasi-akademik" THEN 1 ELSE 0 END) as total_akademik,
            SUM(CASE WHEN prestasi = "prestasi-non-akademik" THEN 1 ELSE 0 END) as total_non_akademik,
            SUM(CASE WHEN tingkat = "local-wilayah" THEN 1 ELSE 0 END) as tingkat_lokal,
            SUM(CASE WHEN tingkat = "nasional" THEN 1 ELSE 0 END) as tingkat_nasional,
            SUM(CASE WHEN tingkat = "internasional" THEN 1 ELSE 0 END) as tingkat_internasional,
            COUNT(*) as total')
            ->groupBy('tahun')
            ->orderBy('tahun', 'desc')
            ->get();

        return view('prodi.fti.karyamahasiswa.prestasimahasiswa.totalrekap', [
            'title' => 'Rekapitulasi Prestasi Mahasiswa',
            'rekap' => $rekap
        ]);
    }
}
