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
        Schema::create('loaned_items', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('barcode');
            $table->date('date_loaned');
            $table->date('due_date');
            $table->integer('loaner_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loaned_items');
    }
};
