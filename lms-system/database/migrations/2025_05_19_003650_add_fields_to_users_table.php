<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('student_staff_number')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('language_preference')->default('id'); // Default Indonesian
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['student_staff_number', 'profile_photo', 'language_preference']);
        });
    }
};