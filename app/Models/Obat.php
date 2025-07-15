<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_obat',
        'jenis',
        'satuan',
        'stok',
        'harga',
        'stok_minimum',
        'deskripsi',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    // Relationships
    public function obatMasuks()
    {
        return $this->hasMany(ObatMasuk::class);
    }

    public function visits()
    {
        return $this->belongsToMany(Visit::class, 'obat_visits')
                    ->withPivot('jumlah', 'harga_satuan', 'subtotal', 'aturan_pakai')
                    ->withTimestamps();
    }

    public function obatVisits()
    {
        return $this->hasMany(ObatVisit::class);
    }

    // Scope untuk obat dengan stok rendah
    public function scopeLowStock($query, $threshold = 20)
    {
        return $query->where('stok', '<', $threshold);
    }

    // Method untuk mengecek apakah stok rendah
    public function isLowStock()
    {
        return $this->stok <= $this->stok_minimum;
    }

    // Method untuk mendapatkan persentase stok
    public function getStockPercentage()
    {
        $idealStock = max($this->stok_minimum * 2, 1);
        return min(($this->stok / $idealStock) * 100, 100);
    }

    // Method untuk mendapatkan status stok
    public function getStockStatus()
    {
        if ($this->isLowStock()) {
            return 'low';
        } elseif ($this->stok <= $this->stok_minimum * 1.5) {
            return 'medium';
        } else {
            return 'good';
        }
    }

    // Accessor untuk compatibility dengan views yang menggunakan 'nama'
    public function getNamaAttribute()
    {
        return $this->nama_obat;
    }

    // Mutator untuk compatibility
    public function setNamaAttribute($value)
    {
        $this->attributes['nama_obat'] = $value;
    }
}
