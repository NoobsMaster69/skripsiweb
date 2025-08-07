<?php

namespace App\Exports;
use App\Models\RekognisiDosen;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Concerns\FromCollection;

class RekapRekognisiDosenExport implements FromView
{
        protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $query = RekognisiDosen::query();

        if ($this->request->filled('tahun')) {
            $query->where('tahun_akademik', $this->request->tahun);
        }
        if ($this->request->filled('prodi')) {
            $query->where('prodi', $this->request->prodi);
        }
        if ($this->request->filled('bidang')) {
            $query->where('bidang_rekognisi', $this->request->bidang);
        }
        if ($this->request->filled('tanggal_awal')) {
            $query->whereDate('tanggal_rekognisi', '>=', $this->request->tanggal_awal);
        }
        if ($this->request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_rekognisi', '<=', $this->request->tanggal_akhir);
        }

        return view('admin.rekapRekognisi.export', [
            'rekognisiDosens' => $query->get()
        ]);
    }
}
