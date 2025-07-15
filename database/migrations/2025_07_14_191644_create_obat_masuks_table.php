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
        Schema::create('obat_masuks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('obat_id')->constrained()->onDelete('cascade');
            $table->integer('jumlah');
            $table->string('supplier');
            $table->string('kontak_supplier')->nullable();
            $table->date('tanggal_masuk');
            $table->decimal('harga_beli', 10, 2)->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat_masuks');
    }
};
