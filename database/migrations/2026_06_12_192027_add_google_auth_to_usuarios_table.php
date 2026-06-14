<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('google_id', 255)->nullable()->unique()->after('correo');
            $table->text('avatar')->nullable()->after('google_id');
            $table->string('password')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropColumn(['google_id', 'avatar']);
            $table->string('password')->change();
        });
    }
};
