<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Añadimos los campos que faltan
            $table->string('id_number')->nullable()->after('email');
            $table->string('phone')->nullable()->after('id_number');
            $table->text('address')->nullable()->after('phone');

            // Esta es la línea que repara tu error de SQL
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['id_number', 'phone', 'address', 'deleted_at']);
        });
    }
};
