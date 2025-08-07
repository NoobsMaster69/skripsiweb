<?php

namespace App\Http\Controllers;

use App\Models\MahasiswaHki;
use Illuminate\Http\Request;

class ValidasiMhsHkiController extends Controller
{

    public function index()
    {
        $data = array(
            "title"         => "Validasi Data Karya Mahasiswa mendapatkan HKI",
            "menuProdiCpl"  => "active",
            "mahasiswaHki" => MahasiswaHki::orderBy('created_at', 'desc')->get()
        );


        return view('admin.validasiKarya.karyaHKI.index', $data);
    }


    public function validateDokumen($id)
    {
        $mahasiswaHki = MahasiswaHki::findOrFail($id);

        // dd($prestasiMahasiswa);
        // Halaman detail dokumen
        return view('admin.validasiKarya.karyaHKI.validate', [
            'title' => '"Validasi Data Karya Mahasiswa mendapatkan HKI"',
            'mahasiswaHki' => $mahasiswaHki
        ]);
    }

    public function validasiHKI(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => 'required',
        ]);

        $mahasiswaHki = MahasiswaHki::findOrFail($id);
        $mahasiswaHki->status = $request->type_verifikasi;
        $mahasiswaHki->deskripsi = $request->deskripsi;
        $mahasiswaHki->save();

        return redirect()->route('valid-mhsHki')
            ->with('success', 'Status karya berhasil diperbarui.');
    }


}
