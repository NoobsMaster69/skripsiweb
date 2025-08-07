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
        Schema::create('master_dokumens', function (Blueprint $table) {
            $table->id();
            $table->string('nomor', 50)->unique();
            $table->string('nama', 255);
            $table->string('file_path', 500);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('nomor');
            $table->index('nama');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_dokumens');
    }
};
