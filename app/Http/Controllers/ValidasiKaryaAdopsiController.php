<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MahasiswaDiadop;

class ValidasiKaryaAdopsiController extends Controller
{
    public function index()
    {
        $data = array(
            "title"         => "Validasi Karya Mahasiswa yang diadopsi oleh Masyarakat",
            "menuProdiCpl"  => "active",
            "MahasiswaDiadop" => MahasiswaDiadop::orderByRaw("FIELD(status, 'menunggu', 'revisi', 'terverifikasi') ASC")
                ->orderBy('created_at', 'desc')
                ->get()
        );

        return view('admin.validasiKarya.karyamasyarakat.index', $data);
    }



    public function validateDokumen($id)
    {
        $MahasiswaDiadop = MahasiswaDiadop::findOrFail($id);

        // dd($prestasiMahasiswa);
        // Halaman detail dokumen
        return view('admin.validasiKarya.karyamasyarakat.validate', [
            'title' => 'Validasi Karya Mahasiswa yang diadopsi oleh Masyarakat"',
            'MahasiswaDiadop' => $MahasiswaDiadop
        ]);
    }

    public function validasiMahasiswaAdop(Request $request, $id)
    {

        $request->validate([
            'deskripsi' => 'required',
        ]);


        $MahasiswaDiadop = MahasiswaDiadop::findOrFail($id);
        $MahasiswaDiadop->status = $request->type_verifikasi;
        $MahasiswaDiadop->deskripsi = $request->deskripsi;
        $MahasiswaDiadop->save();

        return redirect()->route('valid-karyaAdopsi')
            ->with('success', 'Status karya berhasil diperbarui.');
    }
}
