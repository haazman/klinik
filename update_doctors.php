<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Update doctors with random experience
use Illuminate\Support\Facades\DB;
App\Models\Doctor::query()->update(['pengalaman' => DB::raw('FLOOR(RAND() * 15) + 1')]);

echo "Updated doctors with random experience values (1-15 years)\n";
