<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'spesialis',
        'pengalaman',
        'no_sip',
        'alamat_praktik', 
        'no_telepon',
    ];

    // Accessor untuk compatibility dengan views
    public function getNameAttribute()
    {
        return $this->nama_lengkap;
    }

    public function getSpesialisasiAttribute()
    {
        return $this->spesialis;
    }

    // Default values untuk field yang tidak ada di database tapi dipakai di views
    public function getNoSipAttribute()
    {
        return null; // Field tidak ada di database
    }

    public function getAlamatPraktikAttribute()
    {
        return null; // Field tidak ada di database
    }

    public function getTeleponAttribute()
    {
        return $this->user->email ?? null; // Fallback ke email user
    }

    public function getPengalamanAttribute()
    {
        return 5; // Default pengalaman untuk display
    }

    // Mutator untuk compatibility
    public function setNameAttribute($value)
    {
        $this->attributes['nama_lengkap'] = $value;
    }

    public function setSpesialisasiAttribute($value)
    {
        $this->attributes['spesialis'] = $value;
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }
}
