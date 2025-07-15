<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'status',
        'tanggal_kunjungan',
        'jam_kunjungan',
        'keluhan_utama',
        'riwayat_penyakit_kunjungan',
        'catatan',
        'hasil_pemeriksaan',
        'diagnosis',
        'tindakan',
        'biaya_konsultasi',
        'saran',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'datetime',
        'biaya_konsultasi' => 'decimal:2',
    ];

    // Accessor untuk compatibility dengan views
    public function getKeluhanAttribute()
    {
        return $this->keluhan_utama;
    }

    public function getDiagnosaAttribute()
    {
        return $this->diagnosis;
    }

    public function getCatatanDokterAttribute()
    {
        return $this->saran;
    }

    public function getCatatanAttribute()
    {
        return null; // Field tidak ada di database, return null
    }

    public function getRiwayatPenyakitAttribute()
    {
        return null; // Field tidak ada di database, return null
    }

    // Mutator untuk compatibility
    public function setKeluhanAttribute($value)
    {
        $this->attributes['keluhan_utama'] = $value;
    }

    public function setDiagnosaAttribute($value)
    {
        $this->attributes['diagnosis'] = $value;
    }

    public function setCatatanDokterAttribute($value)
    {
        $this->attributes['saran'] = $value;
    }

    // Relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function obats()
    {
        return $this->belongsToMany(Obat::class, 'obat_visits')
                    ->withPivot('jumlah')
                    ->withTimestamps();
    }

    public function obatVisits()
    {
        return $this->hasMany(ObatVisit::class);
    }

    // Scope for pending visits
    public function scopePending($query)
    {
        return $query->where('status', 'menunggu');
    }

    // Scope for ongoing visits 
    public function scopeOngoing($query)
    {
        return $query->where('status', 'sedang_diperiksa');
    }

    // Scope for completed visits
    public function scopeCompleted($query)
    {
        return $query->where('status', 'selesai');
    }

    // Scope for cancelled visits
    public function scopeCancelled($query)
    {
        return $query->where('status', 'dibatalkan');
    }

    // Status constants untuk consistency
    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_SEDANG_DIPERIKSA = 'sedang_diperiksa';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DIBATALKAN = 'dibatalkan';

    // Calculate total cost including medicines
    public function getTotalCostAttribute()
    {
        $medicineTotal = $this->obatVisits->map(function($obatVisit) {
            return $obatVisit->jumlah * $obatVisit->obat->harga;
        })->sum();
        return $this->biaya_konsultasi + $medicineTotal;
    }
}
