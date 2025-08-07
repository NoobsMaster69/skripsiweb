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
        Schema::create('pl_fti', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pl');
            $table->text('profil_lulusan');
            $table->string('aspek');
            $table->string('profesi');
            $table->string('level_kkni');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pl_fti');
    }
};
