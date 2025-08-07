<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidatePeninjauanKurikulumController extends Controller
{
    public function index () {
        $data = array(
            "title"         => "Validasi Peninjauan Kurikulum",
            "menuProdiCpl"  => "active",
        );


        return view('fakultas/pendidikan/peninjauanvalidasi/index', $data);
    }


    public function validateDokumen()
    {
        // Halaman detail dokumen
        return view('fakultas/pendidikan/peninjauanvalidasi/validate', [
            'title' => 'Validasi Peninjauan Kurikulum"'
        ]);
    }
}
