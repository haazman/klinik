<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\DoctorSchedule;
use App\Models\Doctor;

// Add a schedule for today for testing
$doctor = Doctor::first();
if ($doctor) {
    DoctorSchedule::updateOrCreate([
        'doctor_id' => $doctor->id,
        'tanggal' => today(),
    ], [
        'jam_mulai' => '09:00',
        'jam_selesai' => '17:00',
        'status' => 'tersedia',
        'kuota' => 10,
        'catatan' => 'Jadwal hari ini untuk testing'
    ]);
    
    echo "Schedule created for doctor ID: " . $doctor->id . " on " . today() . "\n";
} else {
    echo "No doctors found\n";
}
