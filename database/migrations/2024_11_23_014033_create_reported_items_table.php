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
        Schema::create('reported_items', function (Blueprint $table) {
            $table->id();
            $table->string('barcode')->unique();
            $table->string('status');
            $table->string('details')->nullable();
            $table->integer('item_id');
            $table->integer('reporter_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reported_items');
    }
};
