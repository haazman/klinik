<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\KonsultasiController;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes - redirected after login
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // General Dashboard (redirect based on role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Routes that require authentication but not specific role
Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    // Available slots endpoint (can be used by any logged in user)
    Route::get('/available-slots', [VisitController::class, 'availableSlots'])->name('available-slots');
    
    // Visit detail - can be accessed by any authenticated user (with authorization check in controller)
    Route::get('/visits/{visit}', [VisitController::class, 'show'])->name('visits.show');
});

// Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        
        // User Management
        Route::get('/users', [AdminController::class, 'users'])->name('users.index');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
        
        // Patient Management
        Route::resource('patients', PatientController::class);
        
        // Doctor Management
        Route::resource('doctors', DoctorController::class);
        
        // Medicine Management
        Route::resource('obats', ObatController::class);
        Route::get('/obats/{obat}/stock-history', [ObatController::class, 'stockHistory'])->name('obats.stock-history');
        
        // Medicine Stock Management
        Route::post('/obat-masuk', [ObatController::class, 'storeObatMasuk'])->name('obat-masuk.store');
        
        // Schedule Management (Admin can manage all schedules)
        Route::resource('schedules', ScheduleController::class);
        
        // All Visits (Admin can see all)
        Route::get('/visits', [VisitController::class, 'adminIndex'])->name('visits.index');
        Route::get('/visits/create', [VisitController::class, 'adminCreate'])->name('visits.create');
        Route::post('/visits', [VisitController::class, 'adminStore'])->name('visits.store');
        Route::get('/visits/{visit}', [VisitController::class, 'show'])->name('visits.show');
        Route::get('/visits/{visit}/edit', [VisitController::class, 'adminEdit'])->name('visits.edit');
        Route::put('/visits/{visit}', [VisitController::class, 'adminUpdate'])->name('visits.update');
        Route::put('/visits/{visit}/status', [VisitController::class, 'updateStatus'])->name('visits.updateStatus');
        
        // Consultation Management
        Route::resource('konsultasi', KonsultasiController::class, [
            'only' => ['index', 'show']
        ]);
        Route::put('/konsultasi/{konsultasi}/status', [KonsultasiController::class, 'updateStatus'])->name('konsultasi.update-status');
    });
    
    // Doctor Routes
    Route::middleware(['role:dokter'])->prefix('doctor')->name('doctor.')->group(function () {
        Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
        
        // Doctor Schedule Management
        Route::get('/schedules', [DoctorController::class, 'schedules'])->name('schedules.index');
        Route::get('/schedules/create', [DoctorController::class, 'createSchedule'])->name('schedules.create');
        Route::post('/schedules', [DoctorController::class, 'storeSchedule'])->name('schedules.store');
        Route::put('/schedules/{schedule}', [DoctorController::class, 'updateSchedule'])->name('schedules.update');
        Route::delete('/schedules/{schedule}', [DoctorController::class, 'deleteSchedule'])->name('schedules.delete');
        
        // Patient Visits
        Route::get('/visits', [VisitController::class, 'doctorIndex'])->name('visits.index');
        Route::get('/visits/{visit}', [VisitController::class, 'show'])->name('visits.show');
        Route::get('/visits/{visit}/edit', [VisitController::class, 'edit'])->name('visits.edit');
        Route::put('/visits/{visit}', [VisitController::class, 'update'])->name('visits.update');
        Route::patch('/visits/{visit}/diagnose', [VisitController::class, 'diagnose'])->name('visits.diagnose');
        Route::put('/visits/{visit}/status', [VisitController::class, 'updateStatus'])->name('visits.updateStatus');
        
        // Patient History
        Route::get('/patients', [PatientController::class, 'doctorIndex'])->name('patients.index');
        Route::get('/patients/{patient}', [PatientController::class, 'doctorShow'])->name('patients.show');
    });
    
    // Patient Routes
    Route::middleware(['role:pasien'])->prefix('patient')->name('patient.')->group(function () {
        Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
        
        // Profile Management
        Route::get('/profile', [PatientController::class, 'profile'])->name('profile');
        Route::put('/profile', [PatientController::class, 'updateProfile'])->name('profile.update');
        
        // Visit Requests
        Route::get('/visits', [VisitController::class, 'patientIndex'])->name('visits.index');
        Route::get('/visits/available-slots', [VisitController::class, 'availableSlots'])->name('visits.available-slots');
        Route::get('/visits/create', [VisitController::class, 'create'])->name('visits.create');
        Route::post('/visits', [VisitController::class, 'store'])->name('visits.store');
        Route::get('/visits/{visit}', [VisitController::class, 'show'])->name('visits.show');
        Route::get('/visits/{visit}/cancel', function($visit) {
            return redirect()->route('patient.visits.show', $visit)
                ->with('error', 'Tidak dapat membatalkan kunjungan melalui URL langsung. Gunakan tombol batalkan di halaman detail.');
        });
        Route::put('/visits/{visit}/cancel', [VisitController::class, 'cancel'])->name('visits.cancel');
        
        // Doctor Schedules (to see available dates)
        Route::get('/schedules', [ScheduleController::class, 'available'])->name('schedules.available');
        
        // Consultation Requests
        Route::get('/konsultasi', [KonsultasiController::class, 'patientIndex'])->name('konsultasi.index');
        Route::get('/konsultasi/create', [KonsultasiController::class, 'create'])->name('konsultasi.create');
        Route::post('/konsultasi', [KonsultasiController::class, 'store'])->name('konsultasi.store');
        Route::put('/konsultasi/{konsultasi}/cancel', [KonsultasiController::class, 'cancel'])->name('konsultasi.cancel');
    });
});

// API Routes for AJAX requests
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/api/obats/search', [ObatController::class, 'search'])->name('api.obats.search');
});
