<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'nama'          => 'Iqbal',
            'email'         => 'Admin@gmail.com',
            'jabatan'       => 'Admin',
            'password'      => Hash::make('12345678'),
        ]);
         User::create([
            'nama'          => 'Tono',
            'email'         => 'Rektorat@gmail.com',
            'jabatan'       => 'Rektorat',
            'password'      => Hash::make('12345678'),
        ]); User::create([
            'nama'          => 'Toto',
            'email'         => 'Fakultas@gmail.com',
            'jabatan'       => 'Fakultas',
            'password'      => Hash::make('12345678'),
        ]);User::create([
            'nama'          => 'Dodo',
            'email'         => 'Dosen@gmail.com',
            'jabatan'       => 'Dosen',
            'password'      => Hash::make('12345678'),
        ]);User::create([
            'nama'          => 'Didi',
            'email'         => 'Prodi@gmail.com',
            'jabatan'       => 'Prodi',
            'password'      => Hash::make('12345678'),
        ]);
    }
}
