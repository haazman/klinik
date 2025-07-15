<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObatVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'obat_id',
        'jumlah',
    ];

    // Accessor untuk field yang mungkin tidak ada
    public function getHargaSatuanAttribute()
    {
        return $this->obat->harga ?? 0;
    }

    public function getSubtotalAttribute()
    {
        return $this->jumlah * $this->harga_satuan;
    }

    // Relationships
    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}
