<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterDokumenPeninjauanController extends Controller
{
    public function index()
    {
        $data = array(
            "title"         => "Master Dokumen peninjauan Kurikulum",
            "menuTargetRek" => "active",
        );
        return view('admin/masterdokumenpeninjauan/index', $data);
    }
    public function create()
    {
        $data = array(
            'title'             => 'Tambah Master Dokumen peninjauan Kurikulum',
            'menuTargetRek'     => 'active',
        );
        return view('admin/masterdokumenpeninjauan/create', $data);
    }
}
