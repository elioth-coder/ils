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
        Schema::table('teachers', function (Blueprint $table) {
            $table->renameColumn('employee_number', 'card_number');
        });
        Schema::table('students', function (Blueprint $table) {
            $table->renameColumn('student_number', 'card_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->renameColumn('card_number', 'employee_number');
        });
        Schema::table('students', function (Blueprint $table) {
            $table->renameColumn('card_number', 'student_number');
        });
    }
};
