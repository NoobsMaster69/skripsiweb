<?php

namespace App\Http\Controllers;

use App\Models\DokRek;
use Illuminate\Http\Request;

class ProdiDokRekController extends Controller
{
    public function index()
    {
        $dokumens = DokRek::all();
        $title = 'Data Dokumen Kebijakan Rektorat';
        return view('prodi.fti.viewDokkebijakan.index', compact('dokumens', 'title'));
    }
}
