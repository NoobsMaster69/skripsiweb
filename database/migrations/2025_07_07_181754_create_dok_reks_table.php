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
        Schema::create('dok_reks', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_dokumen')->unique();
            $table->string('nama_dokumen');
            $table->string('di_upload'); // Siapa yang mengupload
            $table->date('tanggal_upload');
            $table->date('tanggal_pengesahan')->nullable();
            $table->enum('status', ['menunggu', 'terverifikasi', 'ditolak'])->default('menunggu');
            $table->string('file_path')->nullable(); // Path file lampiran
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys (optional - jika ada table users)
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');

            // Indexes
            $table->index('nomor_dokumen');
            $table->index('status');
            $table->index('di_upload');
            $table->index('tanggal_upload');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dok_reks');
    }
};
