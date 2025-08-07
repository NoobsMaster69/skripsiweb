<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RataMTController extends Controller
{
    public function index () {
        $data = array(
            "title"         => "Rata-Rata Masa Tunggu",
            "menuProdiCpl"  => "active",
        );
        return view('prodi/fti/rata-masa-tunggu/index', $data);
    }

    public function create()
    {
        $data = [
            'title'          => 'Tambah Data Rata-Rata Masa Tunggu',
            'menupencapaian' => 'active',
        ];
        return view('prodi/fti/rata-masa-tunggu/create', $data);
    }
}
