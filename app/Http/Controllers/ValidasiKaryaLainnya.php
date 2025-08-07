<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaLainnya;
use Illuminate\Http\Request;

class ValidasiKaryaLainnya extends Controller
{
    public function index()
    {
        $data = array(
            "title"         => "Validasi Karya Mahasiswa Lainnya",
            "menuProdiCpl"  => "active",
            "MahasiswaLainnya" => MahasiswaLainnya::orderBy('created_at', 'desc')->get()

        );


        return view('admin.validasiKarya.karyalainnya.index', $data);
    }


    public function validateDokumen($id)
    {
        $MahasiswaLainnya = MahasiswaLainnya::findOrFail($id);

        // dd($prestasiMahasiswa);
        // Halaman detail dokumen
        return view('admin.validasiKarya.karyalainnya.validate', [
            'title' => 'Validasi Karya Mahasiswa Lainnya"',
            'MahasiswaLainnya' => $MahasiswaLainnya
        ]);
    }

    public function validasiKaryalainnya(Request $request, $id)
    {

        $request->validate([
            'deskripsi' => 'required',
        ]);


        $MahasiswaLainnya = MahasiswaLainnya::findOrFail($id);
        $MahasiswaLainnya->status = $request->type_verifikasi;
        $MahasiswaLainnya->deskripsi = $request->deskripsi;
        $MahasiswaLainnya->save();

        return redirect()->route('valid-karyalainnya')
            ->with('success', 'Status karya berhasil diperbarui.');
    }
}

