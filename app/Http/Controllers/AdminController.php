<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Obat;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_patients' => Patient::count(),
            'total_doctors' => Doctor::count(),
            'total_users' => User::count(),
            'total_medicines' => Obat::count(),
            'pending_visits' => Visit::where('status', 'menunggu')->count(),
            'completed_visits' => Visit::where('status', 'selesai')->count(),
            'low_stock_medicines' => Obat::where('stok', '<', 20)->count(),
        ];

        // Recent data for dashboard
        $recent_patients = Patient::orderBy('created_at', 'desc')->take(5)->get();
        $recent_visits = Visit::with(['patient', 'doctor'])->orderBy('created_at', 'desc')->take(5)->get();
        $recent_users = User::with(['patient', 'doctor'])->orderBy('created_at', 'desc')->take(6)->get();

        // Legacy variables for backward compatibility
        $recentVisits = $recent_visits;
        $lowStockMedicines = Obat::where('stok', '<', 20)->orderBy('stok', 'asc')->take(10)->get();
        $recentUsers = $recent_users;

        return view('admin.dashboard', compact(
            'stats', 
            'recent_patients', 
            'recent_visits', 
            'recent_users',
            'recentVisits', 
            'lowStockMedicines', 
            'recentUsers'
        ));
    }

    // User Management
    public function users()
    {
        $users = User::with(['patient', 'doctor'])->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,dokter,pasien',
            'no_telepon' => 'nullable|string|max:20',
            'spesialis' => 'required_if:role,dokter|nullable|string|max:255',
            'alamat' => 'required_if:role,pasien|nullable|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Create associated profile based on role
        if ($request->role === 'pasien') {
            Patient::create([
                'user_id' => $user->id,
                'nama_lengkap' => $request->name,
                'alamat' => $request->alamat ?? '',
                'no_telepon' => $request->no_telepon ?? '',
            ]);
        } elseif ($request->role === 'dokter') {
            Doctor::create([
                'user_id' => $user->id,
                'nama_lengkap' => $request->name,
                'spesialis' => $request->spesialis ?? 'Umum',
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat.');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function showUser(User $user)
    {
        $user->load(['patient', 'doctor']);
        return view('admin.users.show', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,dokter,pasien',
            'password' => 'nullable|string|min:8|confirmed',
            'doctor_nama_lengkap' => 'nullable|string|max:255',
            'doctor_spesialis' => 'nullable|string|max:255',
            'patient_nama_lengkap' => 'nullable|string|max:255',
            'patient_alamat' => 'nullable|string',
            'patient_no_telepon' => 'nullable|string|max:20',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // Update associated profiles
        if ($user->role === 'dokter' && $user->doctor) {
            $user->doctor->update([
                'nama_lengkap' => $request->doctor_nama_lengkap ?? $user->name,
                'spesialis' => $request->doctor_spesialis ?? $user->doctor->spesialis,
            ]);
        }

        if ($user->role === 'pasien' && $user->patient) {
            $user->patient->update([
                'nama_lengkap' => $request->patient_nama_lengkap ?? $user->name,
                'alamat' => $request->patient_alamat ?? $user->patient->alamat,
                'no_telepon' => $request->patient_no_telepon ?? $user->patient->no_telepon,
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate.');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    // Admin Profile Management
    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.profile')->with('success', 'Profile berhasil diupdate.');
    }
}
