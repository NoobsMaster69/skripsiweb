<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KesesuaianBidangController extends Controller
{
    public function index () {
        $data = array(
            "title"         => "Kesesuaian Bidang Kerja",
            "menuKesesuaian"  => "active",
        );
        return view('prodi/fti/kesesuaian-bidang-kerja/index', $data);
    }

    public function create()
    {
        $data = [
            'title'          => 'Tambah Data Kesesuaian Bidang Kerja',
            'menuKesesuaian' => 'active',
        ];
        return view('prodi/fti/kesesuaian-bidang-kerja/create', $data);
    }
}
