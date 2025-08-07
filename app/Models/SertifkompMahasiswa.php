<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SertifkompMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'sertifkomp_mahasiswa_fti';

    protected $fillable = [
        'nm_mhs',
        'nim',
        'prodi',
        'fakultas',
        'tahun',
        'judul_karya',
        'kegiatan',
        'tingkatan',
        'tanggal_perolehan',
        'status',
        'deskripsi',
        'file_upload',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the formatted kegiatan attribute
     */
    public function getFormattedKegiatanAttribute()
    {
        return $this->kegiatan === 'Sertifikasi Kompetensi'
            ? 'Sertifikasi Kompetensi Mahasiswa'
            : $this->kegiatan;
    }

    /**
     * Get the file URL
     */
    public function getFileUrlAttribute()
    {
        return $this->file_upload ? asset('storage/' . $this->file_upload) : null;
    }

    /**
     * Get the file name only
     */
    public function getFileNameAttribute()
    {
        return $this->file_upload ? basename($this->file_upload) : null;
    }

    /**
     * Get badge class for kegiatan
     */
    public function getKegiatanBadgeClassAttribute()
    {
        return $this->kegiatan === 'Sertifikasi Kompetensi'
            ? 'badge-info'
            : 'badge-secondary';
    }
}
