@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
        <div class="text-sm text-gray-500">
            {{ now()->format('d F Y, H:i') }}
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pasien</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_patients'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-user-md text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Dokter</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_doctors'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-user text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total User</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Kunjungan Menunggu</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_visits'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-bolt mr-2"></i>Aksi Cepat
            </h3>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                <!-- Tambah User -->
                <a href="{{ route('admin.users.create') }}" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 transition duration-200">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-lg bg-blue-500 flex items-center justify-center">
                            <i class="fas fa-user-plus text-white"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Tambah User</p>
                        <p class="text-sm text-gray-500 truncate">Buat user baru</p>
                    </div>
                </a>

                <!-- Tambah Pasien -->
                <a href="{{ route('admin.patients.create') }}" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500 transition duration-200">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-lg bg-green-500 flex items-center justify-center">
                            <i class="fas fa-hospital-user text-white"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Tambah Pasien</p>
                        <p class="text-sm text-gray-500 truncate">Daftarkan pasien</p>
                    </div>
                </a>

                <!-- Tambah Dokter -->
                <a href="{{ route('admin.doctors.create') }}" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-purple-500 transition duration-200">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-lg bg-purple-500 flex items-center justify-center">
                            <i class="fas fa-user-md text-white"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Tambah Dokter</p>
                        <p class="text-sm text-gray-500 truncate">Daftarkan dokter</p>
                    </div>
                </a>

                <!-- Tambah Obat -->
                <a href="{{ route('admin.obats.create') }}" class="relative rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-yellow-500 transition duration-200">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-lg bg-yellow-500 flex items-center justify-center">
                            <i class="fas fa-pills text-white"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Tambah Obat</p>
                        <p class="text-sm text-gray-500 truncate">Kelola inventori</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Patients -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-user-plus mr-2"></i>Pasien Terbaru
                </h3>
            </div>
            <div class="p-6">
                @if(isset($recent_patients) && $recent_patients->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_patients as $patient)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-user text-blue-600 text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $patient->nama_lengkap }}</p>
                                    <p class="text-xs text-gray-500">{{ $patient->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">{{ $patient->no_rekam_medis }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.patients.index') }}" class="text-blue-600 hover:text-blue-500 text-sm">
                            Lihat semua pasien →
                        </a>
                    </div>
                @else
                    <div class="text-center py-6">
                        <i class="fas fa-users text-gray-400 text-3xl mb-2"></i>
                        <p class="text-gray-500">Belum ada pasien terdaftar</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Visits -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">
                    <i class="fas fa-calendar-check mr-2"></i>Kunjungan Terbaru
                </h3>
            </div>
            <div class="p-6">
                @if(isset($recent_visits) && $recent_visits->count() > 0)
                    <div class="space-y-4">
                        @foreach($recent_visits as $visit)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center">
                                    <i class="fas fa-stethoscope text-green-600 text-sm"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $visit->patient->nama_lengkap ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500">{{ $visit->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <span class="text-xs px-2 py-1 rounded 
                                {{ $visit->status == 'menunggu' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($visit->status == 'selesai' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($visit->status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.visits.index') }}" class="text-blue-600 hover:text-blue-500 text-sm">
                            Lihat semua kunjungan →
                        </a>
                    </div>
                @else
                    <div class="text-center py-6">
                        <i class="fas fa-calendar-times text-gray-400 text-3xl mb-2"></i>
                        <p class="text-gray-500">Belum ada kunjungan</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- System Info -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-center">
            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
            <div>
                <p class="text-sm font-medium text-blue-900">Klinik Bidan Yulis Setiawan</p>
                <p class="text-sm text-blue-700">
                    Selamat datang di dashboard admin Klinik Bidan Yulis Setiawan. Kelola seluruh data klinik dari sini.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
