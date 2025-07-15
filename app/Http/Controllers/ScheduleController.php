<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use App\Models\Doctor;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = DoctorSchedule::with('doctor')->orderBy('tanggal', 'desc')->paginate(10);
        
        return view('admin.schedules.index', compact('schedules'));
    }

    public function create()
    {
        $doctors = Doctor::all();
        
        return view('admin.schedules.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'status' => 'required|in:tersedia,tidak_tersedia',
        ]);

        DoctorSchedule::create($request->all());

        return redirect()->route('schedules.index')
                         ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function show(DoctorSchedule $schedule)
    {
        $schedule->load('doctor');
        
        return view('admin.schedules.show', compact('schedule'));
    }

    public function edit(DoctorSchedule $schedule)
    {
        $doctors = Doctor::all();
        
        return view('admin.schedules.edit', compact('schedule', 'doctors'));
    }

    public function update(Request $request, DoctorSchedule $schedule)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'status' => 'required|in:tersedia,tidak_tersedia',
        ]);

        $schedule->update($request->all());

        return redirect()->route('schedules.index')
                         ->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(DoctorSchedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')
                         ->with('success', 'Jadwal berhasil dihapus.');
    }

    // Method untuk mendapatkan jadwal tersedia
    public function available()
    {
        $schedules = DoctorSchedule::with('doctor')
                                  ->where('status', 'tersedia')
                                  ->where('tanggal', '>=', now()->toDateString())
                                  ->orderBy('tanggal')
                                  ->orderBy('jam_mulai')
                                  ->get();

        return view('patient.schedules.available', compact('schedules'));
    }
}
