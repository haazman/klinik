<?php

require 'bootstrap/app.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$schedules = App\Models\DoctorSchedule::with('doctor')->get();

foreach ($schedules as $schedule) {
    echo "Doctor: " . $schedule->doctor->nama_lengkap . "\n";
    echo "Date: " . $schedule->tanggal . "\n";
    echo "Time: " . $schedule->jam_mulai . "-" . $schedule->jam_selesai . "\n";
    echo "Status: " . $schedule->status . "\n";
    echo "Doctor ID: " . $schedule->doctor_id . "\n";
    echo "---\n";
}
