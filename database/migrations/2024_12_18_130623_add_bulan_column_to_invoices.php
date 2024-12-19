<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Menambahkan kolom 'bulan' dengan tipe string
            $table->string('bulan')->nullable()->after('due_date');
        });

        // Update data lama dengan format 'Y-m-d' berdasarkan created_at
        DB::table('invoices')->update([
            'bulan' => DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')") // Menggunakan format Y-m-d
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Hapus kolom 'bulan' jika rollback
            $table->dropColumn('bulan');
        });
    }
};