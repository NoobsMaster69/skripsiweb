<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MasterDokumenBuku;
use Illuminate\Support\Facades\File;

class MasterDokumentBukuKurikulumController extends Controller
{
    public function index()
    {
        $dokumens = MasterDokumenBuku::orderBy('nomor', 'asc')->get();

        $data = array(
            "title"         => "Master Dokumen Buku Kurikulum",
            "menuTargetRek" => "active",
            "dokumens"      => $dokumens,
        );
        return view('admin/masterdokumenbuku/index', $data);
    }

    public function create()
    {
        $data = array(
            'title'             => 'Tambah Master Dokumen Buku Kurikulum',
            'menuTargetRek'     => 'active',
        );
        return view('admin/masterdokumenbuku/create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor' => 'required|string|max:50',
            'nama' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB
            'keterangan' => 'nullable|string',
        ], [
            'nomor.required' => 'Nomor dokumen wajib diisi',
            'nama.required' => 'Nama dokumen wajib diisi',
            'file.required' => 'File dokumen wajib diupload',
            'file.mimes' => 'Format file harus PDF, DOC, atau DOCX',
            'file.max' => 'Ukuran file maksimal 10MB',
        ]);

        try {
            // Create directory if not exists
            $uploadPath = 'uploads/master-dokumen-buku';
            if (!File::exists(public_path($uploadPath))) {
                File::makeDirectory(public_path($uploadPath), 0755, true);
            }

            // Generate unique filename
            $file = $request->file('file');
            $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $filePath = $uploadPath . '/' . $fileName;

            // Move file to public directory
            $file->move(public_path($uploadPath), $fileName);

            // Save to database
            MasterDokumenBuku::create([
                'nomor' => $request->nomor,
                'nama' => $request->nama,
                'file_path' => $filePath,
                'keterangan' => $request->keterangan,
            ]);

            return redirect()->route('master-dokumen-buku')
                ->with('success', 'Master dokumen berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        $dokumen = MasterDokumenBuku::findOrFail($id);

        $data = array(
            'title' => 'Detail Master Dokumen',
            'menuTargetRek' => 'active',
            'dokumen' => $dokumen,
        );

        return view('admin/masterdokumenbuku/show', $data);
    }

    public function edit($id)
    {
        $dokumen = MasterDokumenBuku::findOrFail($id);

        $data = array(
            'title' => 'Edit Master Dokumen Buku Kurikulum',
            'menuTargetRek' => 'active',
            'dokumen' => $dokumen,
        );

        return view('admin/masterdokumenbuku/edit', $data);
    }

    public function update(Request $request, $id)
    {
        $dokumen = MasterDokumenBuku::findOrFail($id);

        $request->validate([
            'nomor' => 'required|string|max:50' . $id,
            'nama' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'keterangan' => 'nullable|string',
        ], [
            'nomor.required' => 'Nomor dokumen wajib diisi',
            'nomor.unique' => 'Nomor dokumen sudah ada',
            'nama.required' => 'Nama dokumen wajib diisi',
            'file.mimes' => 'Format file harus PDF, DOC, atau DOCX',
            'file.max' => 'Ukuran file maksimal 10MB',
        ]);

        try {
            $updateData = [
                'nomor' => $request->nomor,
                'nama' => $request->nama,
                'keterangan' => $request->keterangan,
            ];

            // Handle file upload if new file is provided
            if ($request->hasFile('file')) {
                // Delete old file
                if ($dokumen->file_path && File::exists(public_path($dokumen->file_path))) {
                    File::delete(public_path($dokumen->file_path));
                }

                // Upload new file
                $uploadPath = 'uploads/master-dokumen-buku';
                if (!File::exists(public_path($uploadPath))) {
                    File::makeDirectory(public_path($uploadPath), 0755, true);
                }

                $file = $request->file('file');
                $fileName = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $filePath = $uploadPath . '/' . $fileName;

                $file->move(public_path($uploadPath), $fileName);
                $updateData['file_path'] = $filePath;
            }

            $dokumen->update($updateData);

            return redirect()->route('master-dokumen-buku')
                ->with('success', 'Master dokumen berhasil diupdate');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $dokumen = MasterDokumenBuku::findOrFail($id);

            // Delete file from storage
            if ($dokumen->file_path && File::exists(public_path($dokumen->file_path))) {
                File::delete(public_path($dokumen->file_path));
            }

            $dokumen->delete();

            return redirect()->route('master-dokumen-buku')
                ->with('success', 'Master dokumen berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Method untuk menampilkan file
    public function viewFile($id)
    {
        $dokumen = MasterDokumenBuku::findOrFail($id);

        if (!$dokumen->file_path || !File::exists(public_path($dokumen->file_path))) {
            return redirect()->back()->with('error', 'File tidak ditemukan');
        }

        $filePath = public_path($dokumen->file_path);
        $mimeType = File::mimeType($filePath);

        // Untuk PDF, tampilkan langsung di browser
        if ($mimeType === 'application/pdf') {
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $dokumen->nama . '.pdf"'
            ]);
        }

        // Untuk Word documents, download saja karena tidak bisa ditampilkan di browser
        return $this->downloadFile($id);
    }

    // Method untuk download file
    public function downloadFile($id)
    {
        $dokumen = MasterDokumenBuku::findOrFail($id);

        if (!$dokumen->file_path || !File::exists(public_path($dokumen->file_path))) {
            abort(404, 'File tidak ditemukan');
        }

        $filePath = public_path($dokumen->file_path);
        return response()->download($filePath, $dokumen->nama . '.' . pathinfo($dokumen->file_path, PATHINFO_EXTENSION));
    }

    // Method untuk detail via AJAX
    public function getDetail($id)
    {
        $dokumen = MasterDokumenBuku::findOrFail($id);

        return response()->json([
            'id' => $dokumen->id,
            'nomor' => $dokumen->nomor,
            'nama' => $dokumen->nama,
            'file_path' => $dokumen->file_path,
            'keterangan' => $dokumen->keterangan,
            'created_at' => $dokumen->created_at->format('d/m/Y H:i'),
            'updated_at' => $dokumen->updated_at->format('d/m/Y H:i'),
            'file_size' => File::exists(public_path($dokumen->file_path)) ? File::size(public_path($dokumen->file_path)) : 0,
            'file_extension' => pathinfo($dokumen->file_path, PATHINFO_EXTENSION),
        ]);
    }



}
