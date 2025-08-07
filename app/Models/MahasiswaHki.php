<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MahasiswaHki extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa_hki_fti';

    // ✅ Tambahkan semua kolom yang akan diisi melalui create/update
    protected $fillable = [
        'nm_mhs',
        'nim',
        'prodi',
        'fakultas',
        'tahun',
        'judul_karya',
        'kegiatan', // default 'HKI'
        'tanggal_perolehan',
        'file_upload',
        'deskripsi',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'tanggal_perolehan' => 'date', // ✅ supaya bisa diformat
    ];

    /**
     * Get the full file URL
     */
    public function getFileUrlAttribute()
    {
        return $this->file_upload ? asset('storage/' . $this->file_upload) : null;
    }

    /**
     * Get only the file name from path
     */
    public function getFileNameAttribute()
    {
        return $this->file_upload ? basename($this->file_upload) : null;
    }
}
