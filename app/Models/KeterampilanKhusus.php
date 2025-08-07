<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeterampilanKhusus extends Model
{
    protected $table = 'keterampilan_khusus';

    protected $fillable = ['kode', 'deskripsi', 'sumber'];
}
