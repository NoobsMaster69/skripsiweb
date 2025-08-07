<?php

namespace App\Http\Controllers;

use Log;
use App\Models\TargetFakul;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\TargetFakulExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TargetFakulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $title = 'Target Pemenuhan capaian Pembelajaran Fakultas';

    // Query dasar
    $query = TargetFakul::query();

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
    $tahunAkademik = TargetFakul::distinct('tahun_akademik')->pluck('tahun_akademik')->sort();
    $programStudi = TargetFakul::distinct('program_studi')->pluck('program_studi')->sort();

    return view('fakultas.pendidikan.pencapaian.index', compact('title', 'targets', 'tahunAkademik', 'programStudi'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Target Fakultas';
        return view('fakultas.pendidikan.pencapaian.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tahun_akademik' => 'required|string|max:255|regex:/^\d{4}\/\d{4}$/',
            'program_studi' => 'required|string|max:255',
            'mata_kuliah' => 'required|string|max:255',
            'target_pencapaian' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'tahun_akademik.required' => 'Tahun akademik wajib diisi.',
            'tahun_akademik.regex' => 'Format tahun akademik harus YYYY/YYYY (contoh: 2024/2025).',
            'program_studi.required' => 'Program studi wajib diisi.',
            'mata_kuliah.required' => 'Mata kuliah wajib diisi.',
            'target_pencapaian.required' => 'Target pencapaian wajib diisi.',
            'target_pencapaian.numeric' => 'Target pencapaian harus berupa angka.',
            'target_pencapaian.min' => 'Target pencapaian minimal 0%.',
            'target_pencapaian.max' => 'Target pencapaian maksimal 100%.',
            'keterangan.max' => 'Keterangan maksimal 500 karakter.',
        ]);

        // Simpan data ke database
        TargetFakul::create([
            'tahun_akademik' => $request->tahun_akademik,
            'program_studi' => $request->program_studi,
            'mata_kuliah' => $request->mata_kuliah,
            'target_pencapaian' => $request->target_pencapaian,
            'keterangan' => $request->keterangan,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('target-fakul')->with('success', 'Data target berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TargetFakul $targetFakul)
    {
        $title = 'Edit Target Rektorat';
        return view('fakultas.pendidikan.pencapaian.edit', compact('title', 'targetFakul'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TargetFakul $targetFakul)
    {
        // Validasi input
        $request->validate([
            'tahun_akademik' => 'required|string|max:255|regex:/^\d{4}\/\d{4}$/',
            'program_studi' => 'required|string|max:255',
            'mata_kuliah' => 'required|string|max:255',
            'target_pencapaian' => 'required|numeric|min:0|max:100',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'tahun_akademik.required' => 'Tahun akademik wajib diisi.',
            'tahun_akademik.regex' => 'Format tahun akademik harus YYYY/YYYY (contoh: 2024/2025).',
            'program_studi.required' => 'Program studi wajib diisi.',
            'mata_kuliah.required' => 'Mata kuliah wajib diisi.',
            'target_pencapaian.required' => 'Target pencapaian wajib diisi.',
            'target_pencapaian.numeric' => 'Target pencapaian harus berupa angka.',
            'target_pencapaian.min' => 'Target pencapaian minimal 0%.',
            'target_pencapaian.max' => 'Target pencapaian maksimal 100%.',
            'keterangan.max' => 'Keterangan maksimal 500 karakter.',
        ]);

        // Update data di database
        $targetFakul->update([
            'tahun_akademik' => $request->tahun_akademik,
            'program_studi' => $request->program_studi,
            'mata_kuliah' => $request->mata_kuliah,
            'target_pencapaian' => $request->target_pencapaian,
            'keterangan' => $request->keterangan,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('target-fakul')->with('success', 'Data target berhasil diperbarui!');
    }

    /**
     * Export data to Excel
     */
    public function exportExcel()
    {
        try {
            return Excel::download(new TargetFakulExport, 'target_fakultas_' . date('Y-m-d_H-i-s') . '.xlsx');
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
            $targets = TargetFakul::all();

            $pdf = Pdf::loadView('rektorat.pendidikan.pdf', compact('targets'));

            return $pdf->download('target_rektorat_' . date('Y-m-d_H-i-s') . '.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengexport data PDF: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TargetFakul $targetFakul)
{
    try {
        $targetFakul->delete();
        return redirect()->route('target-fakul.index')->with('success', 'Data berhasil dihapus!');
    } catch (\Exception $e) {
        Log::error('Error deleting target-fakul: ' . $e->getMessage());
        return redirect()->route('target-fakul.index')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
    }
}
}

