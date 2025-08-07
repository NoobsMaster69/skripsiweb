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
        Schema::create('target_fakuls', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_akademik');
            $table->string('program_studi');
            $table->string('mata_kuliah');
            $table->string('target_pencapaian');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_fakuls');
    }
};
