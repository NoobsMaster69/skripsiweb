<?php

namespace App\Http\Controllers;

use App\Models\BukuKurikulum;
use Illuminate\Http\Request;

class BukuKurikulumValidAdminController extends Controller
{
    public function index()
    {
        $data = array(
            "title"         => "Validasi Dokumen Buku Kurikulum",
            "menuProdiCpl"  => "active",
            "BukuKurikulums"       => BukuKurikulum::orderBy('created_at', 'desc')->get() // ubah ke 'BukuKurikulums'
        );

        return view('admin/validasiBukuKurikulum/index', $data);
    }


    public function validateDokumen($id)
    {

        $BukuKurikulum = BukuKurikulum::findOrFail($id);

        // dd($prestasiMahasiswa);
        // Halaman detail dokumen
        return view('admin/validasiBukuKurikulum/validate', [
            'title' => 'Validasi Dokumen Buku Kurikulum"',
            'BukuKurikulum' => $BukuKurikulum
        ]);
    }

    public function validasiBukAdmin(Request $request, $id)
    {

        $request->validate([
            'type_verifikasi' => 'required|in:terverifikasi,ditolak',
            'deskripsi' => 'required',
        ]);


        $BukuKurikulum = BukuKurikulum::findOrFail($id);
        $BukuKurikulum->status = $request->type_verifikasi;
        $BukuKurikulum->deskripsi = $request->deskripsi;
        $BukuKurikulum->save();


        return redirect()->route('bukuKurikulumValid')
            ->with('success', 'Status karya berhasil diperbarui.');
    }
}
