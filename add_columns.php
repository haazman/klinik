<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

try {
    Schema::table('obats', function (Blueprint $table) {
        if (!Schema::hasColumn('obats', 'satuan')) {
            $table->string('satuan')->after('jenis');
        }
        if (!Schema::hasColumn('obats', 'stok_minimum')) {
            $table->integer('stok_minimum')->default(10)->after('stok');
        }
    });
    echo "Columns added successfully\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
