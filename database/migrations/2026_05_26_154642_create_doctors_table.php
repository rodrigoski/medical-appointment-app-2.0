<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('speciality_id')->nullable()->constrained('specialities')->nullOnDelete();
            $table->string('license_number', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->unsignedSmallInteger('years_of_experience')->nullable();
            $table->string('education', 255)->nullable();
            $table->string('certifications', 500)->nullable();
            $table->text('biography')->nullable();
            $table->string('consultation_room', 50)->nullable();
            $table->string('consultation_schedule', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
