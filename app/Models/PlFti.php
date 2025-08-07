<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlFti extends Model
{
    use HasFactory;

    protected $table = 'pl_fti';

    protected $fillable = [
        'kode_pl', 'profil_lulusan', 'aspek', 'profesi', 'level_kkni'
    ];
}
