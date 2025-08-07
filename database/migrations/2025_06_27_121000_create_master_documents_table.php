<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterDocumentsTable extends Migration
{
    public function up()
    {
        Schema::create('master_documents', function (Blueprint $table) {
            $table->id();
            $table->string('nomor')->unique();
            $table->string('nama');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_documents');
    }
}
