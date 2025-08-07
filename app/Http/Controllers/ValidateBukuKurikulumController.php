<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ValidateBukuKurikulumController extends Controller
{
    public function index () {
        $data = array(
            "title"         => "Validasi Buku Kurikulum",
            "menuProdiCpl"  => "active",
        );


        return view('fakultas/pendidikan/bukukurikulumvalidasi/index', $data);
    }


    public function validBukuKurikulum()
    {
        // Halaman detail dokumen
        return view('fakultas/pendidikan/bukukurikulumvalidasi/validate', [
            'title' => 'Validasi Buku Kurikulum"'
        ]);
    }
}
