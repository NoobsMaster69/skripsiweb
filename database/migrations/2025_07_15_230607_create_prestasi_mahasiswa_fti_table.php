<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('prestasi_mahasiswa_fti', function (Blueprint $table) {
            $table->id();
            $table->string('nm_mhs');
            $table->string('nim', 20);
            $table->string('prodi')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('tahun', 20);
            $table->text('judul_karya');
            $table->enum('kegiatan', ['Publikasi', 'Karya', 'Produk', 'Hki']);
            $table->enum('tingkat', ['local-wilayah', 'nasional', 'internasional']);
            $table->enum('prestasi', ['prestasi-akademik', 'prestasi-non-akademik']);
            $table->date('tanggal_perolehan')->nullable();
            $table->enum('status', ['menunggu', 'terverifikasi', 'ditolak']);
            $table->text('deskripsi')->nullable();
            $table->string('file_upload')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi_mahasiswa_fti');
    }
};
