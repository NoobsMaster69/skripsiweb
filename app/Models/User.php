<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'jabatan',  // <- Role sudah ada di sini
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Role helper methods - sesuaikan dengan field jabatan
    public function isAdmin()
    {
        return $this->jabatan === 'admin';
    }

    public function isRektorat()
    {
        return $this->jabatan === 'rektorat';
    }

    public function isFakultas()
    {
        return $this->jabatan === 'fakultas';
    }

    public function isProdi()
    {
        return $this->jabatan === 'prodi';
    }

    public function getRoleLabelAttribute()
    {
        $labels = [
            'admin' => 'Administrator',
            'rektorat' => 'Rektorat',
            'fakultas' => 'Fakultas',
            'prodi' => 'Program Studi',
        ];

        return $labels[$this->jabatan] ?? $this->jabatan;
    }
}
