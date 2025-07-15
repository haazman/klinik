<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'status',
        'jadwal_id',
        'keluhan',
    ];

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(DoctorSchedule::class, 'jadwal_id');
    }

    // Scopes
    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    public function scopeDibatalkan($query)
    {
        return $query->where('status', 'dibatalkan');
    }

    // Status constants
    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DIBATALKAN = 'dibatalkan';
}
