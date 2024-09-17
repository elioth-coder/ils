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
        Schema::table('campuses', function (Blueprint $table) {
            $table->string('code')->unique()->after('id');
        });
        Schema::table('libraries', function (Blueprint $table) {
            $table->string('code')->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('campuses', function (Blueprint $table) {
            $table->dropColumn('code');
        });
        Schema::table('libraries', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
