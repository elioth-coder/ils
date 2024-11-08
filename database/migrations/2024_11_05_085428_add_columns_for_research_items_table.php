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
        Schema::table('items', function (Blueprint $table) {
            $table->string('isbn')->nullable()->change();
            $table->string('advisor')->after('author')->nullable();
            $table->string('doi')->after('isbn')->nullable();
            $table->string('degree')->after('library')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('advisor');
            $table->dropColumn('doi');
            $table->dropColumn('degree');
        });
    }
};
