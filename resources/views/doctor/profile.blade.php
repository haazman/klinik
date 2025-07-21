@extends('layouts.app')

@section('title', 'Doctor Profile')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white overflow-hidden shadow-xl rounded-lg">
            <div class="p-6">
                <!-- Profile Header -->
                <div class="border-b border-gray-200 pb-6 mb-6">
                    <div class="flex items-center space-x-4">
                        <div class="h-16 w-16 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Doctor Profile</h3>
                            <p class="text-gray-600">Manage your medical practice information</p>
                            @if($doctor)
                                <p class="text-sm text-green-600 font-medium">{{ $doctor->spesialis }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Profile Form -->
                    <form method="POST" action="{{ route('doctor.profile.update') }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Account Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-4 0V4a2 2 0 014 0v2"/>
                                </svg>
                                Account Information
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">User Name *</label>
                                    <input type="text" id="name" name="name" 
                                           value="{{ old('name', $user->name) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                           required>
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                    <input type="email" id="email" name="email" 
                                           value="{{ old('email', $user->email) }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                           required>
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Medical Information -->
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Medical Practice Information
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">Full Medical Name *</label>
                                    <input type="text" id="nama_lengkap" name="nama_lengkap" 
                                           value="{{ old('nama_lengkap', $doctor->nama_lengkap ?? '') }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                           required placeholder="Dr. John Doe, Sp.PD">
                                    @error('nama_lengkap')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="spesialis" class="block text-sm font-medium text-gray-700 mb-2">Specialization *</label>
                                    <input type="text" id="spesialis" name="spesialis" 
                                           value="{{ old('spesialis', $doctor->spesialis ?? '') }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                           required placeholder="e.g., Internal Medicine">
                                    @error('spesialis')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                    <input type="tel" id="no_telepon" name="no_telepon" 
                                           value="{{ old('no_telepon', $doctor->no_telepon ?? '') }}" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                           placeholder="08xxxxxxxxxx">
                                    @error('no_telepon')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Role Display -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                                    <div class="w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md text-gray-700">
                                        Doctor
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6">
                                <label for="alamat_praktik" class="block text-sm font-medium text-gray-700 mb-2">Practice Address</label>
                                <textarea id="alamat_praktik" name="alamat_praktik" rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent" 
                                          placeholder="Complete practice address">{{ old('alamat_praktik', $doctor->alamat_praktik ?? '') }}</textarea>
                                @error('alamat_praktik')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Practice Summary -->
                        @if($doctor)
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Practice Information
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="text-center p-4 bg-white rounded-lg border border-gray-200">
                                    <div class="text-2xl font-bold text-gray-900">{{ $doctor->created_at->format('M d, Y') }}</div>
                                    <div class="text-sm text-gray-600">Joined Practice</div>
                                </div>
                                <div class="text-center p-4 bg-white rounded-lg border border-gray-200">
                                    <div class="text-2xl font-bold text-gray-900">{{ $doctor->spesialis }}</div>
                                    <div class="text-sm text-gray-600">Specialization</div>
                                </div>
                                <div class="text-center p-4 bg-white rounded-lg border border-gray-200">
                                    <div class="text-2xl font-bold text-gray-900">Active</div>
                                    <div class="text-sm text-gray-600">Status</div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-8 rounded-lg transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update Profile
                            </button>
                        </div>
                    </form>

                    <!-- Medical Note -->
                    <div class="mt-8 p-4 bg-green-50 border-l-4 border-green-400">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    <strong>Medical Professional:</strong> Please ensure all information is accurate and up to date as this will be used for patient care coordination and medical records.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
