<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RekognisiDosen;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekognisiDosenExport;
use Illuminate\Support\Facades\Storage;

class RekognisiDosenController extends Controller
{
    public function index(Request $request)
    {
        $query = RekognisiDosen::query();

        if ($request->filled('tahun_akademik')) {
            $query->where('tahun_akademik', $request->tahun_akademik);
        }
        if ($request->filled('program_studi')) {
            $query->where('prodi', $request->program_studi);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_dosen', 'like', "%{$search}%")
                    ->orWhere('nuptk', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }



        $rekognisiData = $query->orderBy('created_at', 'desc')->get();

        $jumlahPendidikan = $query->clone()->where('bidang_rekognisi', 'Pendidikan')->count();
        $jumlahPengabdian = $query->clone()->where('bidang_rekognisi', 'Pengabdian Masyarakat')->count();
        $jumlahPenelitian = $query->clone()->where('bidang_rekognisi', 'Penelitian')->count();
        $jumlahProfesional = $query->clone()->where('bidang_rekognisi', 'Profesional')->count();


        $data = [
            "title" => "Rekognisi Dosen",
            "menuRekognisiDosen" => "active",
            "rekognisiDosen" => $rekognisiData,
            "jumlahPendidikan" => $jumlahPendidikan,
            "jumlahPengabdian" => $jumlahPengabdian,
            "jumlahPenelitian" => $jumlahPenelitian,
            "jumlahProfesional" => $jumlahProfesional,
        ];

        return view('dosen.rekognisi.index', $data);
    }

    public function create()
    {
        return view('dosen.rekognisi.create', [
            'title' => 'Tambah Rekognisi Dosen',
            'menuRekognisiDosen' => 'active',
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'nuptk' => 'nullable|string|max:50',
            'prodi' => 'required|string|max:255',
            'bidang_rekognisi' => 'required|string|max:255',
            'tahun_akademik' => 'required|digits:4',
            'tanggal_rekognisi' => 'nullable|date',
            'deskripsi' => 'nullable|string|max:1000',
            'file_bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png,docx|max:10240',
        ]);

        if ($request->hasFile('file_bukti')) {
            $filePath = $request->file('file_bukti')->store('rekognisi-dosen-bukti', 'public');
            $validatedData['file_bukti'] = $filePath;
        }

        RekognisiDosen::create($validatedData);

        return redirect()->route('dosen.rekognisi.index')->with([
            'saved' => true,
            'message' => 'Data rekognisi berhasil disimpan!',
            'message_type' => 'success'
        ]);
    }

    public function edit(RekognisiDosen $rekognisi)
    {
        return view('dosen.rekognisi.edit', [
            'title' => 'Edit Rekognisi Dosen',
            'menuRekognisiDosen' => 'active',
            'rekognisi' => $rekognisi,
        ]);
    }

    public function update(Request $request, RekognisiDosen $rekognisi)
    {
        $validatedData = $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'nuptk' => 'nullable|string|max:50',
            'prodi' => 'required|string|max:255',
            'bidang_rekognisi' => 'required|string|max:255',
            'tahun_akademik' => 'required|digits:4',
            'tanggal_rekognisi' => 'nullable|date',
            'deskripsi' => 'nullable|string|max:1000',
            'file_bukti' => 'nullable|file|mimes:pdf,jpg,jpeg,png,docx|max:10240',
        ]);

        if ($request->hasFile('file_bukti')) {
            if ($rekognisi->file_bukti) {
                Storage::disk('public')->delete($rekognisi->file_bukti);
            }

            $filePath = $request->file('file_bukti')->store('rekognisi-dosen-bukti', 'public');
            $validatedData['file_bukti'] = $filePath;
        }

        $rekognisi->update($validatedData);

        return redirect()->route('dosen.rekognisi.index')
            ->with('saved', true)
            ->with('message_type', 'success')
            ->with('message', 'Data rekognisi berhasil diupdate!');
    }

    public function exportExcel()
{
    $data = RekognisiDosen::all();
    return Excel::download(new RekognisiDosenExport($data), 'rekognisi-dosen.xlsx');
}


    public function exportPDF()
    {
        $data = RekognisiDosen::all();
        $pdf = Pdf::loadView('dosen.rekognisi.pdf', compact('data'))->setPaper('A4', 'landscape');
        return $pdf->download('rekognisi-dosen.pdf');
    }

    public function destroy(RekognisiDosen $rekognisi)
    {
        try {
            if ($rekognisi->file_bukti) {
                Storage::disk('public')->delete($rekognisi->file_bukti);
            }

            $namaDosen = $rekognisi->nama_dosen;
            $rekognisi->delete();

            return redirect()->route('dosen.rekognisi.index')
                ->with('message_type', 'success')
                ->with('message', 'Data rekognisi untuk <strong>' . $namaDosen . '</strong> berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('dosen.rekognisi.index')
                ->with('message_type', 'danger')
                ->with('message', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
