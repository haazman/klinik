<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Visit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    // Patient Dashboard
    public function dashboard()
    {
        $patient = Auth::user()->patient;
        
        // Create patient record if it doesn't exist (for existing users)
        if (!$patient) {
            $patient = Patient::create([
                'user_id' => Auth::id(),
                'nama_lengkap' => Auth::user()->name,
                'alamat' => '',
                'no_telepon' => '',
            ]);
        }

        $stats = [
            'total_visits' => $patient->visits->count(),
            'pending_visits' => $patient->visits->where('status', 'menunggu')->count(),
            'completed_visits' => $patient->visits->where('status', 'selesai')->count(),
        ];

        $recentVisits = $patient->visits()
            ->with('doctor.user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Check if profile is incomplete
        $isProfileIncomplete = empty($patient->alamat) || empty($patient->no_telepon);

        return view('patient.dashboard', compact('stats', 'recentVisits', 'patient', 'isProfileIncomplete'));
    }

    // Patient Profile Management
    public function profile()
    {
        $patient = Auth::user()->patient;
        
        // Create patient record if it doesn't exist
        if (!$patient) {
            $patient = Patient::create([
                'user_id' => Auth::id(),
                'nama_lengkap' => Auth::user()->name,
                'alamat' => '',
                'no_telepon' => '',
            ]);
        }

        return view('patient.profile', compact('patient'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'nullable|string|max:16',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
            'status_pernikahan' => 'nullable|in:belum_menikah,menikah,cerai',
            'pekerjaan' => 'nullable|string|max:255',
            'riwayat_penyakit' => 'nullable|string',
            'alergi' => 'nullable|string',
        ]);

        $patient = Auth::user()->patient;
        
        if (!$patient) {
            $patient = Patient::create([
                'user_id' => Auth::id(),
                'nama_lengkap' => $request->nama_lengkap,
                'alamat' => $request->alamat,
                'no_telepon' => $request->no_telepon,
            ]);
        } else {
            $patient->update($request->only([
                'nama_lengkap', 'nik', 'alamat', 'no_telepon', 
                'tanggal_lahir', 'jenis_kelamin', 'golongan_darah', 
                'status_pernikahan', 'pekerjaan', 'riwayat_penyakit', 'alergi'
            ]));
        }

        // Also update user name if changed
        $user = Auth::user();
        if ($user->name !== $request->nama_lengkap) {
            User::where('id', $user->id)->update(['name' => $request->nama_lengkap]);
        }

        return redirect()->route('patient.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    // For Doctor to view patients
    public function doctorIndex()
    {
        $patients = Patient::with(['user', 'visits' => function($query) {
            $query->where('doctor_id', Auth::user()->doctor->id);
        }])->paginate(10);

        return view('doctor.patients.index', compact('patients'));
    }

    public function doctorShow(Patient $patient)
    {
        // Check if doctor has treated this patient
        $doctor = Auth::user()->doctor;
        $hasVisits = Visit::where('doctor_id', $doctor->id)
                          ->where('patient_id', $patient->id)
                          ->exists();
        
        if (!$hasVisits) {
            abort(403, 'Anda tidak memiliki akses untuk melihat data pasien ini.');
        }

        $patient->load(['user']);
        $visits = Visit::with(['obatVisits.obat'])
                      ->where('doctor_id', $doctor->id)
                      ->where('patient_id', $patient->id)
                      ->orderBy('tanggal_kunjungan', 'desc')
                      ->paginate(10);

        return view('doctor.patients.show', compact('patient', 'visits'));
    }

    // For Admin - CRUD operations
    public function index()
    {
        $patients = Patient::with('user')->paginate(10);
        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'pekerjaan' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pasien',
        ]);

        Patient::create([
            'user_id' => $user->id,
            'nama_lengkap' => $request->nama_lengkap,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'pekerjaan' => $request->pekerjaan,
        ]);

        return redirect()->route('admin.patients.index')->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function show(Patient $patient)
    {
        $patient->load(['user', 'visits.doctor.user', 'visits.obats']);
        return view('admin.patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'nullable|string|max:16',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:L,P',
            'golongan_darah' => 'nullable|in:A,B,AB,O',
            'status_pernikahan' => 'nullable|in:belum_menikah,menikah,cerai',
            'pekerjaan' => 'nullable|string|max:255',
            'riwayat_penyakit' => 'nullable|string',
            'alergi' => 'nullable|string',
        ]);

        $patient->update($request->only([
            'nama_lengkap', 'nik', 'alamat', 'no_telepon', 'email', 
            'tanggal_lahir', 'jenis_kelamin', 'golongan_darah', 
            'status_pernikahan', 'pekerjaan', 'riwayat_penyakit', 'alergi'
        ]));

        return redirect()->route('admin.patients.index')->with('success', 'Data pasien berhasil diupdate.');
    }

    public function destroy(Patient $patient)
    {
        $patient->user->delete(); // This will cascade delete patient
        return redirect()->route('admin.patients.index')->with('success', 'Pasien berhasil dihapus.');
    }
}