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
        Schema::create('cpl_dosen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_cpl_id')->constrained('master_cpl')->onDelete('cascade');
            $table->decimal('ketercapaian', 5, 2)->nullable();
            $table->string('dokumen_pendukung')->nullable();
            $table->string('link')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cpl_dosen');
    }
};
