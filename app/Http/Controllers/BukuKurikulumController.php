<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\BukuKurikulum;
use App\Models\MasterDokumenBuku;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\BukuKurikulumExport;

class BukuKurikulumController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Data Buku Kurikulum';
        $query = BukuKurikulum::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_dokumen', 'like', '%' . $request->search . '%')
                  ->orWhere('nomor_dokumen', 'like', '%' . $request->search . '%');
            });
        }

        $bukuKurikulum = $query->latest()->paginate(10);
        return view('prodi.fti.buku-kurikulum.index', compact('title', 'bukuKurikulum'));
    }

    public function create()
    {
        $title = 'Tambah Data Buku Kurikulum';
        $masterBuku = MasterDokumenBuku::orderBy('nama')->get();
        return view('prodi.fti.buku-kurikulum.create', compact('title', 'masterBuku'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_dokumen' => 'required|string|max:255|unique:buku_kurikulums,nomor_dokumen',
            'nama_dokumen' => ['required', Rule::exists('master_dokumen_buku', 'nama')],
            'di_upload' => 'required|string|max:255',
            'tanggal_upload' => 'required|date',
            'tanggal_pengesahan' => 'nullable|date',
            'deskripsi' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $buku = new BukuKurikulum();
            $buku->nomor_dokumen = $request->nomor_dokumen;
            $buku->nama_dokumen = $request->nama_dokumen;
            $buku->di_upload = $request->di_upload;
            $buku->tanggal_upload = $request->tanggal_upload;
            $buku->tanggal_pengesahan = $request->tanggal_pengesahan;
            $buku->deskripsi = $request->deskripsi;
            $buku->status = 'menunggu';
            $buku->created_by = auth()->id();

            if ($request->hasFile('lampiran')) {
                $file = $request->file('lampiran');
                $filename = time() . '_' . Str::slug($request->nama_dokumen) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('buku-kurikulum', $filename, 'public');
                $buku->file_path = 'storage/' . $path;
            }

            $buku->save();
            return redirect()->route('buku-kurikulumfti')->with('success', 'Data buku kurikulum berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(BukuKurikulum $bukuKurikulum)
    {
        if ($bukuKurikulum->status !== 'menunggu') {
            return redirect()->route('buku-kurikulumfti')->with('error', 'Data yang sudah divalidasi tidak dapat diedit.');
        }

        $title = 'Edit Buku Kurikulum';
        $masterBuku = MasterDokumenBuku::all();
        return view('prodi.fti.buku-kurikulum.edit', compact('title', 'bukuKurikulum', 'masterBuku'));
    }

    public function update(Request $request, BukuKurikulum $bukuKurikulum)
    {
        $validator = Validator::make($request->all(), [
            'nomor_dokumen' => 'required|string|max:255|unique:buku_kurikulums,nomor_dokumen,' . $bukuKurikulum->id,
            'nama_dokumen' => ['required', Rule::exists('master_dokumen_buku', 'nama')],
            'di_upload' => 'required|string|max:255',
            'tanggal_upload' => 'required|date',
            'tanggal_pengesahan' => 'nullable|date',
            'deskripsi' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $bukuKurikulum->nomor_dokumen = $request->nomor_dokumen;
        $bukuKurikulum->nama_dokumen = $request->nama_dokumen;
        $bukuKurikulum->di_upload = $request->di_upload;
        $bukuKurikulum->tanggal_upload = $request->tanggal_upload;
        $bukuKurikulum->tanggal_pengesahan = $request->tanggal_pengesahan;
        $bukuKurikulum->deskripsi = $request->deskripsi;
        $bukuKurikulum->updated_by = auth()->id();

        if ($request->hasFile('lampiran')) {
            if ($bukuKurikulum->file_path && file_exists(public_path($bukuKurikulum->file_path))) {
                unlink(public_path($bukuKurikulum->file_path));
            }

            $file = $request->file('lampiran');
            $filename = time() . '_' . Str::slug($request->nama_dokumen) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('buku-kurikulum', $filename, 'public');
            $bukuKurikulum->file_path = 'storage/' . $path;
        }

        $bukuKurikulum->save();
        return redirect()->route('buku-kurikulumfti')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(BukuKurikulum $bukuKurikulum)
    {
        if ($bukuKurikulum->file_path && file_exists(public_path($bukuKurikulum->file_path))) {
            unlink(public_path($bukuKurikulum->file_path));
        }

        $bukuKurikulum->delete();
        return redirect()->route('buku-kurikulumfti')->with('success', 'Data berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new BukuKurikulumExport, 'buku-kurikulum-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function exportPdf()
    {
        $data = BukuKurikulum::all();
        $pdf = Pdf::loadView('prodi.fti.buku-kurikulum.pdf', compact('data'));
        return $pdf->download('buku-kurikulum-' . now()->format('Y-m-d') . '.pdf');
    }
}
