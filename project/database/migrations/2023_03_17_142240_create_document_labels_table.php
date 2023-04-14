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
        Schema::create('document_labels', function (Blueprint $table) {
            $table->unsignedBigInteger('documents_id');
            $table->foreign('documents_id')->references('id')->on('documents')->onDelete('cascade')->onUpdate('cascade');

            $table->unsignedBigInteger('labels_id');
            $table->foreign('labels_id')->references('id')->on('labels')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_labels');
    }
};
