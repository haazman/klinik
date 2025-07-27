<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use App\Models\Obat;
use App\Models\ObatVisit;
use App\Models\ObatMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VisitController extends Controller
{
    // Admin - View all visits
    public function adminIndex()
    {
        $visits = Visit::with(['patient.user', 'doctor.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.visits.index', compact('visits'));
    }

    // Doctor - View visits assigned to them
    public function doctorIndex()
    {
        $doctor = Auth::user()->doctor;
        $visits = Visit::with(['patient.user'])
            ->where('doctor_id', $doctor->id)
            ->orderBy('tanggal_kunjungan', 'desc')
            ->orderBy('jam_kunjungan', 'desc')
            ->paginate(15);

        // Calculate stats for doctor visits
        $stats = [
            'today' => $doctor->visits()->whereDate('tanggal_kunjungan', today())->count(),
            'waiting' => $doctor->visits()->where('status', 'menunggu')->count(),
            'ongoing' => $doctor->visits()->where('status', 'berlangsung')->count(),
            'completed' => $doctor->visits()->where('status', 'selesai')->count(),
        ];

        // Get next upcoming visit
        $nextVisit = Visit::with(['patient.user'])
            ->where('doctor_id', $doctor->id)
            ->where('status', 'menunggu')
            ->where('tanggal_kunjungan', '>=', today())
            ->orderBy('tanggal_kunjungan', 'asc')
            ->orderBy('jam_kunjungan', 'asc')
            ->first();

        return view('doctor.visits.index', compact('visits', 'stats', 'nextVisit'));
    }

    // Patient - View their own visits
    public function patientIndex()
    {
        $patient = Auth::user()->patient;

        if (!$patient) {
            return redirect()->route('patient.profile')->with('info', 'Lengkapi data profil terlebih dahulu.');
        }

        $visits = $patient->visits()
            ->with(['doctor.user', 'obats'])
            ->orderBy('tanggal_kunjungan', 'desc')
            ->paginate(10);

        // Get doctors for filter dropdown
        $doctors = Doctor::with('user')->get();

        // Calculate stats for patient visits
        $stats = [
            'total' => $patient->visits->count(),
            'waiting' => $patient->visits->where('status', 'menunggu')->count(),
            'ongoing' => $patient->visits->where('status', 'berlangsung')->count(),
            'completed' => $patient->visits->where('status', 'selesai')->count(),
        ];

        return view('patient.visits.index', compact('visits', 'doctors', 'stats'));
    }

    // Patient - Create new visit request
    public function create(Request $request)
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

        // Get doctors for dropdown
        $doctors = Doctor::with('user')->get();

        // Pre-select doctor and date if provided
        $selectedDoctorId = $request->get('doctor_id');
        $selectedDate = $request->get('date');

        return view('patient.visits.create', compact('availableSchedules', 'doctors', 'selectedDoctorId', 'selectedDate'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'jam_kunjungan' => 'required|date_format:H:i',
            'keluhan' => 'required|string',
            'riwayat_penyakit_kunjungan' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $patient = Auth::user()->patient;

        // Check if doctor is available at requested time
        $schedule = DoctorSchedule::where('doctor_id', $request->doctor_id)
            ->where('tanggal', $request->tanggal_kunjungan)
            ->where('jam_mulai', '<=', $request->jam_kunjungan)
            ->where('jam_selesai', '>=', $request->jam_kunjungan)
            ->where('status', 'tersedia')
            ->first();

        if (!$schedule) {
            return back()->withErrors(['error' => 'Dokter tidak tersedia pada waktu yang dipilih.']);
        }

        // Check if patient already has visit on same date
        $existingVisit = Visit::where('patient_id', $patient->id)
            ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
            ->where('status', '!=', 'batal')
            ->exists();

        if ($existingVisit) {
            return back()->withErrors(['error' => 'Anda sudah memiliki jadwal kunjungan pada tanggal tersebut.']);
        }

        Visit::create([
            'patient_id' => $patient->id,
            'doctor_id' => $request->doctor_id,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'jam_kunjungan' => $request->jam_kunjungan,
            'keluhan_utama' => $request->keluhan,
            'riwayat_penyakit_kunjungan' => $request->riwayat_penyakit_kunjungan,
            'catatan' => $request->catatan,
            'status' => 'menunggu',
            'biaya_konsultasi' => 50000, // Tambahkan baris ini
        ]);

        return redirect()->route('patient.visits.index')->with('success', 'Permintaan kunjungan berhasil diajukan.');
    }

    public function show(Visit $visit)
    {
        $visit->load(['patient.user', 'doctor.user', 'obats', 'obatVisits.obat']);

        // Check authorization
        $user = Auth::user();
        if ($user->role === 'pasien' && $visit->patient->user_id !== $user->id) {
            abort(403);
        }
        if ($user->role === 'dokter' && $visit->doctor->user_id !== $user->id) {
            abort(403);
        }

        // Get patient history for this patient (for both doctor and admin views)
        $patientHistory = Visit::where('patient_id', $visit->patient_id)
            ->where('id', '!=', $visit->id)
            ->with(['doctor'])
            ->orderBy('tanggal_kunjungan', 'desc')
            ->get();

        // For admin role
        if ($user->role === 'admin') {
            $obats = Obat::where('stok', '>', 0)->orderBy('nama_obat')->get();
            $medicines = $obats; // Alias for compatibility
            return view('admin.visits.show', compact('visit', 'obats', 'medicines', 'patientHistory'));
        }

        // For doctor role, add medicines data and use doctor-specific view
        if ($user->role === 'dokter') {
            $obats = Obat::where('stok', '>', 0)->orderBy('nama_obat')->get();
            $medicines = $obats; // Alias for compatibility

            // Get next appointment for this patient with this doctor
            $nextAppointment = Visit::where('patient_id', $visit->patient_id)
                ->where('doctor_id', $visit->doctor_id)
                ->where('tanggal_kunjungan', '>', now())
                ->where('status', '!=', 'dibatalkan')
                ->orderBy('tanggal_kunjungan')
                ->first();

            return view('doctor.visits.show', compact('visit', 'obats', 'medicines', 'patientHistory', 'nextAppointment'));
        }

        return view('visits.show', compact('visit'));
    }

    public function edit(Visit $visit)
    {
        // Only doctors can edit visits assigned to them
        if (Auth::user()->role !== 'dokter' || $visit->doctor->user_id !== Auth::id()) {
            abort(403);
        }

        $visit->load(['patient.user', 'obats', 'obatVisits.obat']);
        $obats = Obat::where('stok', '>', 0)->orderBy('nama_obat')->get();
        $medicines = $obats; // Alias for compatibility

        return view('doctor.visits.edit', compact('visit', 'obats', 'medicines'));
    }

    public function adminEdit(Visit $visit)
    {
        // Only admin can access this
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $visit->load(['patient.user', 'doctor.user', 'obats', 'obatVisits.obat']);
        $obats = Obat::where('stok', '>', 0)->orderBy('nama_obat')->get();
        $medicines = $obats; // Alias for compatibility
        $doctors = Doctor::with('user')->orderBy('nama_lengkap')->get();
        $patients = Patient::with('user')->orderBy('nama_lengkap')->get();

        return view('admin.visits.edit', compact('visit', 'obats', 'medicines', 'doctors', 'patients'));
    }

    public function update(Request $request, Visit $visit)
    {
        $request->validate([
            'hasil_pemeriksaan' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'saran' => 'nullable|string',
            'biaya_konsultasi' => 'required|numeric|min:0',
            'status' => 'required|in:menunggu,selesai,batal',
            'obats' => 'nullable|array',
            'obats.*.id' => 'required_with:obats|exists:obats,id',
            'obats.*.jumlah' => 'required_with:obats|integer|min:1',
            'obats.*.aturan_pakai' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $visit) {
            // Update visit details
            $visit->update([
                'hasil_pemeriksaan' => $request->hasil_pemeriksaan,
                'diagnosis' => $request->diagnosis,
                'tindakan' => $request->tindakan,
                'saran' => $request->saran,
                'biaya_konsultasi' => $request->biaya_konsultasi,
                'status' => $request->status,
            ]);

            // Handle medicines if status is completed
            if ($request->status === 'selesai' && $request->filled('obats')) {
                // Remove existing medicine records
                foreach ($visit->obatVisits as $obatVisit) {
                    // Return stock
                    $obatVisit->obat->increment('stok', $obatVisit->jumlah);
                    $obatVisit->delete();
                }

                // Add new medicines
                foreach ($request->obats as $obatData) {
                    $obat = Obat::find($obatData['id']);

                    // Check stock availability
                    if ($obat->stok < $obatData['jumlah']) {
                        throw new \Exception("Stok {$obat->nama_obat} tidak mencukupi. Stok tersedia: {$obat->stok}");
                    }

                    // Create visit medicine record
                    ObatVisit::create([
                        'visit_id' => $visit->id,
                        'obat_id' => $obat->id,
                        'jumlah' => $obatData['jumlah'],
                        'harga_satuan' => $obat->harga,
                        'subtotal' => $obat->harga * $obatData['jumlah'],
                        'aturan_pakai' => $obatData['aturan_pakai'] ?? null,
                    ]);

                    // Reduce stock
                    $obat->decrement('stok', $obatData['jumlah']);
                }
            }
        });

        return redirect()->route('doctor.visits.index')->with('success', 'Data kunjungan berhasil diupdate.');
    }

    public function adminUpdate(Request $request, Visit $visit)
    {
        // Only admin can access this
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'tanggal_kunjungan' => 'required|date',
            'jam_kunjungan' => 'required',
            'keluhan_utama' => 'required|string',
            'riwayat_penyakit_kunjungan' => 'nullable|string',
            'catatan' => 'nullable|string',
            'hasil_pemeriksaan' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'saran' => 'nullable|string',
            'biaya_konsultasi' => 'nullable|numeric|min:0',
            'status' => 'required|in:menunggu,sedang_diperiksa,selesai,dibatalkan'
        ]);

        $visit->update($request->only([
            'patient_id',
            'doctor_id',
            'tanggal_kunjungan',
            'jam_kunjungan',
            'keluhan_utama',
            'riwayat_penyakit_kunjungan',
            'catatan',
            'hasil_pemeriksaan',
            'diagnosis',
            'tindakan',
            'saran',
            'biaya_konsultasi',
            'status'
        ]));

        return redirect()->route('admin.visits.show', $visit)->with('success', 'Kunjungan berhasil diperbarui');
    }

    // Admin - Create new visit
    public function adminCreate(Request $request)
    {
        $patients = Patient::with('user')->get();
        $doctors = Doctor::with('user')->get();
        $selectedPatientId = $request->get('patient_id');

        return view('admin.visits.create', compact('patients', 'doctors', 'selectedPatientId'));
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'tanggal_kunjungan' => 'required|date',
            'jam_kunjungan' => 'required|date_format:H:i',
            'keluhan_utama' => 'required|string',
            'hasil_pemeriksaan' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'tindakan' => 'nullable|string',
            'biaya_konsultasi' => 'required|numeric|min:0',
            'saran' => 'nullable|string',
            'status' => 'required|in:menunggu,sedang_diperiksa,selesai,dibatalkan',
        ]);

        Visit::create($request->all());

        return redirect()->route('admin.visits.index')->with('success', 'Data kunjungan berhasil ditambahkan.');
    }

    // Get available time slots for a doctor on a specific date
    public function availableSlots(Request $request)
    {
        $doctorId = $request->get('doctor_id');
        $date = $request->get('date');

        if (!$doctorId || !$date) {
            return response()->json(['error' => 'Doctor ID and date are required'], 400);
        }

        // Get doctor's schedule for the specified date
        $schedule = DoctorSchedule::where('doctor_id', $doctorId)
            ->where('tanggal', $date)
            ->where('status', 'tersedia')
            ->first();

        if (!$schedule) {
            return response()->json(['slots' => []]);
        }

        // Get existing visits for this doctor on this date
        $existingVisits = Visit::where('doctor_id', $doctorId)
            ->where('tanggal_kunjungan', $date)
            ->pluck('jam_kunjungan')
            ->toArray();

        // Generate time slots (30-minute intervals)
        $slots = [];
        $startTime = \Carbon\Carbon::parse($schedule->jam_mulai);
        $endTime = \Carbon\Carbon::parse($schedule->jam_selesai);

        while ($startTime < $endTime) {
            $timeSlot = $startTime->format('H:i');

            // Check if this slot is not already booked
            if (!in_array($timeSlot, $existingVisits)) {
                $slots[] = [
                    'time' => $timeSlot,
                    'display' => $startTime->format('H:i'),
                    'available' => true
                ];
            }

            $startTime->addMinutes(30);
        }

        return response()->json(['slots' => $slots]);
    }

    public function updateStatus(Request $request, Visit $visit)
    {
        try {
            $request->validate([
                'status' => 'required|in:menunggu,sedang_diperiksa,selesai,dibatalkan'
            ]);

            $user = Auth::user();

            // Check authorization
            if ($user->role === 'admin') {
                // Admin can update any visit status
            } elseif ($user->role === 'dokter' && $visit->doctor_id === $user->doctor->id) {
                // Doctor can update visits assigned to them
            } else {
                Log::warning('Unauthorized visit status update attempt', [
                    'user_id' => $user->id,
                    'user_role' => $user->role,
                    'visit_id' => $visit->id,
                    'visit_doctor_id' => $visit->doctor_id,
                    'user_doctor_id' => $user->doctor->id ?? null
                ]);
                abort(403, 'Unauthorized to update this visit status');
            }

            $visit->update([
                'status' => $request->status
            ]);

            $message = 'Status kunjungan berhasil diperbarui menjadi ' . ucfirst(str_replace('_', ' ', $request->status));

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => $message,
                    'status' => $request->status
                ]);
            }

            return back()->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Error updating visit status', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
                'visit_id' => $visit->id,
                'status' => $request->status ?? null
            ]);
            
            return back()->with('error', 'Terjadi kesalahan saat mengupdate status kunjungan: ' . $e->getMessage());
        }
    }

    public function cancel(Request $request, Visit $visit)
    {
        $user = Auth::user();

        // Only patients can cancel their own visits and only if status is 'menunggu'
        if ($user->role !== 'pasien' || $visit->patient->user_id !== $user->id) {
            abort(403, 'Unauthorized to cancel this visit');
        }

        if ($visit->status !== 'menunggu') {
            return back()->with('error', 'Hanya kunjungan dengan status menunggu yang dapat dibatalkan');
        }

        $visit->update([
            'status' => 'dibatalkan'
        ]);

        $message = 'Kunjungan berhasil dibatalkan';

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'status' => 'dibatalkan'
            ]);
        }

        return back()->with('success', $message);
    }

    public function diagnose(Request $request, Visit $visit)
    {
        // Only doctors can diagnose visits assigned to them
        if (Auth::user()->role !== 'dokter' || $visit->doctor->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'diagnosis' => 'required|string',
            'tindakan' => 'nullable|string',
            'catatan_dokter' => 'nullable|string',
            'medicines' => 'nullable|array',
            'medicines.*.obat_id' => 'required_with:medicines|exists:obats,id',
            'medicines.*.jumlah' => 'required_with:medicines|integer|min:1',
            'medicines.*.dosis' => 'required_with:medicines|string',
            'medicines.*.aturan_pakai' => 'required_with:medicines|string',
        ]);

        try {
            DB::beginTransaction();

            // Update visit with diagnosis
            $visit->update([
                'diagnosis' => $request->diagnosis,
                'tindakan' => $request->tindakan,
                'catatan_dokter' => $request->catatan_dokter,
                'status' => 'selesai'
            ]);

            // Process medicines if provided
            if ($request->medicines) {
                // Remove existing medicines for this visit
                $visit->obatVisits()->delete();

                foreach ($request->medicines as $medicineData) {
                    if (!empty($medicineData['obat_id'])) {
                        $obat = Obat::find($medicineData['obat_id']);

                        // Check stock availability
                        if ($obat->stok < $medicineData['jumlah']) {
                            throw new \Exception("Stok {$obat->nama_obat} tidak mencukupi. Stok tersedia: {$obat->stok}");
                        }

                        // Create obat visit record
                        ObatVisit::create([
                            'visit_id' => $visit->id,
                            'obat_id' => $medicineData['obat_id'],
                            'jumlah' => $medicineData['jumlah'],
                            'dosis' => $medicineData['dosis'],
                            'aturan_pakai' => $medicineData['aturan_pakai'],
                        ]);

                        // Update stock
                        $obat->decrement('stok', $medicineData['jumlah']);

                        // Record stock movement
                        ObatMasuk::create([
                            'obat_id' => $obat->id,
                            'jumlah' => -$medicineData['jumlah'], // Negative for outgoing
                            'tanggal' => now(),
                            'keterangan' => "Resep untuk visit #{$visit->id} - {$visit->patient->nama_lengkap}",
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('doctor.visits.show', $visit)
                ->with('success', 'Diagnosis dan resep berhasil disimpan');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
