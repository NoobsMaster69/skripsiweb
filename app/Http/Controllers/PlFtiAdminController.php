<?php

namespace App\Http\Controllers;

use App\Models\PlFti;
use App\Exports\PlFtiExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class PlFtiAdminController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Profil Lulusan',
            'items' => PlFti::all()
        ];
        return view('admin.profilLulusan.index', $data);
    }
    public function exportExcel()
    {
        return Excel::download(new PlFtiExport, 'profil_lulusan_admin_' . now()->format('Ymd_His') . '.xlsx');
    }

    public function exportPdf()
    {
        $items = PlFti::all();
        $title = 'Laporan Profil Lulusan';

        $pdf = Pdf::loadView('admin.profilLulusan.pdf', compact('items', 'title'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('profil_lulusan_admin_' . now()->format('Ymd_His') . '.pdf');
    }
}
