<?php

namespace App\Http\Controllers;

use App\Models\MasterDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MasterDokumenRektoratController extends Controller
{
    public function index()
    {
        $dokumens = MasterDokumen::orderBy('created_at', 'desc')->get();

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

        return view('rektorat.masterdokumen.index', [
            'title' => 'Master Dokumen Rektorat',
            'dokumens' => $dokumens,
            'total' => $total,
            'pdf' => $pdf,
            'word' => $word,
            'terbaru' => $terbaru,
        ]);
    }
}
