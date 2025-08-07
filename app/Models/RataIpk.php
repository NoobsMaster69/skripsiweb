<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RataIpk extends Model
{
    use HasFactory;

    protected $table = 'rata_ipk';

    protected $fillable = [
        'nim',
        'nama',
        'prodi',
        'tahun_lulus',
        'tanggal_lulus',
        'ipk',
        'predikat',
        'status'
    ];

    protected $casts = [
        'tanggal_lulus' => 'date',
        'ipk' => 'decimal:2'
    ];

    // Boot method untuk otomatis set predikat
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->isDirty('ipk')) {
                $model->predikat = $model->determinePredikat($model->ipk);
            }
        });
    }

    // Accessor untuk format IPK
    public function getFormattedIpkAttribute()
    {
        return number_format($this->ipk, 2);
    }

    // Method untuk menentukan predikat
    private function determinePredikat($ipk)
    {
        $ipkFloat = floatval($ipk);

        if ($ipkFloat >= 3.50) {
            return 'Cum Laude';
        } elseif ($ipkFloat >= 3.00) {
            return 'Sangat Memuaskan';
        } elseif ($ipkFloat >= 2.75) {
            return 'Memuaskan';
        } else {
            return 'Cukup';
        }
    }

    // Scope untuk filter berdasarkan tahun
    public function scopeByTahun($query, $tahun)
    {
        return $query->where('tahun_lulus', $tahun);
    }

    // Scope untuk filter berdasarkan prodi
    public function scopeByProdi($query, $prodi)
    {
        return $query->where('prodi', $prodi);
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('nim', 'LIKE', "%{$search}%")
              ->orWhere('nama', 'LIKE', "%{$search}%");
        });
    }

    // Method untuk mendapatkan rata-rata IPK berdasarkan prodi
    public static function getAverageIpkByProdi($prodi = null, $tahun = null)
    {
        $query = self::query();

        if ($prodi) {
            $query->where('prodi', $prodi);
        }

        if ($tahun) {
            $query->where('tahun_lulus', $tahun);
        }

        return $query->avg('ipk') ?: 0;
    }

    // Method untuk mendapatkan statistik predikat
    public static function getPredikatStats($prodi = null, $tahun = null)
    {
        $query = self::query();

        if ($prodi) {
            $query->where('prodi', $prodi);
        }

        if ($tahun) {
            $query->where('tahun_lulus', $tahun);
        }

        return $query->selectRaw('predikat, COUNT(*) as total')
                    ->groupBy('predikat')
                    ->pluck('total', 'predikat');
    }

    // Method untuk mendapatkan data untuk chart
    public static function getIpkDistribution($prodi = null, $tahun = null)
    {
        $query = self::query();

        if ($prodi) {
            $query->where('prodi', $prodi);
        }

        if ($tahun) {
            $query->where('tahun_lulus', $tahun);
        }

        return $query->selectRaw('
            CASE
                WHEN ipk >= 3.50 THEN "Cum Laude"
                WHEN ipk >= 3.00 THEN "Sangat Memuaskan"
                WHEN ipk >= 2.75 THEN "Memuaskan"
                ELSE "Cukup"
            END as grade,
            COUNT(*) as count
        ')
        ->groupBy('grade')
        ->get();
    }

    // Method untuk mendapatkan trend IPK per tahun
    public static function getIpkTrend($prodi = null)
    {
        $query = self::query();

        if ($prodi) {
            $query->where('prodi', $prodi);
        }

        return $query->selectRaw('tahun_lulus, AVG(ipk) as avg_ipk, COUNT(*) as total_mahasiswa')
                    ->groupBy('tahun_lulus')
                    ->orderBy('tahun_lulus', 'asc')
                    ->get();
    }
}
