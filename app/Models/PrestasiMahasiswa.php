<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrestasiMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'prestasi_mahasiswa_fti';

    protected $fillable = [
        'nim',
        'nm_mhs',
        'prodi',
        'fakultas',
        'tahun',
        'judul_karya',
        'kegiatan',
        'tingkat',
        'prestasi',
        'status',
        'deskripsi',
        'file_upload',
        'tanggal_perolehan'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'tanggal_perolehan' => 'date',
    ];

    /**
     * Get the formatted tingkat attribute
     */
    public function getFormattedTingkatAttribute()
    {
        return match ($this->tingkat) {
            'local-wilayah' => 'Local/Wilayah',
            'nasional' => 'Nasional',
            'internasional' => 'Internasional',
            default => $this->tingkat
        };
    }

    /**
     * Get the formatted prestasi attribute
     */
    public function getFormattedPrestasiAttribute()
    {
        return match ($this->prestasi) {
            'prestasi-akademik' => 'Prestasi Akademik',
            'prestasi-non-akademik' => 'Prestasi Non-Akademik',
            default => $this->prestasi
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
}
