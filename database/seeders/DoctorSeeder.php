<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Doctor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create doctor user
        $doctorUser = User::create([
            'name' => 'Dr. Ahmad Suryanto',
            'email' => 'dokter@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
        ]);

        // Create doctor profile
        Doctor::create([
            'user_id' => $doctorUser->id,
            'nama_lengkap' => 'Dr. Ahmad Suryanto, Sp.PD',
            'spesialis' => 'Penyakit Dalam',
        ]);

        // Create another doctor
        $doctorUser2 = User::create([
            'name' => 'Dr. Sari Wijaya',
            'email' => 'dokter2@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
        ]);

        Doctor::create([
            'user_id' => $doctorUser2->id,
            'nama_lengkap' => 'Dr. Sari Wijaya, Sp.OG',
            'spesialis' => 'Obstetri & Ginekologi',
        ]);
    }
}
