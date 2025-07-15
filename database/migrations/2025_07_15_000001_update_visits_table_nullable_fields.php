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
            // Ubah field yang required menjadi nullable karena saat buat appointment belum ada data ini
            $table->text('hasil_pemeriksaan')->nullable()->change();
            $table->text('diagnosis')->nullable()->change();
            $table->text('tindakan')->nullable()->change();
            $table->decimal('biaya_konsultasi', 12, 2)->nullable()->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->text('hasil_pemeriksaan')->nullable(false)->change();
            $table->text('diagnosis')->nullable(false)->change();
            $table->text('tindakan')->nullable(false)->change();
            $table->decimal('biaya_konsultasi', 12, 2)->nullable(false)->change();
        });
    }
};
