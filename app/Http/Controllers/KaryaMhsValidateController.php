<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KaryaMhsValidateController extends Controller
{
    public function index()
    {
        $data = array(
            "title"         => "Karya Mahasiswa Validasi",
            "menuTargetRek" => "active",
        );
        return view('admin/dok-pendidikan/karya-mahasiswa/index', $data);
    }
    public function validateDokumen()
    {
        // Halaman detail dokumen
        return view('admin/dok-pendidikan/karya-mahasiswa/validate', [
            'title' => 'Validasi Peninjauan Kurikulum"'
        ]);
    }
}
