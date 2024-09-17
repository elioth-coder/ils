<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('accession_number')->nullable()->unique();
            $table->string('barcode_number')->nullable()->unique();
            $table->string('lcc_number')->nullable();
            $table->string('ddc_number')->nullable();
            $table->string('title');
            $table->string('author');
            $table->string('isbn');
            $table->string('publisher');
            $table->integer('publication_year');
            $table->string('language')->nullable()->default('English');
            $table->string('genre')->nullable();
            $table->integer('number_of_pages')->nullable();
            $table->string('format')->nullable();
            $table->string('cover_image')->nullable();
            $table->text('summary')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->string('location')->nullable();
            $table->json('tags')->nullable();
            $table->string('status')->nullable()->default('available');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
};
