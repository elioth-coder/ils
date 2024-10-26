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
        Schema::create('media_discs', function (Blueprint $table) {
            $table->id();
            $table->string('accession_number')->nullable()->unique();
            $table->string('barcode')->nullable()->unique();
            $table->string('lcc_number')->nullable();
            $table->string('ddc_number')->nullable();
            $table->string('ir_number');
            $table->string('title');
            $table->string('author')->nullable();
            $table->string('genre')->nullable();
            $table->integer('year_released')->nullable();
            $table->string('publisher')->nullable();
            $table->string('language')->nullable()->default('English');
            $table->string('cover_image')->nullable();
            $table->text('summary')->nullable();
            $table->integer('duration')->nullable();
            $table->string('location')->nullable();
            $table->json('tags')->nullable();
            $table->string('library')->nullable();
            $table->string('type');
            $table->string('status')->nullable()->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_discs');
    }
};
