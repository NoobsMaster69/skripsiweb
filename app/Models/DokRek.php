<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DokRek extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dok_reks';

    protected $fillable = [
        'master_dokumen_id',  // Tambahkan foreign key
        'nomor_dokumen',
        'nama_dokumen',
        'di_upload',
        'tanggal_upload',
        'tanggal_pengesahan',
        'status',
        'lampiran',
        'deskripsi',
        'file_path',
        'created_by',
        'updated_by',
        'validated_by',      // TAMBAHAN BARU
        'validated_at',      // TAMBAHAN BARU
    ];

    protected $dates = [
        'tanggal_upload',
        'tanggal_pengesahan',
        'validated_at',      // TAMBAHAN BARU
        'deleted_at'
    ];

    protected $casts = [
        'tanggal_upload' => 'date',
        'tanggal_pengesahan' => 'date',
        'validated_at' => 'datetime',  // TAMBAHAN BARU
    ];

    // Status constants
    const STATUS_BELUM_VALIDASI = 'belum_validasi';
    const STATUS_VALIDASI = 'validasi';
    const STATUS_DITOLAK = 'ditolak';

    /**
     * Get the master dokumen that owns this dok rek.
     */
    public function masterDokumen()
    {
        return $this->belongsTo(MasterDokumen::class, 'master_dokumen_id');
    }

    // Relasi dengan User (creator)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi dengan User (updater)
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Relasi dengan User (validator) - TAMBAHAN BARU
    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    // Accessor untuk status badge - DIPERBARUI
    public function getStatusBadgeAttribute()
    {
        switch ($this->status) {
            case self::STATUS_VALIDASI:
                return '<span class="badge badge-success" style="font-size: 0.73rem; padding: 0.5em 1em;">Sudah Validasi</span>';
            case self::STATUS_DITOLAK:
                return '<span class="badge badge-danger" style="font-size: 0.73rem; padding: 0.5em 1em;">Ditolak</span>';
            case self::STATUS_BELUM_VALIDASI:
                return '<span class="badge badge-warning" style="font-size: 0.73rem; padding: 0.5em 1em;">Belum Validasi</span>';
            default:
                return '<span class="badge badge-secondary" style="font-size: 0.73rem; padding: 0.5em 1em;">Unknown</span>';
        }
    }

    // Accessor untuk upload badge
    public function getUploadBadgeAttribute()
    {
        return '<span class="badge badge-dark" style="font-size: 0.75rem; padding: 0.5em 1em;">' . $this->di_upload . '</span>';
    }

    // Accessor untuk icon status - TAMBAHAN BARU
    public function getStatusIconAttribute()
    {
        switch ($this->status) {
            case self::STATUS_VALIDASI:
                return '<i class="fas fa-check-circle text-success"></i>';
            case self::STATUS_DITOLAK:
                return '<i class="fas fa-times-circle text-danger"></i>';
            case self::STATUS_BELUM_VALIDASI:
                return '<i class="fas fa-clock text-warning"></i>';
            default:
                return '<i class="fas fa-question-circle text-secondary"></i>';
        }
    }

    // Scope untuk filter berdasarkan status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk filter berdasarkan uploader
    public function scopeByUploader($query, $uploader)
    {
        return $query->where('di_upload', $uploader);
    }

    // Scope untuk filter berdasarkan master dokumen
    public function scopeByMasterDokumen($query, $masterDokumenId)
    {
        return $query->where('master_dokumen_id', $masterDokumenId);
    }

    // Scope untuk belum validasi - TAMBAHAN BARU
    public function scopeBelumValidasi($query)
    {
        return $query->where('status', self::STATUS_BELUM_VALIDASI);
    }

    // Scope untuk sudah validasi - TAMBAHAN BARU
    public function scopeSudahValidasi($query)
    {
        return $query->where('status', self::STATUS_VALIDASI);
    }

    // Scope untuk ditolak - TAMBAHAN BARU
    public function scopeDitolak($query)
    {
        return $query->where('status', self::STATUS_DITOLAK);
    }

    // Mutator untuk format tanggal
    public function setTanggalUploadAttribute($value)
    {
        $this->attributes['tanggal_upload'] = date('Y-m-d', strtotime($value));
    }

    public function setTanggalPengesahanAttribute($value)
    {
        $this->attributes['tanggal_pengesahan'] = date('Y-m-d', strtotime($value));
    }

    // Accessor untuk format tanggal display
    public function getTanggalUploadFormattedAttribute()
    {
        return $this->tanggal_upload ? $this->tanggal_upload->format('d-m-Y') : '';
    }

    public function getTanggalPengesahanFormattedAttribute()
    {
        return $this->tanggal_pengesahan ? $this->tanggal_pengesahan->format('d-m-Y') : '';
    }

    // Accessor untuk format tanggal validasi - TAMBAHAN BARU
    public function getValidatedAtFormattedAttribute()
    {
        return $this->validated_at ? $this->validated_at->format('d-m-Y H:i') : '';
    }

    // Method untuk cek apakah file exists
    public function hasFile()
    {
        return $this->file_path && file_exists(public_path($this->file_path));
    }

    // Method untuk mendapatkan URL file
    public function getFileUrl()
    {
        return $this->file_path ? asset($this->file_path) : '#';
    }

    // Method untuk mendapatkan nama dokumen dari master dokumen
    public function getMasterDokumenNamaAttribute()
    {
        return $this->masterDokumen ? $this->masterDokumen->nama : $this->nama_dokumen;
    }

    // Method untuk cek apakah dokumen sudah divalidasi - TAMBAHAN BARU
    public function isValidated()
    {
        return in_array($this->status, [self::STATUS_VALIDASI, self::STATUS_DITOLAK]);
    }

    // Method untuk mendapatkan nama validator - TAMBAHAN BARU
    public function getValidatorNameAttribute()
    {
        return $this->validator ? $this->validator->name : '';
    }
}
