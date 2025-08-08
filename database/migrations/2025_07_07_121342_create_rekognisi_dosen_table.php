<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekognisi_dosen', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dosen');
            $table->string('nuptk')->nullable();
            $table->string('prodi');
            $table->string('bidang_rekognisi');
            $table->year('tahun_akademik');
            $table->string('fakultas')->nullable(); // <- tanpa after()
            $table->date('tanggal_rekognisi')->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['menunggu', 'terverifikasi', 'ditolak'])->default('menunggu');
            $table->string('file_bukti')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekognisi_dosen'); // <- karena kita CREATE table di up()
    }
};
