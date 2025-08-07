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
        Schema::create('sertifkomp_mahasiswa_fti', function (Blueprint $table) {
            $table->id();
            $table->string('nm_mhs');
            $table->string('nim', 20); // ✅ Tambah NIM
            $table->string('prodi')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('tahun', 20);
            $table->text('judul_karya');
            $table->enum('kegiatan', ['Sertifikasi Kompetensi']); // ✅ Diubah: hanya 1 jenis kegiatan
            $table->string('tingkatan'); // ✅ Tambah tingkatan kegiatan
            $table->date('tanggal_perolehan')->nullable();
            $table->string('file_upload')->nullable(); // ✅ File bersifat opsional
            $table->enum('status', ['menunggu', 'terverifikasi', 'ditolak']);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sertifkomp_mahasiswa_fti');
    }
};
