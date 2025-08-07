<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PublikasiMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'publikasi_mahasiswa_fti';

    protected $fillable = [
        'nm_mhs',
        'nim',
        'prodi',
        'fakultas',
        'tahun',
        'judul_karya',
        'kegiatan',
        'jenis_publikasi',
        'tanggal_perolehan',
        'file_upload',
        'status',
        'deskripsi'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'tanggal_perolehan' => 'date',
    ];

    // Accessor: Format jenis publikasi
    public function getFormattedJenisPublikasiAttribute()
    {
        return match($this->jenis_publikasi) {
            'buku' => 'Buku',
            'jurnal_artikel' => 'Jurnal / Artikel',
            'media_massa' => 'Media Massa',
            default => ucfirst($this->jenis_publikasi)
        };
    }

    // Accessor: Format kegiatan
    public function getFormattedKegiatanAttribute()
    {
        return $this->kegiatan === 'Publikasi Mahasiswa'
            ? 'Publikasi Mahasiswa'
            : $this->kegiatan;
    }

    // Accessor: URL file
    public function getFileUrlAttribute()
    {
        return $this->file_upload ? asset('storage/' . $this->file_upload) : null;
    }

    // Accessor: Nama file saja
    public function getFileNameAttribute()
    {
        return $this->file_upload ? basename($this->file_upload) : null;
    }

    // Accessor: Warna badge jenis publikasi
    public function getJenisPublikasiBadgeClassAttribute()
    {
        return match($this->jenis_publikasi) {
            'buku' => 'badge-danger',
            'jurnal_artikel' => 'badge-success',
            'media_massa' => 'badge-info',
            default => 'badge-secondary'
        };
    }

    // Accessor: Warna badge kegiatan
    public function getKegiatanBadgeClassAttribute()
    {
        return $this->kegiatan === 'Publikasi Mahasiswa'
            ? 'badge-info'
            : 'badge-secondary';
    }
}
