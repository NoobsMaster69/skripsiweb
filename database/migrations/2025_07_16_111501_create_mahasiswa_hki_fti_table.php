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
        Schema::create('mahasiswa_hki_fti', function (Blueprint $table) {
            $table->id();
            $table->string('nm_mhs', 255);
            $table->string('nim', 50); // ✅ Ditambahkan karena digunakan di controller & model
            $table->string('prodi')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('tahun', 20);
            $table->string('judul_karya', 500); // ✅ Diubah dari text ke string(500) sesuai validasi
            $table->string('kegiatan', 50)->default('HKI'); // ✅ Tidak perlu enum, karena fix 'HKI'
            $table->date('tanggal_perolehan')->nullable();
            $table->enum('status', ['menunggu', 'terverifikasi', 'ditolak']);
            $table->text('deskripsi')->nullable();
            $table->string('file_upload')->nullable(); // ✅ Sudah benar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswa_hki_fti');
    }
};
