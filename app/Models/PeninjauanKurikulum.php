<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeninjauanKurikulum extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'peninjauan_kurikulums';

    protected $fillable = [
        'nomor_dokumen',
        'nama_dokumen',
        'di_upload',
        'tanggal_upload',       // ✅ baru
        'tanggal_pengesahan',   // ✅ baru
        'deskripsi',
        'file_path',
        'status',
        'created_by',
        'updated_by',
        'validated_by',
        'validated_at',
    ];

    protected $dates = [
        'tanggal_upload',        // ✅ baru
        'tanggal_pengesahan',    // ✅ baru
        'validated_at',
        'deleted_at',
    ];

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
}
