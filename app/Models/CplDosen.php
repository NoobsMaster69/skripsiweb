<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CplDosen extends Model
{
    use HasFactory;

    protected $table = 'cpl_dosen';

    protected $fillable = [
        'master_cpl_id',
        'ketercapaian',
        'dokumen_pendukung',
        'link',
        'keterangan',
    ];

    protected $casts = [
        'ketercapaian' => 'decimal:2',
    ];

    /**
     * Relasi ke tabel master_cpl (many-to-one)
     */
    public function masterCpl()
    {
        return $this->belongsTo(MasterCpl::class, 'master_cpl_id');
    }

    /**
     * Aksesor: URL file dokumen pendukung
     */
    public function getDocumentUrlAttribute()
    {
        return $this->dokumen_pendukung ? asset('storage/' . $this->dokumen_pendukung) : null;
    }

    /**
     * Aksesor: hanya nama file dokumen (tanpa path)
     */
    public function getDocumentNameAttribute()
    {
        return $this->dokumen_pendukung ? basename($this->dokumen_pendukung) : null;
    }
}
