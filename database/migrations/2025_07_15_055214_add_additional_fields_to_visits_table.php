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
        Schema::table('visits', function (Blueprint $table) {
            $table->text('riwayat_penyakit_kunjungan')->nullable()->after('keluhan_utama');
            $table->text('catatan')->nullable()->after('saran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn(['riwayat_penyakit_kunjungan', 'catatan']);
        });
    }
};
