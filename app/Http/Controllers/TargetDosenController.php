<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TargetDosenController extends Controller
{
    public function index()
    {
        $data = array(
            "title"         => "Target Pencapaian Pembelajaran Dosen",
            "menuTargetFakul" => "active",
        );


        return view('dosen/rekognisi/index', $data);
    }
    public function create()
    {
        $data = array(
            'title'             => 'Tambah Pencapaian Pembelajaran Dosen',
            'menuTargetFakul'     => 'active',
        );
        return view('dosen/rekognisi/create', $data);
    }
}
