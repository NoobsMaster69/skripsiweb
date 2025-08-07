<?php

namespace App\Http\Controllers;

use App\Models\KaryaDosen;
use Illuminate\Http\Request;

class KaryaDosenValidAdminController extends Controller
{
    /**
     * Tampilkan semua data karya dosen untuk validasi
     */
    public function index()
    {
        $data = [
            'title'        => 'Validasi Dokumen Karya Dosen',
            'menuProdiCpl' => 'active',
            'karyaDosens'  => KaryaDosen::orderBy('created_at', 'desc')->paginate(10) // <= ganti ini
        ];

        return view('admin.karyaDosen.index', $data);
    }


    /**
     * Halaman detail validasi
     */
    public function validateDokumen($id)
    {
        $karyaDosen = KaryaDosen::findOrFail($id);

        return view('admin.karyaDosen.validate', [
            'title'       => 'Validasi Karya Dosen',
            'karyaDosen'  => $karyaDosen
        ]);
    }

    /**
     * Proses validasi dokumen
     */
    public function validasiKaryaDosen(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => 'required',
            'type_verifikasi' => 'in:menunggu,terverifikasi,ditolak'
        ]);

        $karyaDosen = KaryaDosen::findOrFail($id);
        $karyaDosen->status = $request->type_verifikasi; // LANGSUNG pakai nilainya
        $karyaDosen->deskripsi = $request->deskripsi;
        $karyaDosen->save();

        return redirect()->route('karyaDosenValid')->with([
            'message' => 'Status karya berhasil diperbarui.',
            'message_type' => 'success',
            'saved' => true
        ]);
    }
}
