<?php

namespace Database\Seeders;

use App\Models\Konsultasi;
use App\Models\Patient;
use App\Models\DoctorSchedule;
use Illuminate\Database\Seeder;

class KonsultasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // First, create some doctor schedules
        $schedules = DoctorSchedule::create([
            'doctor_id' => 1, // Assuming doctor with ID 1 exists
            'tanggal' => now()->addDays(1)->format('Y-m-d'),
            'jam_mulai' => '09:00',
            'jam_selesai' => '12:00',
            'status' => 'tersedia',
        ]);

        DoctorSchedule::create([
            'doctor_id' => 1,
            'tanggal' => now()->addDays(2)->format('Y-m-d'),
            'jam_mulai' => '14:00',
            'jam_selesai' => '17:00',
            'status' => 'tersedia',
        ]);

        // Create consultations
        Konsultasi::create([
            'patient_id' => 1, // Assuming patient with ID 1 exists
            'status' => 'menunggu',
            'jadwal_id' => 1,
            'keluhan' => 'Demam dan batuk sudah 3 hari, disertai dengan nyeri tenggorokan.',
        ]);

        Konsultasi::create([
            'patient_id' => 2, // Assuming patient with ID 2 exists
            'status' => 'menunggu',
            'jadwal_id' => 2,
            'keluhan' => 'Sakit kepala yang tidak kunjung hilang, terutama di pagi hari.',
        ]);

        Konsultasi::create([
            'patient_id' => 1,
            'status' => 'selesai',
            'jadwal_id' => null, // Past consultation without specific schedule
            'keluhan' => 'Kontrol rutin tekanan darah.',
        ]);
    }
}
