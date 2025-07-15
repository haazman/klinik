<?php

namespace Database\Seeders;

use App\Models\Obat;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obats = [
            [
                'nama_obat' => 'Paracetamol 500mg',
                'jenis' => 'Tablet',
                'satuan' => 'pcs',
                'stok' => 100,
                'stok_minimum' => 10,
                'harga' => 2500.00,
                'deskripsi' => 'Obat penurun demam dan pereda nyeri',
            ],
            [
                'nama_obat' => 'Amoxicillin 500mg',
                'jenis' => 'Kapsul',
                'satuan' => 'pcs',
                'stok' => 50,
                'stok_minimum' => 10,
                'harga' => 5000.00,
                'deskripsi' => 'Antibiotik untuk infeksi bakteri',
            ],
            [
                'nama_obat' => 'CTM 4mg',
                'jenis' => 'Tablet',
                'satuan' => 'pcs',
                'stok' => 75,
                'stok_minimum' => 10,
                'harga' => 1500.00,
                'deskripsi' => 'Antihistamin untuk alergi',
            ],
            [
                'nama_obat' => 'Asam Folat 5mg',
                'jenis' => 'Tablet',
                'satuan' => 'pcs',
                'stok' => 80,
                'stok_minimum' => 10,
                'harga' => 3000.00,
                'deskripsi' => 'Suplemen asam folat untuk ibu hamil',
            ],
            [
                'nama_obat' => 'Vitamin B Complex',
                'jenis' => 'Tablet',
                'satuan' => 'pcs',
                'stok' => 60,
                'stok_minimum' => 10,
                'harga' => 4000.00,
                'deskripsi' => 'Suplemen vitamin B kompleks',
            ],
            [
                'nama_obat' => 'Ibuprofen 400mg',
                'jenis' => 'Tablet',
                'satuan' => 'pcs',
                'stok' => 15, // Low stock untuk testing alert
                'stok_minimum' => 20,
                'harga' => 3500.00,
                'deskripsi' => 'Anti-inflamasi dan pereda nyeri',
            ],
            [
                'nama_obat' => 'Antasida',
                'jenis' => 'Sirup',
                'satuan' => 'botol',
                'stok' => 30,
                'stok_minimum' => 10,
                'harga' => 8000.00,
                'deskripsi' => 'Obat sakit maag',
            ],
            [
                'nama_obat' => 'Salbutamol Inhaler',
                'jenis' => 'Inhaler',
                'satuan' => 'pcs',
                'stok' => 10, // Low stock
                'stok_minimum' => 15,
                'harga' => 45000.00,
                'deskripsi' => 'Obat asma bronkodilator',
            ],
        ];

        foreach ($obats as $obat) {
            Obat::create($obat);
        }

        echo "Sample medicines created successfully!\n";
    }
}
