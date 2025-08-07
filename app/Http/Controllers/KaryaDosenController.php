<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\KaryaDosenExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekognisiDosenExport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\KaryaDosen; // Pastikan model ini ada

class KaryaDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = KaryaDosen::query();

        // Filter berdasarkan jenis karya
        if ($request->filled('jenis_karya')) {
            $query->where('jenis_karya', $request->jenis_karya);
        }

        // Filter berdasarkan program studi
        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        // Search berdasarkan nama dosen
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_dosen', 'like', '%' . $search . '%')
                    ->orWhere('judul_karya', 'like', '%' . $search . '%')
                    ->orWhere('prodi', 'like', '%' . $search . '%')
                    ->orWhere('fakultas', 'like', '%' . $search . '%');
            });
        }

        $karyaDosens = $query->latest()->paginate(10);

        $data = [
            "title" => "Data Karya Dosen",
            "menuKaryaDosen" => "active",
            "karyaDosens" => $karyaDosens
        ];

        return view('dosen/karya-dosen/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Data Karya Dosen',
            'menuKaryaDosen' => 'active',
        ];

        return view('dosen/karya-dosen/create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_dosen' => 'required|string|max:255',
            'judul_karya' => 'required|string|max:255',
            'prodi' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'jenis_karya' => 'required|string|max:50',
            'tahun_pembuatan' => 'required|integer|min:2020|max:2030',
            'tanggal_perolehan' => 'required|date',
            'deskripsi' => 'nullable|string|max:1000',
            'file_karya' => 'nullable|file|mimes:pdf,docx,jpg,jpeg,png,zip,rar|max:5120', // 5MB max
        ], [
            'nama_dosen.required' => 'Nama dosen wajib diisi',
            'judul_karya.required' => 'Judul karya wajib diisi',
            'prodi.required' => 'Program studi wajib dipilih',
            'fakultas.required' => 'Fakultas wajib dipilih',
            'jenis_karya.required' => 'Jenis karya wajib dipilih',
            'tahun_pembuatan.required' => 'Tahun pembuatan wajib dipilih',
            'tanggal_perolehan.required' => 'Tanggal perolehan wajib diisi',
            'tanggal_perolehan.date' => 'Tanggal perolehan tidak valid',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter',
            'file_karya.mimes' => 'File harus berformat: PDF, DOCX, JPG, JPEG, PNG, ZIP, RAR',
            'file_karya.max' => 'Ukuran file maksimal 5MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', 'Terjadi kesalahan dalam pengisian form!')
                ->with('message_type', 'danger');
        }

        try {
            $data = $request->only([
                'nama_dosen',
                'judul_karya',
                'prodi',
                'fakultas',
                'jenis_karya',
                'tahun_pembuatan',
                'tanggal_perolehan',
                'deskripsi'
            ]);

            // Handle file upload
            if ($request->hasFile('file_karya')) {
                $file = $request->file('file_karya');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('karya-dosen', $fileName, 'public');
                $data['file_karya'] = $filePath;
            }

            // Simpan ke database
            KaryaDosen::create($data);

            return redirect()->route('karya-dosen.index')
                ->with('saved', true)
                ->with('message', 'Data berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('message', 'Terjadi kesalahan: ' . $e->getMessage())
                ->with('message_type', 'danger');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $karyaDosen = KaryaDosen::findOrFail($id);

            $data = [
                'title' => 'Detail Karya Dosen',
                'menuKaryaDosen' => 'active',
                'karyaDosen' => $karyaDosen
            ];

            return view('dosen/karya-dosen/show', $data);
        } catch (\Exception $e) {
            return redirect()->route('karya-dosen.index')
                ->with('message', 'Data tidak ditemukan!')
                ->with('message_type', 'danger');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $karyaDosen = KaryaDosen::findOrFail($id);

            $data = [
                'title' => 'Edit Data Karya Dosen',
                'menuKaryaDosen' => 'active',
                'karyaDosen' => $karyaDosen
            ];

            return view('dosen/karya-dosen/edit', $data);
        } catch (\Exception $e) {
            return redirect()->route('karya-dosen.index')
                ->with('message', 'Data tidak ditemukan!')
                ->with('message_type', 'danger');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama_dosen' => 'required|string|max:255',
            'judul_karya' => 'required|string|max:255',
            'prodi' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
            'jenis_karya' => 'required|string|max:50',
            'tahun_pembuatan' => 'required|integer|min:2020|max:2030',
            'deskripsi' => 'nullable|string|max:1000',
            'tanggal_perolehan' => 'required|date',
            'file_karya' => 'nullable|file|mimes:pdf,docx,jpg,jpeg,png,zip,rar|max:5120',
        ], [
            'nama_dosen.required' => 'Nama dosen wajib diisi',
            'judul_karya.required' => 'Judul karya wajib diisi',
            'prodi.required' => 'Program studi wajib dipilih',
            'fakultas.required' => 'Fakultas wajib dipilih',
            'jenis_karya.required' => 'Jenis karya wajib dipilih',
            'tahun_pembuatan.required' => 'Tahun pembuatan wajib dipilih',
            'tanggal_perolehan.required' => 'Tanggal perolehan wajib diisi',
            'tanggal_perolehan.date' => 'Tanggal perolehan tidak valid',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter',
            'file_karya.mimes' => 'File harus berformat: PDF, DOCX, JPG, JPEG, PNG, ZIP, RAR',
            'file_karya.max' => 'Ukuran file maksimal 5MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', 'Terjadi kesalahan dalam pengisian form!')
                ->with('message_type', 'danger');
        }

        try {
            $karyaDosen = KaryaDosen::findOrFail($id);

            $data = $request->only([
                'nama_dosen',
                'judul_karya',
                'prodi',
                'fakultas',
                'jenis_karya',
                'tahun_pembuatan',
                'tanggal_perolehan',
                'deskripsi'
            ]);

            // Handle file upload
            if ($request->hasFile('file_karya')) {
                // Hapus file lama jika ada
                if ($karyaDosen->file_karya && Storage::disk('public')->exists($karyaDosen->file_karya)) {
                    Storage::disk('public')->delete($karyaDosen->file_karya);
                }

                $file = $request->file('file_karya');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('karya-dosen', $fileName, 'public');
                $data['file_karya'] = $filePath;
            }

            // Update data
            $karyaDosen->update($data);

            return redirect()->route('karya-dosen.index')
                ->with('message', 'Data karya dosen berhasil diperbarui!')
                ->with('message_type', 'success');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('message', 'Terjadi kesalahan: ' . $e->getMessage())
                ->with('message_type', 'danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $karyaDosen = KaryaDosen::findOrFail($id);

            // Hapus file jika ada
            if ($karyaDosen->file_karya && Storage::disk('public')->exists($karyaDosen->file_karya)) {
                Storage::disk('public')->delete($karyaDosen->file_karya);
            }

            // Hapus data dari database
            $karyaDosen->delete();

            return redirect()->route('karya-dosen.index')
                ->with('message', 'Data karya dosen berhasil dihapus!')
                ->with('message_type', 'success');
        } catch (\Exception $e) {
            return redirect()->route('karya-dosen.index')
                ->with('message', 'Terjadi kesalahan: ' . $e->getMessage())
                ->with('message_type', 'danger');
        }
    }

    /**
     * Export data to Excel
     */
    public function exportExcel(Request $request)
    {
        $query = KaryaDosen::query();

        if ($request->filled('jenis_karya')) {
            $query->where('jenis_karya', $request->jenis_karya);
        }

        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        if ($request->filled('search')) {
            $query->where('nama_dosen', 'like', '%' . $request->search . '%');
        }

        $data = $query->get();

        return Excel::download(new KaryaDosenExport($data), 'karya_dosen_' . date('Y_m_d_His') . '.xlsx');
    }


    /**
     * Export data to PDF
     */
    public function exportPDF(Request $request)
    {
        $query = KaryaDosen::query();

        // Terapkan filter yang sama seperti di index
        if ($request->filled('jenis_karya')) {
            $query->where('jenis_karya', $request->jenis_karya);
        }

        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        if ($request->filled('search')) {
            $query->where('nama_dosen', 'like', '%' . $request->search . '%');
        }

        $data = [
            'title' => 'Laporan Karya Dosen',
            'tanggal' => now()->format('d F Y'),
            'karyaDosen' => $query->get()
        ];

        $pdf = Pdf::loadView('dosen.karya-dosen.pdf', $data)->setPaper('a4', 'landscape');
        return $pdf->download('karya_dosen_' . date('Y_m_d_His') . '.pdf');
    }

    /**
     * Download file karya
     */
    public function downloadFile($id)
    {
        try {
            $karyaDosen = KaryaDosen::findOrFail($id);

            if (!$karyaDosen->file_karya || !Storage::disk('public')->exists($karyaDosen->file_karya)) {
                return redirect()->back()
                    ->with('message', 'File tidak ditemukan!')
                    ->with('message_type', 'danger');
            }

            $filePath = storage_path('app/public/' . $karyaDosen->file_karya);
            $fileName = basename($karyaDosen->file_karya);

            return response()->download($filePath, $fileName);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('message', 'Terjadi kesalahan: ' . $e->getMessage())
                ->with('message_type', 'danger');
        }
    }
}
