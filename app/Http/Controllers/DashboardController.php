<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Redirect based on role
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'dokter':
                return redirect()->route('doctor.dashboard');
            case 'pasien':
                return redirect()->route('patient.visits.index');
            default:
                return redirect()->route('login');
        }
    }
}
