<?php

namespace App\Http\Controllers;

use App\Models\PeninjauanKurikulum;
use Illuminate\Http\Request;

class peninjauanKurikulumValidAdminController extends Controller
{
public function index()
    {
        $data = array(
            "title"         => "Validasi Dokumen Peninjauan Kurikulum",
            "menuProdiCpl"  => "active",
            "PeninjauanKurikulums"       => PeninjauanKurikulum::orderBy('created_at', 'desc')->get() // ubah ke 'BukuKurikulums'
        );

        return view('admin/validasiPeninjauan/index', $data);
    }


    public function validateDokumen($id)
    {

        $PeninjauanKurikulum = PeninjauanKurikulum::findOrFail($id);

        // dd($prestasiMahasiswa);
        // Halaman detail dokumen
        return view('admin/validasiPeninjauan/validate', [
            'title' => 'Validasi Dokumen Peninjauan Kurikulum',
            'PeninjauanKurikulum' => $PeninjauanKurikulum
        ]);
    }

    public function validasiPeninjauanAdmin(Request $request, $id)
    {

        $request->validate([
            'type_verifikasi' => 'required|in:terverifikasi,ditolak',
            'deskripsi' => 'required',
        ]);


        $PeninjauanKurikulum = PeninjauanKurikulum::findOrFail($id);
        $PeninjauanKurikulum->status = $request->type_verifikasi;
        $PeninjauanKurikulum->deskripsi = $request->deskripsi;
        $PeninjauanKurikulum->save();


        return redirect()->route('peninjauanKurikulumValid')
            ->with('success', 'Status karya berhasil diperbarui.');
    }
}

