<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nik',
        'alamat',
        'no_telepon',
        'email',
        'tanggal_lahir',
        'jenis_kelamin',
        'golongan_darah',
        'status_pernikahan',
        'pekerjaan',
        'riwayat_penyakit',
        'alergi',
    ];

    // Accessor untuk compatibility dengan views
    public function getNameAttribute()
    {
        return $this->nama_lengkap;
    }

    public function getTeleponAttribute()
    {
        return $this->no_telepon;
    }

    // Mutator untuk compatibility
    public function setNameAttribute($value)
    {
        $this->attributes['nama_lengkap'] = $value;
    }

    public function setTeleponAttribute($value)
    {
        $this->attributes['no_telepon'] = $value;
    }

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function konsultasis()
    {
        return $this->hasMany(Konsultasi::class);
    }
}
