<?php

namespace App\Http\Controllers;

use App\Exports\CplDosenExport;
use App\Models\CplDosen;
use App\Models\MasterCpl;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class CplDosenController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Daftar CPL Dosen';

        // Ambil data MasterCpl + CPL Dosen
        $query = MasterCpl::with('cplDosen');

        // Fitur search berdasarkan tahun, prodi, atau mata kuliah
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('tahun_akademik', 'like', "%$search%")
                    ->orWhere('program_studi', 'like', "%$search%")
                    ->orWhere('mata_kuliah', 'like', "%$search%");
            });
        }

        $targets = $query->get();

        return view('dosen.capaian-pembelajaran.index', compact('title', 'targets'));
    }


    public function create(Request $request)
    {
        $title = 'Tambah Target CPL Dosen';

        // Ambil data master berdasarkan ID yang dikirim
        $masterCpl = MasterCpl::findOrFail($request->master_cpl_id);

        return view('dosen.capaian-pembelajaran.create', compact('title', 'masterCpl'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'master_cpl_id' => 'required|exists:master_cpl,id',
            'ketercapaian' => 'required|numeric|min:0|max:100',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:2048',
            'link' => 'nullable|url|max:255',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $path = null;
        if ($request->hasFile('dokumen_pendukung')) {
            $file = $request->file('dokumen_pendukung');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('cpl_dosen_documents', $filename, 'public');
        }

        CplDosen::updateOrCreate(
            ['master_cpl_id' => $request->master_cpl_id],
            [
                'ketercapaian' => $request->ketercapaian,
                'dokumen_pendukung' => $path,
                'link' => $request->link,
                'keterangan' => $request->keterangan,
            ]
        );

        return redirect()->route('cpl-dosen')->with('success', 'Data CPL berhasil disimpan');
    }

    public function edit(CplDosen $cplDosen)
    {
        $title = 'Edit CPL Dosen';
        $cplDosen->load('masterCpl');
        return view('dosen.capaian-pembelajaran.edit', compact('title', 'cplDosen'));
    }

    public function update(Request $request, CplDosen $cplDosen)
    {
        $request->validate([
            'ketercapaian' => 'required|numeric|min:0|max:100',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:2048',
            'link' => 'nullable|url|max:500',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $dokumenPath = $cplDosen->dokumen_pendukung;

        if ($request->hasFile('dokumen_pendukung')) {
            if ($dokumenPath && Storage::disk('public')->exists($dokumenPath)) {
                Storage::disk('public')->delete($dokumenPath);
            }

            $file = $request->file('dokumen_pendukung');
            $filename = time() . '_' . $file->getClientOriginalName();
            $dokumenPath = $file->storeAs('cpl_dosen_documents', $filename, 'public');
        }

        $cplDosen->update([
            'ketercapaian' => $request->ketercapaian,
            'dokumen_pendukung' => $dokumenPath,
            'link' => $request->link,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('cpl-dosen')->with('success', 'Data CPL Dosen berhasil diperbarui!');
    }

    public function downloadDocument(CplDosen $cplDosen)
    {
        if (!$cplDosen->dokumen_pendukung || !Storage::disk('public')->exists($cplDosen->dokumen_pendukung)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        $filePath = storage_path('app/public/' . $cplDosen->dokumen_pendukung);
        return response()->download($filePath);
    }

    public function deleteDocument(CplDosen $cplDosen)
    {
        try {
            if ($cplDosen->dokumen_pendukung && Storage::disk('public')->exists($cplDosen->dokumen_pendukung)) {
                Storage::disk('public')->delete($cplDosen->dokumen_pendukung);
            }

            $cplDosen->update(['dokumen_pendukung' => null]);
            return redirect()->back()->with('success', 'Dokumen berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting document: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus dokumen: ' . $e->getMessage());
        }
    }

    public function exportExcel()
    {
        try {
            return Excel::download(new CplDosenExport, 'cpl_dosen_' . now()->format('Y-m-d_H-i-s') . '.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengexport data Excel: ' . $e->getMessage());
        }
    }

    public function exportPdf(Request $request)
    {
        $query = CplDosen::with('masterCpl');

        if ($request->filled('tahun')) {
            $query->whereHas('masterCpl', fn($q) => $q->where('tahun_akademik', $request->tahun));
        }

        if ($request->filled('program_studi')) {
            $query->whereHas('masterCpl', fn($q) => $q->where('program_studi', $request->program_studi));
        }

        if ($request->filled('mata_kuliah')) {
            $query->whereHas('masterCpl', fn($q) => $q->where('mata_kuliah', $request->mata_kuliah));
        }

        if ($request->filled('search')) {
            $query->whereHas('masterCpl', function ($q) use ($request) {
                $q->where('program_studi', 'like', '%' . $request->search . '%')
                    ->orWhere('mata_kuliah', 'like', '%' . $request->search . '%')
                    ->orWhere('keterangan', 'like', '%' . $request->search . '%');
            });
        }

        $data = $query->orderBy('created_at', 'desc')->get();

        if ($data->isEmpty()) {
            return redirect()->back()->with('warning', 'Data CPL Dosen tidak ditemukan untuk filter yang dipilih.');
        }

        $pdf = Pdf::loadView('dosen.capaian-pembelajaran.pdf', [
            'targets' => $data,
            'title' => 'Laporan Target CPL Dosen',
            'tanggal' => now()->translatedFormat('d F Y'),
        ])->setPaper('a4', 'portrait');

        return $pdf->download('laporan-cpl-dosen-' . now()->format('Y-m-d-H-i-s') . '.pdf');
    }

    public function viewDocument(CplDosen $cplDosen)
    {
        if (!$cplDosen->dokumen_pendukung || !Storage::disk('public')->exists($cplDosen->dokumen_pendukung)) {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }

        $fileUrl = asset('storage/' . $cplDosen->dokumen_pendukung);

        return view('dosen.capaian-pembelajaran.preview', [
            'fileUrl' => $fileUrl,
            'title' => 'Pratinjau Dokumen'
        ]);
    }


    public function destroy($id)
    {
        try {
            $cplDosen = CplDosen::findOrFail($id);

            if ($cplDosen->dokumen_pendukung && Storage::disk('public')->exists($cplDosen->dokumen_pendukung)) {
                Storage::disk('public')->delete($cplDosen->dokumen_pendukung);
            }

            $cplDosen->delete();

            return redirect()->route('cpl-dosen')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting cpl-dosen: ' . $e->getMessage());
            return redirect()->route('cpl-dosen')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
