<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\User;


class UserExport implements FromView
{
    public function view(): View
    {
        $data = array(
            'user' => User::orderBy('Jabatan','asc')->get(),
            'tanggal' => now()->setTimezone('Asia/Jakarta')->format('d-m-Y'),
            'jam' => now()->setTimezone('Asia/Jakarta')->format('H.i.s'),

        );
        return view('admin/user/excel', $data);
    }
}
