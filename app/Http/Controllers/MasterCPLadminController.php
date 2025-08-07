<?php

namespace App\Http\Controllers;

use App\Models\MasterCpl;
use Illuminate\Http\Request;
use App\Exports\CplBpmExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class MasterCPLadminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Master CPLPemenuhan capaian Pembelajaran';

        // Query dasar
        $query = MasterCpl::query();

        // Filter berdasarkan tahun akademik
        if ($request->filled('tahun_akademik')) {
            $query->where('tahun_akademik', $request->tahun_akademik);
        }

        // Filter berdasarkan program studi
        if ($request->filled('program_studi')) {
            $query->where('program_studi', $request->program_studi);
        }

        // Filter berdasarkan target minimum
        if ($request->filled('target_min')) {
            $query->where('target_pencapaian', '>=', $request->target_min);
        }

        // Filter berdasarkan pencarian mata kuliah
        if ($request->filled('search')) {
            $query->where('mata_kuliah', 'like', '%' . $request->search . '%');
        }

        // Ambil data dengan filter
        $targets = $query->latest()->get();

        // Data untuk dropdown filter
        $tahunAkademik = MasterCpl::distinct('tahun_akademik')->pluck('tahun_akademik')->sort();
        $programStudi = MasterCpl::distinct('program_studi')->pluck('program_studi')->sort();

        return view('admin.mastercpl.index', compact('title', 'targets', 'tahunAkademik', 'programStudi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Target Master CPL';
        return view('admin.mastercpl.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tahun_akademik' => 'required|digits:4',
            'program_studi' => 'required|string|max:255',
            'mata_kuliah' => 'required|string|max:255',
            'target_pencapaian' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'tahun_akademik.required' => 'Tahun akademik wajib diisi.',
            'tahun_akademik.digits' => 'Tahun akademik harus terdiri dari 4 digit angka (contoh: 2024).',
            'program_studi.required' => 'Program studi wajib diisi.',
            'mata_kuliah.required' => 'Mata kuliah wajib diisi.',
            'target_pencapaian.required' => 'Target pencapaian wajib diisi.',
            'target_pencapaian.numeric' => 'Target pencapaian harus berupa angka.',
            'target_pencapaian.min' => 'Target pencapaian minimal 0%.',
            'target_pencapaian.max' => 'Target pencapaian maksimal 100%.',
            'keterangan.max' => 'Keterangan maksimal 500 karakter.',
        ]);

        // Simpan data ke database
        MasterCpl::create([
            'tahun_akademik' => $request->tahun_akademik,
            'program_studi' => $request->program_studi,
            'mata_kuliah' => $request->mata_kuliah,
            'target_pencapaian' => $request->target_pencapaian,
            'keterangan' => $request->keterangan,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('master-cpl')->with('success', 'Data target berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterCpl $masterCpl)
    {
        $title = 'Edit Master CPL Admin';
        return view('admin.mastercpl.edit', compact('title', 'masterCpl'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterCpl $masterCpl)
    {
        // Validasi input
        $request->validate([
            'tahun_akademik' => 'required|digits:4',
            'program_studi' => 'required|string|max:255',
            'mata_kuliah' => 'required|string|max:255',
            'target_pencapaian' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'tahun_akademik.required' => 'Tahun akademik wajib diisi.',
            'tahun_akademik.digits' => 'Tahun akademik harus terdiri dari 4 digit angka (contoh: 2024).',
            'program_studi.required' => 'Program studi wajib diisi.',
            'mata_kuliah.required' => 'Mata kuliah wajib diisi.',
            'target_pencapaian.required' => 'Target pencapaian wajib diisi.',
            'target_pencapaian.numeric' => 'Target pencapaian harus berupa angka.',
            'target_pencapaian.min' => 'Target pencapaian minimal 0%.',
            'target_pencapaian.max' => 'Target pencapaian maksimal 100%.',
            'keterangan.max' => 'Keterangan maksimal 500 karakter.',
        ]);

        // Update data di database
        $masterCpl->update([
            'tahun_akademik' => $request->tahun_akademik,
            'program_studi' => $request->program_studi,
            'mata_kuliah' => $request->mata_kuliah,
            'target_pencapaian' => $request->target_pencapaian,
            'keterangan' => $request->keterangan,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('master-cpl')->with('success', 'Data target berhasil diperbarui!');
    }

    /**
     * Export data to Excel
     */
    public function exportExcel()
    {
        try {
            return Excel::download(new CplBpmExport, 'master_cpl_' . date('Y-m-d_H-i-s') . '.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengexport data Excel: ' . $e->getMessage());
        }
    }

    /**
     * Export data to PDF
     */
    public function exportPdf()
    {
        try {
            $targets = MasterCpl::all();

            $pdf = Pdf::loadView('admin.mastercpl.pdf', compact('targets'));

            return $pdf->download('master_cpl_' . date('Y-m-d_H-i-s') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengexport data PDF: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterCpl $masterCpl)
    {
        try {
            $masterCpl->delete();
            return redirect()->route('master-cpl')->with('success', 'Data berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting master-cpl: ' . $e->getMessage());
            return redirect()->route('master-cpl')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
