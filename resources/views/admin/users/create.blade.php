@extends('layouts.app')

@section('title', 'Tambah User Baru')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Tambah User Baru</h1>
        <a href="{{ route('admin.users.index') }}" 
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Form Tambah User</h3>
        </div>
        
        <div class="p-6">
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <h4 class="font-medium mb-2"><i class="fas fa-exclamation-circle mr-2"></i>Terdapat kesalahan:</h4>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" 
                               class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                                       required>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                       required>
                            </div>

                            <!-- Role -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                <select name="role" id="role" onchange="toggleRoleFields()" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                        required>
                                    <option value="">Pilih Role</option>
                                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="dokter" {{ old('role') === 'dokter' ? 'selected' : '' }}>Dokter</option>
                                    <option value="pasien" {{ old('role') === 'pasien' ? 'selected' : '' }}>Pasien</option>
                                </select>
                            </div>

                            <!-- No Telepon -->
                            <div>
                                <label for="no_telepon" class="block text-sm font-medium text-gray-700">No Telepon</label>
                                <input type="text" name="no_telepon" id="no_telepon" value="{{ old('no_telepon') }}" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" name="password" id="password" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                       required>
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                       required>
                            </div>
                        </div>

                        <!-- Doctor Specific Fields -->
                        <div id="doctorFields" style="display: none;" class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Data Dokter</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="spesialis" class="block text-sm font-medium text-gray-700">Spesialis</label>
                                    <input type="text" name="spesialis" id="spesialis" value="{{ old('spesialis') }}" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Patient Specific Fields -->
                        <div id="patientFields" style="display: none;" class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Data Pasien</h3>
                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="3" 
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('alamat') }}</textarea>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-6 flex justify-between">
                            <a href="{{ route('admin.users.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleRoleFields() {
            const role = document.getElementById('role').value;
            const doctorFields = document.getElementById('doctorFields');
            const patientFields = document.getElementById('patientFields');
            
            doctorFields.style.display = 'none';
            patientFields.style.display = 'none';
            
            if (role === 'dokter') {
                doctorFields.style.display = 'block';
            } else if (role === 'pasien') {
                patientFields.style.display = 'block';
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleRoleFields();
        });
    </script>
</div>
@endsection
