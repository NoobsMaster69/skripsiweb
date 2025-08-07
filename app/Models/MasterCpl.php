<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterCpl extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'master_cpl';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tahun_akademik',
        'program_studi',
        'mata_kuliah',
        'target_pencapaian',
        'keterangan'
    ];
    public function cplDosen()
    {
        return $this->hasOne(CplDosen::class);
    }
}
