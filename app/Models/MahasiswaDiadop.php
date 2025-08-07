<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MahasiswaDiadop extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa_diadopsi_fti';

    protected $fillable = [
        'nm_mhs',
        'nim',
        'prodi',
        'fakultas',
        'tahun',
        'judul_karya',
        'kegiatan',
        'tanggal_perolehan',
        'file_upload'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'tanggal_perolehan' => 'date'
    ];

    /**
     * Get the formatted kegiatan attribute
     */
    public function getFormattedKegiatanAttribute()
    {
        return match($this->kegiatan) {
            'Publikasi' => 'Publikasi',
            'Karya' => 'Karya',
            'Produk' => 'Produk',
            'Hki' => 'HKI',
            default => $this->kegiatan
        };
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
        return match($this->kegiatan) {
            'Jasa' => 'badge-success',
            'Produk' => 'badge-info',
            default => 'badge-secondary'
        };
    }

    /**
     * Get formatted tanggal perolehan (optional accessor)
     */
    public function getTanggalPerolehanFormattedAttribute()
    {
        return $this->tanggal_perolehan ? $this->tanggal_perolehan->format('d-m-Y') : '-';
    }
}
