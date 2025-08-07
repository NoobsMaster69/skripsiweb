<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CplFtiController extends Controller
{
    public function index()
    {
        $data = array(
            "title"       => "Capaian Prodi",
            "menuCplFti"  => "active",
        );
        return view('prodi/fti/cpl-fti/index', $data);
    }


    public function create()
    {
        $data = array(
            'title'       => 'Tambah Data Capaian Prodi',
            'menuCplFti'  => 'active',
        );
        return view('prodi/fti/cpl-fti/create', $data);
    }


    public function view()
    {
        $data = array(
            "title"       => "CPL Aspek Sikap",
            "menuCplFti"  => "active",
        );
        return view('prodi/fti/cpl-fti/sikap/viewSikap', $data);
    }


    public function createSikap()
    {
        $data = [
            'title'      => 'Tambah Data CPL Aspek Sikap',
            'menuCplFti' => 'active',
        ];
        return view('prodi.fti.cpl-fti/sikap.createSikap', $data);
    }


    public function viewKU()
    {
        $data = array(
            "title"       => "CPL Aspek Keterampilan Umum",
            "menuCplFti"  => "active",
        );
        return view('prodi/fti/cpl-fti/keterampilanUmum/viewKU', $data);
    }


    public function createKu()
    {
        $data = [
            'title'      => 'Tambah Data CPL Aspek Keterampilan Umum',
            'menuCplFti' => 'active',
        ];
        return view('prodi.fti.cpl-fti/keterampilanUmum.createKu', $data);
    }


    public function viewKK()
    {
        $data = array(
            "title"       => "CPL Aspek Keterampilan Khusus",
            "menuCplFti"  => "active",
        );
        return view('prodi/fti/cpl-fti/keterampilanKhusus/viewKK', $data);
    }

     public function createKk()
    {
        $data = [
            'title'      => 'Tambah Data CPL Aspek Keterampilan Khusus',
            'menuCplFti' => 'active',
        ];
        return view('prodi.fti.cpl-fti/keterampilanKhusus.createKk', $data);
    }


    public function viewPe()
    {
        $data = array(
            "title"       => "CPL Aspek Pengetahuan",
            "menuCplFti"  => "active",
        );
        return view('prodi/fti/cpl-fti/pengetahuan/viewPengetahuan', $data);
    }

    public function createPe()
    {
        $data = [
            'title'      => 'Tambah Data CPL Aspek Pengetahuan',
            'menuCplFti' => 'active',
        ];
        return view('prodi.fti.cpl-fti/pengetahuan.createPe', $data);
    }


}
