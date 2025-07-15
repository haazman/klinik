<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Console\Command;

class CreateMissingPatientRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patients:create-missing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create missing patient records for users with role pasien';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating missing patient records...');

        $patientsWithoutRecords = User::where('role', 'pasien')
            ->whereDoesntHave('patient')
            ->get();

        $count = 0;
        foreach ($patientsWithoutRecords as $user) {
            Patient::create([
                'user_id' => $user->id,
                'nama_lengkap' => $user->name,
                'alamat' => '',
                'no_telepon' => '',
            ]);
            $count++;
        }

        $this->info("Created {$count} patient records.");
        return 0;
    }
}
