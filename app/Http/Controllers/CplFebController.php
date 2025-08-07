<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CplFebController extends Controller
{
    public function index () {
        $data = array(
            "title"         => "Profil Lulusan LAMEMBA",
            "menuProdiCpl"  => "active",
        );


        return view('prodi/feb/index', $data);
    }
     public function create()
    {
        $data = array(
            'title'         => 'Tambah Data Profil Lulusan LAMEMBA',
            'menuProdiCpl'  => 'active',
        );
        return view('prodi/feb/create', $data);
    }
}
