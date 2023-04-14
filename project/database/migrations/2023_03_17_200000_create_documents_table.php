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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('nom', 45);
            $table->date('dernière_date_modification');
            $table->bigInteger('taille_document');
            $table->integer('version');
            $table->tinyInteger('documen_prive');
            $table->string('approuvé_par', 45);
            $table->unsignedBigInteger('type_documents_id');
            $table->foreign('type_documents_id')->references('id')->on('type_documents')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('categorie_id');
            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
