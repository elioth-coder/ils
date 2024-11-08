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
            $table->dropColumn('lcc_number');
            $table->dropColumn('ddc_number');
            $table->string('call_number')->after('barcode')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('call_number');
            $table->string('ddc_number')->after('barcode')->nullable();
            $table->string('lcc_number')->after('barcode')->nullable();
        });
    }
};
