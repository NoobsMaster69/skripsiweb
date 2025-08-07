<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterDokumentBukuController extends Controller
{
    public function index()
    {
        $data = array(
            "title"         => "Master Dokumen Buku Kurikulum",
            "menuTargetRek" => "active",
        );
        return view('admin/masterdokumenbuku/index', $data);
    }
    public function create()
    {
        $data = array(
            'title'             => 'Tambah Master Dokumen Buku Kurikulum',
            'menuTargetRek'     => 'active',
        );
        return view('admin/masterdokumenbuku/create', $data);
    }
}
