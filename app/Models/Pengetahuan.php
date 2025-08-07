<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengetahuan extends Model
{
    protected $table = 'pengetahuan';
    protected $fillable = ['kode', 'deskripsi', 'sumber'];
}
