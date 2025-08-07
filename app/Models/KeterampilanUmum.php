<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeterampilanUmum extends Model
{
    protected $table = 'keterampilan_umum';


    protected $fillable = ['kode', 'deskripsi', 'sumber'];
}
