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
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user'); // Nilai default: user biasa
            $table->string('username')->nullable(); // Hanya untuk admin/super admin
            $table->dropUnique(['email']); // Hilangkan batasan unik untuk email
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('username');
            $table->unique('email'); // Kembalikan batasan unik untuk email
        });
    }
};
