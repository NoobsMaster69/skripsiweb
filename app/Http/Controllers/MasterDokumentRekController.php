<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterDokumentRekController extends Controller
{
    public function index()
    {
        $data = array(
            "title"         => "Master Dokumen Kebijakan",
            "menuTargetRek" => "active",
        );
        return view('rektorat/masterdokumen/index', $data);
    }
}
