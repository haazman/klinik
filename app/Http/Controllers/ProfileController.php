<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Show the user's profile based on their role
     */
    public function show()
    {
        $user = Auth::user();
        
        // Redirect to role-specific profile pages
        if ($user->isAdmin()) {
            return redirect()->route('admin.profile');
        } elseif ($user->isDokter()) {
            return redirect()->route('doctor.profile');
        } elseif ($user->isPasien()) {
            return redirect()->route('patient.profile');
        }
        
        // Fallback to Jetstream profile if role is not recognized
        return view('profile.show');
    }
}
