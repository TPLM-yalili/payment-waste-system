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
            $table->dropColumn('password');
            $table->dropColumn('username');
            $table->dropColumn('email_verified_at');
            $table->string('google_id')->nullable();
            $table->string('no_kk', 16)->nullable();
            $table->string('no_wa', 12)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('password');
            $table->string('username')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->dropColumn('google_id');
            $table->dropColumn('no_kk');
            $table->dropColumn('no_wa');
        });
    }
};
