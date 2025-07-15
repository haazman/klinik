<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create patient user
        $patientUser = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
        ]);

        // Create patient profile
        Patient::create([
            'user_id' => $patientUser->id,
            'nama_lengkap' => 'Budi Santoso',
            'alamat' => 'Jl. Merdeka No. 123, Jakarta',
            'no_telepon' => '081234567890',
        ]);

        // Create another patient
        $patientUser2 = User::create([
            'name' => 'Siti Rahayu',
            'email' => 'siti@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
        ]);

        Patient::create([
            'user_id' => $patientUser2->id,
            'nama_lengkap' => 'Siti Rahayu',
            'alamat' => 'Jl. Kemanggisan No. 45, Jakarta',
            'no_telepon' => '082345678901',
        ]);
    }
}
