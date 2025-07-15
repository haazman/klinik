<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObatMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'obat_id',
        'jumlah',
        'supplier',
        'kontak_supplier',
        'tanggal_masuk',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
    ];

    // Relationships
    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
