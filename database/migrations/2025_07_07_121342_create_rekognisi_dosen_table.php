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
        Schema::create('rekognisi_dosen', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dosen');
            $table->string('nuptk')->nullable();
            $table->string('prodi');
            $table->string('bidang_rekognisi');
            $table->year('tahun_akademik');
            $table->string('fakultas')->nullable()->after('prodi');
            $table->date('tanggal_rekognisi')->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['menunggu', 'terverifikasi', 'ditolak']);
            $table->string('file_bukti')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekognisi_dosen', function (Blueprint $table) {
        $table->dropColumn('fakultas');
    });

    }
};
