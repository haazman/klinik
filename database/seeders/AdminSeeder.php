<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Create sample doctor
        $doctorUser = User::create([
            'name' => 'Dr. Yulis Setiawan',
            'email' => 'doctor@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'dokter',
            'email_verified_at' => now(),
        ]);

        \App\Models\Doctor::create([
            'user_id' => $doctorUser->id,
            'nama_lengkap' => 'Dr. Yulis Setiawan, SpOG',
            'spesialis' => 'Kebidanan dan Kandungan',
        ]);

        // Create sample patient
        $patientUser = User::create([
            'name' => 'Patient Sample',
            'email' => 'patient@klinik.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
            'email_verified_at' => now(),
        ]);

        \App\Models\Patient::create([
            'user_id' => $patientUser->id,
            'nama_lengkap' => 'Siti Nurhaliza',
            'alamat' => 'Jl. Mawar No. 456, Jakarta',
            'no_telepon' => '08123456780',
        ]);

        echo "Admin, Doctor, and Patient users created successfully!\n";
        echo "Admin: admin@klinik.com / password\n";
        echo "Doctor: doctor@klinik.com / password\n";
        echo "Patient: patient@klinik.com / password\n";
    }
}
