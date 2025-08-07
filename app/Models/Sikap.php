<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sikap extends Model
{
    protected $table = 'sikap'; // <- TABEL EXPLICIT

    protected $fillable = ['kode', 'deskripsi', 'sumber'];
}
