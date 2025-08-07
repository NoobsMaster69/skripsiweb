<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MasterDokument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MasterDocumentController extends Controller
{
    public function index()
    {
        $docs = MasterDokument::latest()->paginate(10);
        return view('admin.master-documents.index', compact('docs'));
    }

    public function create()
    {
        return view('admin.master-documents.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nomor'      => 'required|unique:master_documents,nomor',
            'nama'       => 'required|string|max:255',
            'dokumen'    => 'required|file|mimes:pdf,doc,docx',
        ]);

        // simpan file
        $path = $request->file('dokumen')->store('master_docs');

        MasterDokument::create([
            'nomor'     => $data['nomor'],
            'nama'      => $data['nama'],
            'file_path' => $path,
        ]);

        return redirect()->route('admin.master-documents.index')
                         ->with('success', 'Master document berhasil ditambahkan.');
    }

    public function edit(MasterDokument $masterDocument)
    {
        return view('admin.master-documents.edit', compact('masterDocument'));
    }

    public function update(Request $request, MasterDokument $masterDocument)
    {
        $data = $request->validate([
            'nomor'   => 'required|unique:master_documents,nomor,'.$masterDocument->id,
            'nama'    => 'required|string|max:255',
            'dokumen' => 'nullable|file|mimes:pdf,doc,docx',
        ]);

        if ($request->hasFile('dokumen')) {
            // hapus file lama
            Storage::delete($masterDocument->file_path);
            $masterDocument->file_path = $request->file('dokumen')->store('master_docs');
        }

        $masterDocument->update([
            'nomor'     => $data['nomor'],
            'nama'      => $data['nama'],
            'file_path' => $masterDocument->file_path,
        ]);

        return redirect()->route('admin.master-documents.index')
                         ->with('success', 'Master document berhasil diperbarui.');
    }

    public function destroy(MasterDokument $masterDocument)
    {
        Storage::delete($masterDocument->file_path);
        $masterDocument->delete();

        return back()->with('success', 'Master document berhasil dihapus.');
    }
}
