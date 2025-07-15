<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\Patient;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonsultasiController extends Controller
{
    // Display all consultations (for admin)
    public function index()
    {
        $konsultasis = Konsultasi::with(['patient.user', 'jadwal.doctor.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.konsultasi.index', compact('konsultasis'));
    }

    // Show single consultation
    public function show(Konsultasi $konsultasi)
    {
        $konsultasi->load(['patient.user', 'jadwal.doctor.user']);
        return view('admin.konsultasi.show', compact('konsultasi'));
    }

    // Patient - view their consultations
    public function patientIndex()
    {
        $patient = Auth::user()->patient;
        
        if (!$patient) {
            return redirect()->route('patient.profile')->with('info', 'Lengkapi data profil terlebih dahulu.');
        }

        $konsultasis = $patient->konsultasis()
            ->with(['jadwal.doctor.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('patient.konsultasi.index', compact('konsultasis'));
    }

    // Patient - create new consultation request
    public function create()
    {
        $patient = Auth::user()->patient;
        
        if (!$patient) {
            return redirect()->route('patient.profile')->with('info', 'Lengkapi data profil terlebih dahulu.');
        }

        $availableSchedules = DoctorSchedule::with('doctor.user')
            ->where('tanggal', '>=', today())
            ->where('status', 'tersedia')
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('tanggal');

        return view('patient.konsultasi.create', compact('availableSchedules'));
    }

    // Store new consultation request
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:schedules,id',
            'keluhan' => 'required|string|max:1000',
        ]);

        $patient = Auth::user()->patient;
        
        // Check if patient already has a pending consultation for the same schedule
        $existingKonsultasi = Konsultasi::where('patient_id', $patient->id)
            ->where('jadwal_id', $request->jadwal_id)
            ->where('status', 'menunggu')
            ->first();

        if ($existingKonsultasi) {
            return back()->withErrors(['error' => 'Anda sudah memiliki konsultasi yang menunggu untuk jadwal ini.']);
        }

        // Create consultation request
        Konsultasi::create([
            'patient_id' => $patient->id,
            'jadwal_id' => $request->jadwal_id,
            'keluhan' => $request->keluhan,
            'status' => 'menunggu',
        ]);

        return redirect()->route('patient.konsultasi.index')
            ->with('success', 'Permintaan konsultasi berhasil diajukan. Silakan tunggu konfirmasi.');
    }

    // Update consultation status (for admin/doctor)
    public function updateStatus(Request $request, Konsultasi $konsultasi)
    {
        $request->validate([
            'status' => 'required|in:menunggu,selesai,dibatalkan',
        ]);

        $konsultasi->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status konsultasi berhasil diupdate.');
    }

    // Cancel consultation (for patient)
    public function cancel(Konsultasi $konsultasi)
    {
        // Ensure the consultation belongs to the current patient
        if ($konsultasi->patient_id !== Auth::user()->patient->id) {
            abort(403);
        }

        // Only allow cancellation of pending consultations
        if ($konsultasi->status !== 'menunggu') {
            return back()->withErrors(['error' => 'Hanya konsultasi yang menunggu yang dapat dibatalkan.']);
        }

        $konsultasi->update(['status' => 'dibatalkan']);

        return back()->with('success', 'Konsultasi berhasil dibatalkan.');
    }
}
