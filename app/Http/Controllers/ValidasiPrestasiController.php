<?php

namespace App\Http\Controllers;

use App\Models\PrestasiMahasiswa;
use Illuminate\Http\Request;

class ValidasiPrestasiController extends Controller
{
    public function index()
    {
        $data = array(
            "title" => "Validasi Karya Prestasi Mahasiswa",
            "menuProdiCpl" => "active",
            "prestasiMahasiswa" => PrestasiMahasiswa::orderByRaw("
            FIELD(status, 'menunggu', 'terverifikasi')
        ")
                ->orderBy('created_at', 'desc')
                ->get()
        );

        return view('admin.validasiKarya.prestasimhs.index', $data);
    }


    public function validateDokumen($id)
    {
        $prestasiMahasiswa = PrestasiMahasiswa::findOrFail($id);

        // dd($prestasiMahasiswa);
        // Halaman detail dokumen
        return view('admin.validasiKarya.prestasimhs.validate', [
            'title' => 'Validasi Karya Prestasi Mahasiswa"',
            'prestasiMahasiswa' => $prestasiMahasiswa
        ]);
    }

    public function validasiPrestasi(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => 'required',
        ]);

        $prestasiMahasiswa = PrestasiMahasiswa::findOrFail($id);
        $prestasiMahasiswa->status = $request->type_verifikasi;
        $prestasiMahasiswa->deskripsi = $request->deskripsi;
        $prestasiMahasiswa->save();

        return redirect()->route('valid-prestasimhs')
            ->with('success', 'Status karya berhasil diperbarui.');
    }
}
