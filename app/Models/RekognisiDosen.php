<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekognisiDosen extends Model
{
    use HasFactory;

    /**
     *
     *
     * @var string
     */
    protected $table = 'rekognisi_dosen';

    /**
     *
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_dosen',
        'nuptk',
        'prodi',
        'bidang_rekognisi',
        'tahun_akademik',
        'tanggal_rekognisi',
        'deskripsi',
        'status',
        'file_bukti',
    ];
}
