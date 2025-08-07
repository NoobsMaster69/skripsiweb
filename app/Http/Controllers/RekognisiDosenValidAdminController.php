<?php

namespace App\Http\Controllers;

use App\Models\RekognisiDosen;
use Illuminate\Http\Request;

class RekognisiDosenValidAdminController extends Controller
{
    /**
     * Tampilkan semua data karya dosen untuk validasi
     */
    public function index(Request $request)
    {
        $query = RekognisiDosen::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_dosen', 'like', "%$search%")
                    ->orWhere('prodi', 'like', "%$search%")
                    ->orWhere('bidang_rekognisi', 'like', "%$search%")
                    ->orWhere('deskripsi', 'like', "%$search%");
            });
        }

        $RekognisiDosens = $query->orderByRaw("
        CASE
            WHEN status = 'menunggu' THEN 0
            WHEN status = 'terverifikasi' THEN 1
            WHEN status = 'ditolak' THEN 2
            ELSE 3
        END
    ")->orderBy('created_at', 'desc')->get();

        $data = [
            'title' => 'Validasi Rekognisi Dosen',
            'menuProdiCpl' => 'active',
            'RekognisiDosens' => $RekognisiDosens,
        ];

        return view('admin.rekognisi.index', $data);
    }



    /**
     * Halaman detail validasi
     */
    public function validateDokumen($id)
    {
        $RekognisiDosen = RekognisiDosen::findOrFail($id);

        return view('admin.rekognisi.validate', [
            'title'       => 'Validasi Karya Dosen',
            'RekognisiDosen'  => $RekognisiDosen
        ]);
    }

    /**
     * Proses validasi dokumen
     */
    public function validasiRekognisiDosen(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => 'required',
            'type_verifikasi' => 'in:menunggu,terverifikasi,ditolak'
        ]);

        $RekognisiDosen = RekognisiDosen::findOrFail($id);
        $RekognisiDosen->status = $request->type_verifikasi; // LANGSUNG pakai nilainya
        $RekognisiDosen->deskripsi = $request->deskripsi;
        $RekognisiDosen->save();

        return redirect()->route('rekognisiDosenValid')->with([
            'message' => 'Status karya berhasil diperbarui.',
            'message_type' => 'success',
            'saved' => true
        ]);
    }
}
