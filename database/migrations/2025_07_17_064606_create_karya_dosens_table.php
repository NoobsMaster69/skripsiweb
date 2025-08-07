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
        Schema::create('karya_dosens', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dosen');
            $table->string('judul_karya');
            $table->string('prodi', 100);
            $table->string('fakultas'); // Tidak pakai after() di sini
            $table->enum('jenis_karya', ['Aplikasi', 'Publikasi', 'Buku', 'Lainnya']);
            $table->year('tahun_pembuatan');
            $table->date('tanggal_perolehan'); // Tidak pakai after()
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['menunggu', 'terverifikasi', 'ditolak']);
            $table->string('file_karya')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes untuk performa
            $table->index(['prodi', 'jenis_karya']);
            $table->index('tahun_pembuatan');
            $table->index('nama_dosen');
            $table->index('judul_karya');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karya_dosens');
    }
};
