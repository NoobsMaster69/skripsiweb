<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentSubmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('document_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_document_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamp('tanggal_upload')->useCurrent();
            $table->timestamp('tanggal_pengesahan')->nullable();
            $table->enum('status', ['pending','approved','rejected'])->default('pending');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('document_submissions');
    }
}
