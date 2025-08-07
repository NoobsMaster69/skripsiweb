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
        Schema::create('karya_mahasiswa_fti', function (Blueprint $table) {
            $table->id();
            $table->string('nm_mhs');
            $table->string('tahun', 20);
            $table->text('judul_karya');
            $table->enum('kegiatan', ['Publikasi', 'Karya', 'Produk', 'Hki']);
            $table->enum('tingkat', ['local-wilayah', 'nasional', 'internasional']);
            $table->string('file_upload')->nullable(); // Dibuat nullable jika file tidak wajib
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karya_mahasiswa_fti');
    }
};
