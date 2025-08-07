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
        Schema::create('mahasiswa_lainnya_fti', function (Blueprint $table) {
            $table->id();
            $table->string('nm_mhs');
            $table->string('nim', 20);
            $table->string('prodi')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('tahun', 20);
            $table->text('judul_karya');
            $table->enum('kegiatan', ['Produk', 'Jasa']);
            $table->date('tanggal_perolehan')->nullable();
            $table->enum('status', ['menunggu', 'terverifikasi', 'ditolak']);
            $table->text('deskripsi')->nullable();
            $table->string('file_upload')->nullable(); // Dibuat nullable jika file tidak wajib
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_lainnya_fti');
    }
};
