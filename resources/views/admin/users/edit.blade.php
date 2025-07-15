@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Edit User</h1>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name" 
                               value="{{ old('name', $user->name) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email" 
                               value="{{ old('email', $user->email) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select name="role" id="role" required onchange="toggleRoleFields()"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="dokter" {{ old('role', $user->role) == 'dokter' ? 'selected' : '' }}>Dokter</option>
                            <option value="pasien" {{ old('role', $user->role) == 'pasien' ? 'selected' : '' }}>Pasien</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status
                        </label>
                        <select name="status" id="status"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status', 'active') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                <!-- Password Section -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Ubah Password</h3>
                    <p class="text-sm text-gray-600 mb-4">Kosongkan jika tidak ingin mengubah password</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password Baru
                            </label>
                            <input type="password" name="password" id="password"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Doctor Profile Fields -->
                @if($user->role == 'dokter' && $user->doctor)
                <div id="doctorFields" class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Data Dokter</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="doctor_nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap Dokter
                            </label>
                            <input type="text" name="doctor_nama_lengkap" id="doctor_nama_lengkap"
                                   value="{{ old('doctor_nama_lengkap', $user->doctor->nama_lengkap) }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="doctor_spesialis" class="block text-sm font-medium text-gray-700 mb-2">
                                Spesialis
                            </label>
                            <input type="text" name="doctor_spesialis" id="doctor_spesialis"
                                   value="{{ old('doctor_spesialis', $user->doctor->spesialis) }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
                @endif

                <!-- Patient Profile Fields -->
                @if($user->role == 'pasien' && $user->patient)
                <div id="patientFields" class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Data Pasien</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="patient_nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap Pasien
                            </label>
                            <input type="text" name="patient_nama_lengkap" id="patient_nama_lengkap"
                                   value="{{ old('patient_nama_lengkap', $user->patient->nama_lengkap) }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="patient_no_telepon" class="block text-sm font-medium text-gray-700 mb-2">
                                No. Telepon
                            </label>
                            <input type="text" name="patient_no_telepon" id="patient_no_telepon"
                                   value="{{ old('patient_no_telepon', $user->patient->no_telepon) }}"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="md:col-span-2">
                            <label for="patient_alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat
                            </label>
                            <textarea name="patient_alamat" id="patient_alamat" rows="3"
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('patient_alamat', $user->patient->alamat) }}</textarea>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 pt-6">
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i>Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleRoleFields() {
    const role = document.getElementById('role').value;
    const doctorFields = document.getElementById('doctorFields');
    const patientFields = document.getElementById('patientFields');
    
    if (doctorFields) doctorFields.style.display = 'none';
    if (patientFields) patientFields.style.display = 'none';
    
    if (role === 'dokter' && doctorFields) {
        doctorFields.style.display = 'block';
    } else if (role === 'pasien' && patientFields) {
        patientFields.style.display = 'block';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleRoleFields();
});
</script>
@endsection
