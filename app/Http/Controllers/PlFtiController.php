<?php

namespace App\Http\Controllers;

use App\Models\PlFti;
use App\Exports\PlFtiExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PlFtiController extends Controller
{
    public function index()
    {
        $data = [
            'title'      => 'Profil Lulusan',
            'menuCplFti' => 'active',
            'items'      => PlFti::all()
        ];
        return view('prodi.fti.profil-kelulusan.index', $data);
    }

    public function create()
    {
        return view('prodi.fti.profil-kelulusan.create', [
            'title' => 'Tambah Data Profil Lulusan'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_pl' => 'required',
            'profil_lulusan' => 'required',
            'aspek' => 'required',
            'profesi' => 'required',
            'level_kkni' => 'required',
        ]);

        PlFti::create($request->all());
        return redirect()->route('prodi-fti')->with('success', 'Data berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $item = PlFti::findOrFail($id);
        return view('prodi.fti.profil-kelulusan.edit', [
            'title' => 'Profil Lulusan',
            'item' => $item
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = PlFti::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('prodi-fti')->with('success', 'Data berhasil diupdate!');
    }

    public function destroy($id)
    {
        $item = PlFti::findOrFail($id);
        $item->delete();

        return redirect()->route('prodi-fti')->with('success', 'Data berhasil dihapus!');
    }

    public function exportExcel()
    {
        return Excel::download(new PlFtiExport, 'profil_lulusan_' . now()->format('Ymd_His') . '.xlsx');
    }

    public function exportPdf()
    {
        $items = PlFti::all();
        $title = 'Laporan Profil Lulusan ';

        $pdf = Pdf::loadView('prodi.fti.profil-kelulusan.pdf', compact('items', 'title'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('profil_lulusan_' . now()->format('Ymd_His') . '.pdf');
    }
}
