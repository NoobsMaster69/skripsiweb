<?php

namespace App\Http\Controllers;

use App\Models\DokRek;
use Illuminate\Http\Request;

class FakultasDokRekController extends Controller
{
    public function index()
    {
        $dokumens = DokRek::all();
        $title = 'Data Dokumen Kebijakan';
        return view('fakultas.viewDokkebijakan.index', compact('dokumens', 'title'));
    }
}
