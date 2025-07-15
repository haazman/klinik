<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Patient;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'role' => ['required', 'in:admin,dokter,pasien'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => $input['role'] ?? 'pasien',
        ]);

        // Automatically create patient record for patients
        if ($user->role === 'pasien') {
            Patient::create([
                'user_id' => $user->id,
                'nama_lengkap' => $user->name,
                'alamat' => '', // Will be filled in profile
                'no_telepon' => '', // Will be filled in profile
            ]);
        }

        return $user;
    }
}
