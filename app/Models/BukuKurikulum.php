<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BukuKurikulum extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'buku_kurikulums';

    protected $fillable = [
        'nomor_dokumen',
        'nama_dokumen',
        'di_upload',
        'tanggal_upload',
        'tanggal_pengesahan',
        'deskripsi',
        'file_path',
        'status',
        'created_by',
        'updated_by',
        'validated_by',
        'validated_at',
    ];

    protected $dates = [
        'tanggal_upload',
        'tanggal_pengesahan',
        'validated_at',
        'deleted_at',
    ];

    protected $casts = [
        'tanggal_upload' => 'date',
        'tanggal_pengesahan' => 'date',
        'validated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_VALIDASI = 'validasi';
    const STATUS_DITOLAK  = 'ditolak';

    // Relasi ke user
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    // Badge & Icon
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            self::STATUS_VALIDASI => '<span class="badge badge-success">Sudah Validasi</span>',
            self::STATUS_DITOLAK => '<span class="badge badge-danger">Ditolak</span>',
            self::STATUS_MENUNGGU => '<span class="badge badge-warning">Menunggu Validasi</span>',
            default => '<span class="badge badge-secondary">Tidak Diketahui</span>',
        };
    }

    public function getStatusIconAttribute()
    {
        return match ($this->status) {
            self::STATUS_VALIDASI => '<i class="fas fa-check-circle text-success"></i>',
            self::STATUS_DITOLAK => '<i class="fas fa-times-circle text-danger"></i>',
            self::STATUS_MENUNGGU => '<i class="fas fa-clock text-warning"></i>',
            default => '<i class="fas fa-question-circle text-secondary"></i>',
        };
    }

    public function getValidatedAtFormattedAttribute()
    {
        return $this->validated_at ? $this->validated_at->format('d-m-Y H:i') : '';
    }

    public function getTanggalUploadFormattedAttribute()
    {
        return $this->tanggal_upload ? $this->tanggal_upload->format('d-m-Y') : '';
    }

    public function getTanggalPengesahanFormattedAttribute()
    {
        return $this->tanggal_pengesahan ? $this->tanggal_pengesahan->format('d-m-Y') : '';
    }

    public function getValidatorNameAttribute()
    {
        return $this->validator ? $this->validator->name : '';
    }

    public function hasFile()
    {
        return $this->file_path && file_exists(public_path($this->file_path));
    }

    public function getFileUrl()
    {
        return $this->file_path ? asset($this->file_path) : '#';
    }

    public function isValidated()
    {
        return in_array($this->status, [self::STATUS_VALIDASI, self::STATUS_DITOLAK]);
    }

    // Scope
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeBelumValidasi($query)
    {
        return $query->where('status', self::STATUS_MENUNGGU);
    }

    public function scopeSudahValidasi($query)
    {
        return $query->where('status', self::STATUS_VALIDASI);
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', self::STATUS_DITOLAK);
    }
}
