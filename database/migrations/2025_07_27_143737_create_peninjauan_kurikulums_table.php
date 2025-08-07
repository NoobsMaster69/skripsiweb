<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeninjauanKurikulumsTable extends Migration
{
    public function up()
    {
        Schema::create('peninjauan_kurikulums', function (Blueprint $table) {
            $table->id();

            // Data utama
            $table->string('nomor_dokumen')->unique();
            $table->string('nama_dokumen');
            $table->string('di_upload');
            $table->date('tanggal_upload');         // ✅ Tambahan
            $table->date('tanggal_pengesahan');     // ✅ Tambahan
            $table->text('deskripsi')->nullable();
            $table->string('file_path')->nullable();

            // Status dan tracking
            $table->enum('status', ['menunggu', 'terverifikasi', 'ditolak'])->default('menunggu');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('validated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('validated_at')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('peninjauan_kurikulums');
    }
}
