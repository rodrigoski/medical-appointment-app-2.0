<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->text('allergies')->nullable()->change();
            $table->text('chronic_conditions')->nullable()->change();
            $table->text('surgical_history')->nullable()->change();
            $table->text('family_history')->nullable()->change();
            $table->text('observations')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->string('allergies')->nullable()->change();
            $table->string('chronic_conditions')->nullable()->change();
            $table->string('surgical_history')->nullable()->change();
            $table->string('family_history')->nullable()->change();
            $table->string('observations')->nullable()->change();
        });
    }
};
