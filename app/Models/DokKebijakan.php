<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DokKebijakan extends Model
{
    use HasFactory;

    protected $table = 'dok-kebijakan';

    protected $fillable = [
        'nomor_dokumen',
        'nama_dokumen',
        'di_upload',
        'tanggal_upload',
        'tanggal_pengesahan',
        'status',
        'validasi',
    ];
}
