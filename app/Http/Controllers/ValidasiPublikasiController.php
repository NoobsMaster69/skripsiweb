<?php

namespace App\Http\Controllers;

use App\Models\PublikasiMahasiswa;
use Illuminate\Http\Request;

class ValidasiPublikasiController extends Controller
{

    public function index()
    {
        $data = array(
            "title" => "Validasi Publikasi Mahasiswa",
            "menuProdiCpl" => "active",
            "publikasiMahasiswa" => PublikasiMahasiswa::orderByRaw("FIELD(status, 'menunggu', 'revisi', 'terverifikasi') ASC")
                ->orderBy('created_at', 'desc')
                ->get()
        );

        return view('admin.validasiKarya.publikasi.index', $data);
    }



    public function validateDokumen($id)
    {
        $publikasiMahasiswa = PublikasiMahasiswa::findOrFail($id);

        // dd($prestasiMahasiswa);
        // Halaman detail dokumen
        return view('admin.validasiKarya.publikasi.validate', [
            'title' => 'Validasi Publikasi Mahasiswa"',
            'publikasiMahasiswa' => $publikasiMahasiswa
        ]);
    }

    public function validasiPublikasi(Request $request, $id)
    {

        $request->validate([
            'deskripsi' => 'required',
        ]);


        $publikasiMahasiswa = PublikasiMahasiswa::findOrFail($id);
        $publikasiMahasiswa->status = $request->type_verifikasi;
        $publikasiMahasiswa->deskripsi = $request->deskripsi;
        $publikasiMahasiswa->save();

        return redirect()->route('valid-publikasi')
            ->with('success', 'Status karya berhasil diperbarui.');
    }
}
