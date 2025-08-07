<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KaryaDosen extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'karya_dosens';

    protected $fillable = [
        'nama_dosen',
        'judul_karya',
        'prodi',
        'fakultas',              // ✅ Baru ditambahkan
        'jenis_karya',
        'tahun_pembuatan',
        'tanggal_perolehan',     // ✅ Baru ditambahkan
        'deskripsi',
        'status',
        'file_karya',
    ];

    protected $dates = [
        'deleted_at',
        'tanggal_perolehan',     // ✅ Perlu agar bisa pakai $model->tanggal_perolehan->format()
    ];

    protected $casts = [
        'tahun_pembuatan' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Akses URL file karya
     */
    public function getFileUrlAttribute()
    {
        if ($this->file_karya) {
            return asset('storage/' . $this->file_karya);
        }
        return null;
    }

    /**
     * Ambil nama file saja
     */
    public function getFileNameAttribute()
    {
        return $this->file_karya ? basename($this->file_karya) : null;
    }

    /**
     * Scope: filter berdasarkan program studi
     */
    public function scopeByProdi($query, $prodi)
    {
        return $query->where('prodi', $prodi);
    }

    /**
     * Scope: filter berdasarkan jenis karya
     */
    public function scopeByJenisKarya($query, $jenisKarya)
    {
        return $query->where('jenis_karya', $jenisKarya);
    }

    /**
     * Scope: filter berdasarkan tahun
     */
    public function scopeByTahun($query, $tahun)
    {
        return $query->where('tahun_pembuatan', $tahun);
    }
}
