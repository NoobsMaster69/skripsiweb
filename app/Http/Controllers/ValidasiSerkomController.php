<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SertifkompMahasiswa;

class ValidasiSerkomController extends Controller
{
    public function index()
    {
        $data = array(
            "title"         => "Validasi Karya Sertifikasi Kompetensi Mahasiswa",
            "menuProdiCpl"  => "active",
            "sertifikasiKomp" => SertifkompMahasiswa::orderByRaw("FIELD(status, 'menunggu') DESC")
                ->orderBy('created_at', 'desc')
                ->get()

        );


        return view('admin.validasiKarya.serkom.index', $data);
    }


    public function validateDokumen($id)
    {
        $sertifikasiKomp = SertifkompMahasiswa::findOrFail($id);

        // dd($prestasiMahasiswa);
        // Halaman detail dokumen
        return view('admin.validasiKarya.serkom.validate', [
            'title' => '"Validasi Karya Sertifikasi Kompetensi Mahasiswa"',
            'sertifikasiKomp' => $sertifikasiKomp
        ]);
    }

    public function validasiSerkom(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => 'required',
        ]);

        $sertifikasiKomp = SertifkompMahasiswa::findOrFail($id);
        $sertifikasiKomp->status = $request->type_verifikasi;
        $sertifikasiKomp->deskripsi = $request->deskripsi;
        $sertifikasiKomp->save();

        return redirect()->route('valid-serkom')
            ->with('success', 'Status karya berhasil diperbarui.');
    }
}
