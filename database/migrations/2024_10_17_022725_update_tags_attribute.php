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
        Schema::table('books', function (Blueprint $table) {
            $table->string('tags')->nullable()->change();
        });
        Schema::table('researches', function (Blueprint $table) {
            $table->string('tags')->nullable()->change();
        });
        Schema::table('media_discs', function (Blueprint $table) {
            $table->string('tags')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->json('tags')->nullable()->change();
        });
        Schema::table('researches', function (Blueprint $table) {
            $table->json('tags')->nullable()->change();
        });
        Schema::table('media_discs', function (Blueprint $table) {
            $table->json('tags')->nullable()->change();
        });
    }
};
