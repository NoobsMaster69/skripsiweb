<?php

namespace App\Http\Controllers;

use App\Models\DokRek;
use Illuminate\Http\Request;

class DosenDokRekController extends Controller
{
    public function index()
    {
        $dokumens = DokRek::all();
        $title = 'Data Dokumen Kebijakan Rektorat';
        return view('dosen.viewDokkebijakan.index', compact('dokumens', 'title'));
    }
}
