<?php

namespace App\Http\Controllers;

use App\Models\DokRek;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\DokRekExport;
use App\Models\MasterDokumen;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DokRekController extends Controller
{
    /**
     * Display a listing of the resource with enhanced statistics for admin
     */
    public function index(Request $request)
    {
        $title = 'Data Dokumen Kebijakan';

        // Query builder
        $query = DokRek::query();

        // Filter berdasarkan status (untuk admin)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_dokumen', 'like', "%{$search}%")
                    ->orWhere('nama_dokumen', 'like', "%{$search}%")
                    ->orWhere('di_upload', 'like', "%{$search}%");
            });
        }

        // Ambil data dengan paginasi
        $dokReks = $query->latest()->paginate(10);

        // Statistik sederhana (optional, bisa disesuaikan)
        // $stats = [
        //     'total' => DokRek::count(),
        //     'belum_validasi' => DokRek::where('status', 'belum_validasi')->count(),
        //     'validasi' => DokRek::where('status', 'validasi')->count(),
        //     'ditolak' => DokRek::where('status', 'ditolak')->count(),
        // ];

        return view('rektorat.dok-kebijakan.index', compact('title', 'dokReks'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Ambil semua data master dokumen untuk dropdown
        $masterDokumens = MasterDokumen::orderBy('nama', 'asc')->get();

        $data = array(
            'title' => 'Tambah Dokumen Rektorat',
            'menuTargetRek' => 'active',
            'masterDokumens' => $masterDokumens,
        );

        return view('rektorat.dok-kebijakan.create', $data);
    }

    /**
     * Store a newly created resource in storage - UPDATED
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nomor_dokumen' => 'required|string|max:255|unique:dok_reks,nomor_dokumen',
            'nama_dokumen' => [
                'required',
                'string',
                'max:255',
                Rule::exists('master_dokumens', 'nama')
            ],
            'di_upload' => 'required|string|max:255',
            'tanggal_upload' => 'required|date',
            'tanggal_pengesahan' => 'nullable|date',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240', // 10MB
        ], [
            'nomor_dokumen.required' => 'Nomor dokumen wajib diisi',
            'nomor_dokumen.unique' => 'Nomor dokumen sudah ada',
            'nama_dokumen.required' => 'Nama dokumen wajib diisi',
            'nama_dokumen.exists' => 'Nama dokumen tidak valid atau tidak ada di master dokumen',
            'di_upload.required' => 'Unit yang mengupload wajib dipilih',
            'tanggal_upload.required' => 'Tanggal upload wajib diisi',
            'lampiran.mimes' => 'Format file harus PDF, DOC, DOCX, JPG, JPEG, atau PNG',
            'lampiran.max' => 'Ukuran file maksimal 10MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $dokRek = new DokRek();
            $dokRek->nomor_dokumen = $request->nomor_dokumen;
            $dokRek->nama_dokumen = $request->nama_dokumen;
            $dokRek->di_upload = $request->di_upload;
            $dokRek->tanggal_upload = $request->tanggal_upload;
            $dokRek->tanggal_pengesahan = $request->tanggal_pengesahan;

            // AUTO SET STATUS & DESKRIPSI - PERUBAHAN UTAMA
            $dokRek->status = 'menunggu';
            $dokRek->deskripsi = null;

            $dokRek->created_by = auth()->id();

            // Handle file upload
            if ($request->hasFile('lampiran')) {
                $file = $request->file('lampiran');
                $filename = time() . '_' . Str::slug($request->nama_dokumen) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('documents', $filename, 'public');
                $dokRek->file_path = 'storage/' . $path;
            }

            $dokRek->save();

            return redirect()->route('dok-rek.index')

                ->with('success', 'Dokumen berhasil disubmit dan menunggu validasi dari admin.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Quick approve document (Admin only) - BARU
     */
    public function approve(DokRek $dokRek)
    {
        // Check authorization
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Check document status
        if ($dokRek->status !== 'menunggu') {

            return response()->json([
                'success' => false,
                'message' => 'Dokumen sudah diproses sebelumnya'
            ], 422);
        }

        try {
            $dokRek->update([
                'status' => 'validasi',
                'validated_by' => auth()->id(),
                'validated_at' => now(),
                'updated_by' => auth()->id(),
                'deskripsi' => null, // Clear any previous rejection reason
            ]);

            return response()->json([
                'success' => true,
                'message' => "Dokumen {$dokRek->nomor_dokumen} berhasil disetujui",
                'status_badge' => $dokRek->fresh()->status_badge
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reject document with reason (Admin only) - BARU
     */
    public function reject(Request $request, DokRek $dokRek)
    {
        // Check authorization
        if (!auth()->user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        // Check document status
        if ($dokRek->status !== 'menunggu') {
            return response()->json([
                'success' => false,
                'message' => 'Dokumen sudah diproses sebelumnya'
            ], 422);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|max:1000'
        ], [
            'reason.required' => 'Alasan penolakan wajib diisi',
            'reason.max' => 'Alasan penolakan maksimal 1000 karakter'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        try {
            $dokRek->update([
                'status' => 'ditolak',
                'validated_by' => auth()->id(),
                'validated_at' => now(),
                'updated_by' => auth()->id(),
                'deskripsi' => $request->reason,
            ]);

            return response()->json([
                'success' => true,
                'message' => "Dokumen {$dokRek->nomor_dokumen} berhasil ditolak",
                'status_badge' => $dokRek->fresh()->status_badge
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // ... EXISTING METHODS TETAP SAMA ...

    /**
     * Display the specified resource.
     */
    public function show(DokRek $dokRek)
    {
        $title = 'Detail Dokumen Rekam';
        return view('dok-rek.show', compact('title', 'dokRek'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DokRek $dokRek)
    {
        // Only allow edit if document is pending validation
        // Hanya blokir edit jika status adalah 'terverifikasi' saja
        if ($dokRek->status === 'terverifikasi') {
            return redirect()->route('dok-rek.index')
                ->with('error', 'Dokumen yang sudah diproses tidak dapat diedit.');
        }


        $masterDokumens = MasterDokumen::orderBy('nama', 'asc')->get();
        $title = 'Edit Dokumen Rekam';

        return view('rektorat.dok-kebijakan.edit', compact('title', 'dokRek', 'masterDokumens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DokRek $dokRek)
    {
        // Only allow update if document is pending validation
        if ($dokRek->status === 'terverifikasi') {
            return redirect()->route('dok-rek.index')
                ->with('error', 'Dokumen yang sudah diproses tidak dapat diubah.');
        }


        $validator = Validator::make($request->all(), [
            'nomor_dokumen' => 'required|string|max:255|unique:dok_reks,nomor_dokumen,' . $dokRek->id,
            'nama_dokumen' => 'required|string|max:255',
            'di_upload' => 'required|string|max:255',
            'tanggal_upload' => 'required|date',
            'tanggal_pengesahan' => 'nullable|date',
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $dokRek->nomor_dokumen = $request->nomor_dokumen;
        $dokRek->nama_dokumen = $request->nama_dokumen;
        $dokRek->di_upload = $request->di_upload;
        $dokRek->tanggal_upload = $request->tanggal_upload;
        $dokRek->tanggal_pengesahan = $request->tanggal_pengesahan;
        $dokRek->updated_by = auth()->id();

        // Handle file upload
        if ($request->hasFile('lampiran')) {
            // Delete old file if exists
            if ($dokRek->file_path && file_exists(public_path($dokRek->file_path))) {
                unlink(public_path($dokRek->file_path));
            }

            $file = $request->file('lampiran');
            $filename = time() . '_' . Str::slug($request->nama_dokumen) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('documents', $filename, 'public');
            $dokRek->file_path = 'storage/' . $path;
        }

        $dokRek->save();

        return redirect()->route('dok-rek.index')

            ->with('success', 'Data dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DokRek $dokRek)
    {
        // Hanya boleh hapus dokumen dengan status belum_validasi atau menunggu
        if ($dokRek->status === 'terverifikasi') {

            return redirect()->route('dok-rek.index')
                ->with('error', 'Dokumen yang sudah diproses tidak dapat dihapus.');
        }

        // Hapus file jika ada
        if ($dokRek->file_path && file_exists(public_path($dokRek->file_path))) {
            unlink(public_path($dokRek->file_path));
        }

        // Hapus data dari database
        $dokRek->delete();

        return redirect()->route('dok-rek.index')
            ->with('success', 'Data dokumen berhasil dihapus.');
    }


    // ... EXISTING EXPORT & OTHER METHODS TETAP SAMA ...

    /**
     * Export data to Excel
     */
    public function exportExcel()
    {
        $dokReks = DokRek::all();
        return Excel::download(new DokRekExport($dokReks), 'dokumen-kebijakan-rektorat' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Export data to PDF
     */
    public function exportPdf()
    {
        $dokReks = DokRek::all();
        $title = 'Data Dokumen Kebijakan Rektorat';
        $pdf = Pdf::loadView('rektorat.dok-kebijakan.pdf', compact('dokReks', 'title'));
        return $pdf->download('dokumen-kebijakan-rektorat-' . date('Y-m-d') . '.pdf');
    }

    /**
     * Sync data - placeholder for sync functionality
     */
    public function sync()
    {
        return redirect()->route('dok-rek.index')

            ->with('success', 'Data berhasil disinkronisasi.');
    }

    /**
     * Search and filter data
     */
    public function search(Request $request)
    {
        $query = DokRek::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nomor_dokumen', 'like', "%{$search}%")
                    ->orWhere('nama_dokumen', 'like', "%{$search}%")
                    ->orWhere('di_upload', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('uploader')) {
            $query->where('di_upload', $request->uploader);
        }

        if ($request->filled('tanggal_dari') && $request->filled('tanggal_sampai')) {
            $query->whereBetween('tanggal_upload', [$request->tanggal_dari, $request->tanggal_sampai]);
        }

        $dokReks = $query->latest()->paginate(10);
        $title = 'Data Dokumen Rekam';

        return view('rektorat.dok-kebijakan.index', compact('title', 'dokReks'));
    }

    /**
     * Update status dokumen
     */
    public function updateStatus(Request $request, DokRek $dokRek)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:menunggu,terverifikasi,ditolak',


        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $dokRek->status = $request->status;
        $dokRek->updated_by = auth()->id();
        $dokRek->save();

        return response()->json([
            'success' => true,
            'message' => 'Status dokumen berhasil diperbarui.',
            'status_badge' => $dokRek->status_badge
        ]);
    }

    /**
     * Halaman validasi dokumen untuk admin - EXISTING
     */
    public function validateDokumen($id)
    {
        $dokRek = DokRek::findOrFail($id);
        return view('admin.dok-kebijakan.validate', [
            'title' => 'Validasi Dokumen Kebijakan',
            'dokRek' => $dokRek,
        ]);
    }
}
