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
        Schema::table('patients', function (Blueprint $table) {
            $table->string('nik')->nullable()->after('nama_lengkap');
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O'])->nullable()->after('jenis_kelamin');
            $table->enum('status_pernikahan', ['belum_menikah', 'menikah', 'cerai'])->nullable()->after('golongan_darah');
            $table->string('email')->nullable()->after('no_telepon');
            $table->text('riwayat_penyakit')->nullable()->after('pekerjaan');
            $table->text('alergi')->nullable()->after('riwayat_penyakit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'nik', 
                'golongan_darah', 
                'status_pernikahan', 
                'email', 
                'riwayat_penyakit', 
                'alergi'
            ]);
        });
    }
};
