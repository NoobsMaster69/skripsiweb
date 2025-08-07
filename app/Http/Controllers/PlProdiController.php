<?php

namespace App\Http\Controllers;

use App\Models\Sikap;
use App\Exports\KKExport;
use App\Exports\KUExport;
use App\Models\Pengetahuan;
use App\Exports\SikapExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\KeterampilanUmum;
use App\Exports\PengetahuanExport;
use App\Models\KeterampilanKhusus;
use Maatwebsite\Excel\Facades\Excel;

class PlProdiController extends Controller
{
    public function index()
    {
        $title = 'Profil Lulusan';
        $sikaps = Sikap::all();
        return view('prodi.fti.cpl-fti.sikap.viewSikap', compact('title', 'sikaps'));
    }

    public function createSikap()
    {
        $title = 'Tambah Profil Lulusan - Sikap';
        return view('prodi.fti.cpl-fti.sikap.createSikap', compact('title'));
    }

    public function storeSikap(Request $request)
    {
        $request->validate([
            'kode' => 'required|string',
            'deskripsi' => 'required|string',
            'sumber' => 'required|string'
        ]);

        Sikap::create([
            'kode' => $request->kode,
            'deskripsi' => $request->deskripsi,
            'sumber' => $request->sumber
        ]);

        return redirect()->route('viewSikap-fti')->with('success', 'Data berhasil disimpan');
    }

    public function exportSikapExcel()
    {
        return Excel::download(new SikapExport, 'profil_lulusan_sikap_' . now()->format('Ymd_His') . '.xlsx');
    }

    public function exportSikapPdf()
    {
        $sikaps = Sikap::all();
        $pdf = Pdf::loadView('prodi.fti.cpl-fti.sikap.pdf', compact('sikaps'))->setPaper('A4', 'landscape');
        return $pdf->download('profil_lulusan_sikap_' . now()->format('Ymd_His') . '.pdf');
    }

    public function editSikap($id)
    {
        $item = Sikap::findOrFail($id);
        $title = 'Edit Profil Lulusan - Sikap';
        return view('prodi.fti.cpl-fti.sikap.editSikap', compact('item', 'title'));
    }

    public function updateSikap(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:50',
            'deskripsi' => 'required|string',
            'sumber' => 'required|string|max:100',
        ]);

        $item = Sikap::findOrFail($id);
        $item->update($request->only('kode', 'deskripsi', 'sumber'));

        return redirect()->route('viewSikap-fti')->with('success', 'Data berhasil diperbarui');
    }

    public function destroySikap($id)
    {
        $item = Sikap::findOrFail($id);
        $item->delete();

        return redirect()->route('viewSikap-fti')->with('success', 'Data berhasil dihapus');
    }





    public function indexku()
    {
        $title = 'Profil Lulusan Keterampilan Umum';
        $keterampilanUmum = KeterampilanUmum::all();
        return view('prodi.fti.cpl-fti.keterampilanUmum.viewKU', compact('title', 'keterampilanUmum'));
    }

    public function createKU()
    {
        $title = 'Tambah Profil Lulusan - Keterampilan Umum';
        return view('prodi.fti.cpl-fti.keterampilanUmum.createKU', compact('title'));
    }

    public function storeku(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'kode' => 'required|string|max:50',
            'deskripsi' => 'required|string',
            'sumber' => 'required|string|max:100',
        ]);

        // Simpan ke database (pastikan pakai model yang sesuai)
        KeterampilanUmum::create($validated);

        // Redirect ke halaman index KU
        return redirect()->route('viewKU-fti')->with('success', 'Data berhasil disimpan');
    }

    public function editKU($id)
    {
        $title = 'Edit Profil Lulusan - Keterampilan Umum';
        $ku = KeterampilanUmum::findOrFail($id);
        return view('prodi.fti.cpl-fti.keterampilanUmum.edit', compact('title', 'ku'));
    }

    public function updateKU(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'sumber' => 'required|string|max:255',
        ]);

        $ku = KeterampilanUmum::findOrFail($id);
        $ku->update($request->only('kode', 'deskripsi', 'sumber'));

        return redirect()->route('viewKU-fti')->with('success', 'Data berhasil diperbarui.');
    }


    public function exportKUExcel()
    {
        return Excel::download(new KUExport, 'profil_lulusan_sikap_' . now()->format('Ymd_His') . '.xlsx');
    }

    public function exportKUPdf()
    {
        $keterampilanUmum = KeterampilanUmum::all();
        $pdf = Pdf::loadView('prodi.fti.cpl-fti.keterampilanUmum.pdf', compact('keterampilanUmum'))->setPaper('a4', 'portrait');
        return $pdf->download('data_keterampilan_umum.pdf');
    }

    public function destroyKU($id)
    {
        $ku = KeterampilanUmum::findOrFail($id);
        $ku->delete();

        return redirect()->route('viewKU-fti')->with('success', 'Data berhasil dihapus');
    }




    public function indexkk()
    {
        $title = 'Profil Lulusan Keterampilan Khusus';
        $KeterampilanKhusus = KeterampilanKhusus::all();
        return view('prodi.fti.cpl-fti.keterampilanKhusus.viewKK', compact('title', 'KeterampilanKhusus'));
    }
    public function createKK()
    {
        $title = 'Tambah Profil Lulusan - Keterampilan Khusus';
        return view('prodi.fti.cpl-fti.keterampilanKhusus.createKK', compact('title'));
    }
    public function storekk(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:50',
            'deskripsi' => 'required|string',
            'sumber' => 'required|string|max:100',
        ]);

        KeterampilanKhusus::create($validated);

        return redirect()->route('viewKK-fti')->with('success', 'Data berhasil disimpan');
    }

    public function editKK($id)
    {
        $title = 'Edit Profil Lulusan - Keterampilan Khusus';
        $kk = KeterampilanKhusus::findOrFail($id);

        return view('prodi.fti.cpl-fti.keterampilanKhusus.edit', compact('title', 'kk'));
    }


    public function updateKK(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'sumber' => 'required|string|max:255',
        ]);

        $kk = KeterampilanKhusus::findOrFail($id);
        $kk->update($request->only('kode', 'deskripsi', 'sumber'));

        return redirect()->route('viewKK-fti')->with('success', 'Data berhasil diperbarui.');
    }


    public function exportKKExcel()
    {
        return Excel::download(new KKExport, 'profil_lulusan_khusus_' . now()->format('Ymd_His') . '.xlsx');
    }

    public function exportKKPdf()
    {
        $keterampilanKhusus = KeterampilanKhusus::all();
        $pdf = Pdf::loadView('prodi.fti.cpl-fti.keterampilanKhusus.pdf', compact('keterampilanKhusus'))->setPaper('a4', 'portrait');
        return $pdf->download('data_keterampilan_khusus.pdf');
    }

    public function destroyKk($id)
    {
        $ku = KeterampilanKhusus::findOrFail($id);
        $ku->delete();

        return redirect()->route('viewKK-fti')->with('success', 'Data berhasil dihapus');
    }


    public function indexpengetahuan()
    {
        $title = 'Profil Lulusan Pengetahuan';
        $pengetahuans = Pengetahuan::all();
        return view('prodi.fti.cpl-fti.pengetahuan.viewPengetahuan', compact('title', 'pengetahuans'));
    }
    public function createPengetahuan()
    {
        $title = 'Tambah Profil Lulusan - Pengetahuan';
        return view('prodi.fti.cpl-fti.pengetahuan.createPe', compact('title'));
    }
    public function storepengetahuan(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:50',
            'deskripsi' => 'required|string',
            'sumber' => 'required|string|max:100',
        ]);

        Pengetahuan::create($validated);

        return redirect()->route('viewPengetahuan-fti')->with('success', 'Data berhasil disimpan');
    }

    public function editPengetahuan($id)
    {
        $pengetahuan = Pengetahuan::findOrFail($id);
        $title = 'Edit Data Pengetahuan';

        return view('prodi.fti.cpl-fti.pengetahuan.edit', compact('pengetahuan', 'title'));
    }

    public function updatePengetahuan(Request $request, $id)
    {
        $request->validate([
            'kode' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'sumber' => 'required|string|max:255',
        ]);

        $pengetahuan = Pengetahuan::findOrFail($id);
        $pengetahuan->update([
            'kode' => $request->kode,
            'deskripsi' => $request->deskripsi,
            'sumber' => $request->sumber,
        ]);

        return redirect()->route('viewPengetahuan-fti')->with('success', 'Data Pengetahuan berhasil diperbarui.');
    }

    public function exportPengetahuanExcel()
    {
        return Excel::download(new PengetahuanExport, 'profil_lulusan_pengetahuan_' . now()->format('Ymd_His') . '.xlsx');
    }

    public function exportPengetahuanPdf()
    {
        $pengetahuans = Pengetahuan::all();
        $pdf = Pdf::loadView('prodi.fti.cpl-fti.pengetahuan.pdf', compact('pengetahuans'))->setPaper('a4', 'portrait');
        return $pdf->download('data_pengetahuan.pdf');
    }

    public function destroyPengetahuan($id)
    {
        $pengetahuan = Pengetahuan::findOrFail($id);
        $pengetahuan->delete();

        return redirect()->route('viewPengetahuan-fti')->with('success', 'Data berhasil dihapus');
    }

}
