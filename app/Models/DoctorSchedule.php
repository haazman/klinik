<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $fillable = [
        'doctor_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Accessor untuk compatibility dengan views
    public function getIsAvailableAttribute()
    {
        return $this->status === 'tersedia';
    }

    public function getKeteranganAttribute()
    {
        return null; // Field tidak ada di database
    }

    // Mutator untuk compatibility
    public function setIsAvailableAttribute($value)
    {
        $this->attributes['status'] = $value ? 'tersedia' : 'tidak_tersedia';
    }

    // Relationships
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function konsultasis()
    {
        return $this->hasMany(Konsultasi::class, 'jadwal_id');
    }

    // Scope for available schedules
    public function scopeAvailable($query)
    {
        return $query->where('status', 'tersedia');
    }

    // Scope for future schedules
    public function scopeFuture($query)
    {
        return $query->where('tanggal', '>=', now()->toDateString());
    }
}
