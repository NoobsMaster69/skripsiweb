<?php

namespace App\Http\Controllers;

use App\Models\MasterDokumenBuku;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class MasterDokumentBukuRektoratController extends Controller
{
    public function indexProdi()
    {
        $dokumens = MasterDokumenBuku::orderBy('nomor', 'asc')->get();

        // Hitung total dokumen
        $total = $dokumens->count();

        // Hitung berdasarkan ekstensi
        $pdf = $dokumens->filter(function ($dok) {
            return Str::endsWith(strtolower($dok->file_path), '.pdf');
        })->count();

        $word = $dokumens->filter(function ($dok) {
            return Str::endsWith(strtolower($dok->file_path), ['.doc', '.docx']);
        })->count();

        // Ambil dokumen terbaru (berdasarkan created_at)
        $terbaru = $dokumens->sortByDesc('created_at')->first();

        return view('prodi.fti.masterdokumenbuku.index', [
            'title' => 'Dokumen Buku Kurikulum (Prodi)',
            'dokumens' => $dokumens,
            'total' => $total,
            'pdf' => $pdf,
            'word' => $word,
            'terbaru' => $terbaru,
        ]);
    }
    public function downloadFile($id)
    {
        $item = MasterDokumenBuku::findOrFail($id);

        // Pastikan file_path menyimpan path relatif dari storage atau public
        $filePath = public_path($item->file_path);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return redirect()->back()->with('error', 'File tidak ditemukan.');
        }
    }
}
