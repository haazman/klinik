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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['menunggu', 'sedang_diperiksa', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->date('tanggal_kunjungan');
            $table->time('jam_kunjungan')->nullable();
            $table->text('keluhan_utama');
            $table->text('hasil_pemeriksaan');
            $table->text('diagnosis');
            $table->text('tindakan');
            $table->decimal('biaya_konsultasi', 12, 2);
            $table->text('saran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
