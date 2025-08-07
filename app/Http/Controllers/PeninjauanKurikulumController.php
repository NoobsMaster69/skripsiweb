<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeninjauanKurikulum;
use App\Models\MasterDokumenPeninjauan;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\PeninjauanKurikulumExport;

class PeninjauanKurikulumController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Data Peninjauan Kurikulum';
        $query = PeninjauanKurikulum::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_dokumen', 'like', '%' . $request->search . '%')
                    ->orWhere('nomor_dokumen', 'like', '%' . $request->search . '%');
            });
        }

        $data = $query->latest()->paginate(10);
        return view('prodi.fti.peninjauan-kurikulum.index', compact('title', 'data'));
    }

    public function create()
    {
        $title = 'Tambah Peninjauan Kurikulum';
        $masterDokumen = MasterDokumenPeninjauan::orderBy('nama')->get();
        return view('prodi.fti.peninjauan-kurikulum.create', compact('title', 'masterDokumen'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_dokumen' => 'required|string|max:255|unique:peninjauan_kurikulums,nomor_dokumen',
            'nama_dokumen' => 'required|string|max:255',
            'di_upload' => 'required|string',
            'tanggal_upload' => 'required|date',
            'tanggal_pengesahan' => 'required|date',
            'deskripsi' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $model = new PeninjauanKurikulum();
        $model->nomor_dokumen = $request->nomor_dokumen;
        $model->nama_dokumen = $request->nama_dokumen;
        $model->di_upload = $request->di_upload;
        $model->tanggal_upload = $request->tanggal_upload;
        $model->tanggal_pengesahan = $request->tanggal_pengesahan;
        $model->deskripsi = $request->deskripsi;
        $model->status = 'menunggu';
        $model->created_by = auth()->id();

        if ($request->hasFile('lampiran')) {
            $file = $request->file('lampiran');
            $filename = time() . '_' . Str::slug($request->nama_dokumen) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('peninjauan-kurikulum', $filename, 'public');
            $model->file_path = 'storage/' . $path;
        }

        $model->save();

        return redirect()->route('peninjauan-kurikulum.index')->with('success', 'Data berhasil disimpan.');
    }

    public function edit(PeninjauanKurikulum $peninjauanKurikulum)
    {
        $title = 'Edit Peninjauan Kurikulum';
        $masterDokumen = MasterDokumenPeninjauan::all();
        return view('prodi.fti.peninjauan-kurikulum.edit', compact('title', 'peninjauanKurikulum', 'masterDokumen'));
    }

    public function update(Request $request, PeninjauanKurikulum $peninjauanKurikulum)
    {
        $validator = Validator::make($request->all(), [
            'nomor_dokumen' => 'required|string|max:255|unique:peninjauan_kurikulums,nomor_dokumen,' . $peninjauanKurikulum->id,
            'nama_dokumen' => 'required|string|max:255',
            'di_upload' => 'required|string',
            'tanggal_upload' => 'required|date',
            'tanggal_pengesahan' => 'required|date',
            'deskripsi' => 'nullable|string',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $peninjauanKurikulum->nomor_dokumen = $request->nomor_dokumen;
        $peninjauanKurikulum->nama_dokumen = $request->nama_dokumen;
        $peninjauanKurikulum->di_upload = $request->di_upload;
        $peninjauanKurikulum->tanggal_upload = $request->tanggal_upload;
        $peninjauanKurikulum->tanggal_pengesahan = $request->tanggal_pengesahan;
        $peninjauanKurikulum->deskripsi = $request->deskripsi;
        $peninjauanKurikulum->updated_by = auth()->id();

        if ($request->hasFile('lampiran')) {
            if ($peninjauanKurikulum->file_path && file_exists(public_path($peninjauanKurikulum->file_path))) {
                unlink(public_path($peninjauanKurikulum->file_path));
            }

            $file = $request->file('lampiran');
            $filename = time() . '_' . Str::slug($request->nama_dokumen) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('peninjauan-kurikulum', $filename, 'public');
            $peninjauanKurikulum->file_path = 'storage/' . $path;
        }

        $peninjauanKurikulum->save();

        return redirect()->route('peninjauan-kurikulum.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(PeninjauanKurikulum $peninjauanKurikulum)
    {
        if ($peninjauanKurikulum->file_path && file_exists(public_path($peninjauanKurikulum->file_path))) {
            unlink(public_path($peninjauanKurikulum->file_path));
        }

        $peninjauanKurikulum->delete();
        return redirect()->route('peninjauan-kurikulum.index')->with('success', 'Data berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new PeninjauanKurikulumExport, 'peninjauan-kurikulum-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function exportPdf()
    {
        $data = PeninjauanKurikulum::all();
        $pdf = Pdf::loadView('prodi.fti.peninjauan-kurikulum.pdf', compact('data'));
        return $pdf->download('peninjauan-kurikulum-' . now()->format('Y-m-d') . '.pdf');
    }
}
