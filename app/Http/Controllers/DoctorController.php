<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Visit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    // Doctor Dashboard
    public function dashboard()
    {
        $doctor = Auth::user()->doctor;
        
        if (!$doctor) {
            return redirect()->route('login')->with('error', 'Doctor profile not found.');
        }

        $stats = [
            'total_patients' => Visit::where('doctor_id', $doctor->id)->distinct('patient_id')->count(),
            'pending_visits' => Visit::where('doctor_id', $doctor->id)->where('status', 'menunggu')->count(),
            'completed_visits' => Visit::where('doctor_id', $doctor->id)->where('status', 'selesai')->count(),
            'today_schedules' => DoctorSchedule::where('doctor_id', $doctor->id)
                ->where('tanggal', today())
                ->where('status', 'tersedia')
                ->count(),
        ];

        $todayVisits = Visit::with(['patient.user'])
            ->where('doctor_id', $doctor->id)
            ->where('tanggal_kunjungan', today())
            ->orderBy('jam_kunjungan')
            ->get();

        $upcomingSchedules = DoctorSchedule::where('doctor_id', $doctor->id)
            ->where('tanggal', '>=', today())
            ->where('status', 'tersedia')
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->take(5)
            ->get();

        return view('doctor.dashboard', compact('stats', 'todayVisits', 'upcomingSchedules', 'doctor'));
    }

    // Schedule Management
    public function schedules()
    {
        $doctor = Auth::user()->doctor;
        $schedules = DoctorSchedule::where('doctor_id', $doctor->id)
            ->orderBy('tanggal', 'desc')
            ->orderBy('jam_mulai')
            ->paginate(15);

        return view('doctor.schedules.index', compact('schedules'));
    }

    public function createSchedule()
    {
        return view('doctor.schedules.create');
    }

    public function storeSchedule(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $doctor = Auth::user()->doctor;

        // Check if schedule already exists for this date and time
        $existingSchedule = DoctorSchedule::where('doctor_id', $doctor->id)
            ->where('tanggal', $request->tanggal)
            ->where(function($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                      ->orWhere(function($q) use ($request) {
                          $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                      });
            })
            ->exists();

        if ($existingSchedule) {
            return back()->withErrors(['error' => 'Jadwal sudah ada pada tanggal dan waktu tersebut.']);
        }

        DoctorSchedule::create([
            'doctor_id' => $doctor->id,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => 'tersedia',
        ]);

        return redirect()->route('doctor.schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function updateSchedule(Request $request, DoctorSchedule $schedule)
    {
        $request->validate([
            'status' => 'required|in:tersedia,tidak_tersedia',
        ]);

        $schedule->update($request->only(['status']));

        return back()->with('success', 'Jadwal berhasil diupdate.');
    }

    public function deleteSchedule(DoctorSchedule $schedule)
    {
        $schedule->delete();
        return back()->with('success', 'Jadwal berhasil dihapus.');
    }

    // Available schedules for patients to see
    public function availableSchedules()
    {
        $schedules = DoctorSchedule::with('doctor.user')
            ->where('tanggal', '>=', today())
            ->where('status', 'tersedia')
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('tanggal');

        return view('patient.schedules.available', compact('schedules'));
    }

    // For Admin - Doctor CRUD
    public function index()
    {
        $doctors = Doctor::with('user')->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nama_lengkap' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'pengalaman' => 'required|integer|min:0|max:50',
            'no_sip' => 'nullable|string|max:50',
            'alamat_praktik' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'dokter',
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'nama_lengkap' => $request->nama_lengkap,
            'spesialis' => $request->spesialis,
            'pengalaman' => $request->pengalaman,
            'no_sip' => $request->no_sip,
            'alamat_praktik' => $request->alamat_praktik,
            'no_telepon' => $request->no_telepon,
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Dokter berhasil ditambahkan.');
    }

    public function show(Doctor $doctor)
    {
        $doctor->load(['user', 'visits.patient.user', 'schedules']);
        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'spesialis' => 'required|string|max:255',
            'pengalaman' => 'required|integer|min:0|max:50',
            'no_sip' => 'nullable|string|max:255',
            'alamat_praktik' => 'nullable|string',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        $doctor->update($request->all());

        return redirect()->route('admin.doctors.index')->with('success', 'Data dokter berhasil diupdate.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->user->delete(); // This will cascade delete doctor
        return redirect()->route('admin.doctors.index')->with('success', 'Dokter berhasil dihapus.');
    }
}
