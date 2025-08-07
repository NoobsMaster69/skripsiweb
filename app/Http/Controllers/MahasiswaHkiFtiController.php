<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MahasiswaHki;
use App\Exports\MahasiswaHkiExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class MahasiswaHkiFtiController extends Controller
{
    public function index(Request $request)
    {
        $query = MahasiswaHki::query()
            ->whereNotNull('status')
            ->where('kegiatan', 'HKI')
            ->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nm_mhs', 'like', "%$search%")
                    ->orWhere('nim', 'like', "%$search%")
                    ->orWhere('judul_karya', 'like', "%$search%");
            });
        }

        $mahasiswaHki = $query->get();
        $jumlahHki = $mahasiswaHki->count();

        return view('prodi.fti.karyamahasiswa.mahasiswaHKI.index', compact(
            'mahasiswaHki',
            'jumlahHki'
        ))->with('title', 'Data Karya Mahasiswa yang mendapatkan HKI');
    }

    public function create()
    {
        return view('prodi.fti.karyamahasiswa.mahasiswaHKI.create', [
            'title' => 'Tambah Data Karya Mahasiswa yang mendapatkan HKI'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nm_mhs' => 'required|string|max:255',
            'nim' => 'required|string|max:50',
            'prodi' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'tahun' => 'required|string|max:20',
            'judul_karya' => 'required|string|max:500',
            'tanggal_perolehan' => 'required|date',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $filePath = $request->hasFile('file_upload')
            ? $request->file('file_upload')->store('uploads/hki', 'public')
            : null;

        MahasiswaHki::create([
            'nm_mhs' => $request->nm_mhs,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'fakultas' => $request->fakultas,
            'tahun' => $request->tahun,
            'judul_karya' => $request->judul_karya,
            'kegiatan' => 'HKI',
            'tanggal_perolehan' => $request->tanggal_perolehan,
            'file_upload' => $filePath,
        ]);

        return redirect()->route('mahasiswa-hki-fti')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(MahasiswaHki $mahasiswaHki)
    {
        return view('prodi.fti.karyamahasiswa.mahasiswaHKI.edit', [
            'title' => 'Edit Data Karya Mahasiswa yang mendapatkan HKI',
            'karyaMahasiswa' => $mahasiswaHki
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = MahasiswaHki::findOrFail($id);

        $request->validate([
            'nm_mhs' => 'required|string|max:255',
            'nim' => 'required|string|max:50',
            'prodi' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'tahun' => 'required|string|max:20',
            'judul_karya' => 'required|string|max:500',
            'tanggal_perolehan' => 'required|date',
            'file_upload' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        // Update file
        if ($request->hasFile('file_upload')) {
            if ($item->file_upload && Storage::exists($item->file_upload)) {
                Storage::delete($item->file_upload);
            }
            $item->file_upload = $request->file('file_upload')->store('uploads/hki', 'public');
        }

        $item->update([
            'nm_mhs' => $request->nm_mhs,
            'nim' => $request->nim,
            'prodi' => $request->prodi,
            'fakultas' => $request->fakultas,
            'tahun' => $request->tahun,
            'judul_karya' => $request->judul_karya,
            'kegiatan' => 'HKI',
            'tanggal_perolehan' => $request->tanggal_perolehan,
            'file_upload' => $item->file_upload
        ]);

        return redirect()->route('mahasiswa-hki-fti')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = MahasiswaHki::findOrFail($id);

        if ($item->file_upload && Storage::exists($item->file_upload)) {
            Storage::delete($item->file_upload);
        }

        $item->delete();

        return redirect()->route('mahasiswa-hki-fti')->with('success', 'Data berhasil dihapus.');
    }

    public function exportExcel(Request $request)
    {
        $query = MahasiswaHki::where('kegiatan', 'HKI');

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nm_mhs', 'like', '%' . $request->search . '%')
                    ->orWhere('judul_karya', 'like', '%' . $request->search . '%');
            });
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        $filename = 'mahasiswa-hki-fti-' . now()->format('Y-m-d-H-i-s') . '.xlsx';

        return Excel::download(new MahasiswaHkiExport($data), $filename);
    }

    public function exportPdf(Request $request)
    {
        $query = MahasiswaHki::where('kegiatan', 'HKI');

        if ($request->filled('tahun')) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('judul_karya', 'like', '%' . $request->search . '%')
                    ->orWhere('nm_mhs', 'like', '%' . $request->search . '%');
            });
        }

        $karya = $query->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadView('prodi.fti.karyamahasiswa.mahasiswaHki.pdf', [
            'title' => 'Data Karya Mahasiswa - HKI',
            'tanggal' => now()->translatedFormat('d F Y'),
            'mahasiswaHki' => $karya,
        ])->setPaper('A4', 'landscape');

        return $pdf->download('dataMahasiswa_hki.pdf');
    }
}
