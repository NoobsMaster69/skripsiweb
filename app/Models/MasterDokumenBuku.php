<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\File;

class MasterDokumenBuku extends Model
{
    use HasFactory;

    protected $table = 'master_dokumen_buku';

    protected $fillable = [
        'nomor',
        'nama',
        'file_path',
        'keterangan',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // Accessor untuk mendapatkan URL file
    public function getFileUrlAttribute()
    {
        if ($this->file_path && File::exists(public_path($this->file_path))) {
            return asset($this->file_path);
        }
        return null;
    }

    // Accessor untuk mendapatkan ukuran file
    public function getFileSizeAttribute()
    {
        if ($this->file_path && File::exists(public_path($this->file_path))) {
            return File::size(public_path($this->file_path));
        }
        return 0;
    }

    // Accessor untuk mendapatkan ukuran file dalam format yang mudah dibaca
    public function getFileSizeFormattedAttribute()
    {
        $size = $this->file_size;
        if ($size < 1024) {
            return $size . ' B';
        } elseif ($size < 1024 * 1024) {
            return round($size / 1024, 2) . ' KB';
        } else {
            return round($size / (1024 * 1024), 2) . ' MB';
        }
    }

    // Accessor untuk mendapatkan extension file
    public function getFileExtensionAttribute()
    {
        if ($this->file_path) {
            return pathinfo($this->file_path, PATHINFO_EXTENSION);
        }
        return null;
    }

    // Accessor untuk mendapatkan nama file asli
    public function getFileNameAttribute()
    {
        if ($this->file_path) {
            return pathinfo($this->file_path, PATHINFO_FILENAME);
        }
        return null;
    }

    // Method untuk cek apakah file ada
    public function fileExists()
    {
        return $this->file_path && File::exists(public_path($this->file_path));
    }

    // Method untuk mendapatkan icon berdasarkan extension
    public function getFileIconAttribute()
    {
        $extension = $this->file_extension;

        switch ($extension) {
            case 'pdf':
                return ['class' => 'fas fa-file-pdf', 'color' => 'text-danger'];
            case 'doc':
            case 'docx':
                return ['class' => 'fas fa-file-word', 'color' => 'text-primary'];
            default:
                return ['class' => 'fas fa-file', 'color' => 'text-secondary'];
        }
    }
}

