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
        Schema::create('rata_ipk', function (Blueprint $table) {
            $table->id();
            $table->string('nim', 20)->unique();
            $table->string('nama', 100);
            $table->string('prodi', 100);
            $table->string('tahun_lulus', 10);
            $table->date('tanggal_lulus');
            $table->decimal('ipk', 3, 2); // Format: 3.XX
            $table->enum('predikat', [
                'Cum Laude',
                'Sangat Memuaskan',
                'Memuaskan',
                'Cukup'
            ]);
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->timestamps();

            // Indexes untuk performa query
            $table->index('tahun_lulus');
            $table->index('prodi');
            $table->index(['tahun_lulus', 'prodi']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rata_ipk');
    }
};
