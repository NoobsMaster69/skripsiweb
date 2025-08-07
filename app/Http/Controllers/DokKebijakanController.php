<?php

namespace App\Http\Controllers;

use App\Models\DokKebijakan;
use App\Models\DokRek;
use Illuminate\Http\Request;

class DokKebijakanController extends Controller
{
    public function index()
    {
        $data = array(
            "title"         => "Validasi Dokumen Kebijakan",
            "menuProdiCpl"  => "active",
            "dokReks"       => DokRek::orderBy('created_at', 'desc')->get() // ubah ke 'dokReks'
        );

        return view('admin/dok-kebijakan/index', $data);
    }


    public function validateDokumen($id)
    {

        $DokRek = DokRek::findOrFail($id);

        // dd($prestasiMahasiswa);
        // Halaman detail dokumen
        return view('admin/dok-kebijakan/validate', [
            'title' => 'Validasi Dokumen Kebijakan"',
            'dokRek' => $DokRek
        ]);
    }

    public function validasiDok(Request $request, $id)
    {

        $request->validate([
            'deskripsi' => 'required',
        ]);


        $DokRek = DokRek::findOrFail($id);
        $DokRek->status = $request->type_verifikasi;
        $DokRek->deskripsi = $request->deskripsi;
        $DokRek->save();

        return redirect()->route('dok-kebijakan')
            ->with('success', 'Status karya berhasil diperbarui.');
    }
    public function showValidasi(DokRek $dokRek)
    {
        return view('admin/dok-kebijakan/validate', [
            'title' => 'Validasi Dokumen Kebijakan',
            'dokRek' => $dokRek
        ]);
    }
}
