<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->string('card_number')->unique();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('suffix')->nullable();
            $table->string('gender');
            $table->string('birthday');
            $table->string('email')->unique();
            $table->string('mobile_number')->nullable();
            $table->string('barangay')->nullable();
            $table->string('municipality')->nullable();
            $table->string('province')->nullable();
            $table->string('profile')->nullable();
            $table->string('library')->nullable();
            $table->string('status');
            $table->string('role');
            $table->string('college')->nullable();
            $table->string('campus')->nullable();
            $table->string('academic_rank')->nullable();
            $table->string('program')->nullable();
            $table->integer('year')->nullable();
            $table->string('section')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
