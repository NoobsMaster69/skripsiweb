<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryaMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'karya_mahasiswa_fti';

    protected $fillable = [
        'nm_mhs',
        'tahun',
        'judul_karya',
        'kegiatan',
        'tingkat',
        'file_upload'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the formatted tingkat attribute
     */
    public function getFormattedTingkatAttribute()
    {
        return match($this->tingkat) {
            'local-wilayah' => 'Local/Wilayah',
            'nasional' => 'Nasional',
            'internasional' => 'Internasional',
            default => $this->tingkat
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
