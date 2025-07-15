@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Detail User: {{ $user->name }}</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.users.edit', $user) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-edit mr-2"></i>Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>
    <!-- User Information -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Informasi User</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Role</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($user->role === 'admin') bg-purple-100 text-purple-800
                                @elseif($user->role === 'dokter') bg-blue-100 text-blue-800
                                @else bg-green-100 text-green-800
                                @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Terdaftar</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('d M Y H:i') }}</p>
                        </div>
                        @if($user->email_verified_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email Terverifikasi</label>
                            <p class="mt-1 text-sm text-green-600">{{ $user->email_verified_at->format('d M Y H:i') }}</p>
                        </div>
                        @else
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status Email</label>
                            <p class="mt-1 text-sm text-red-600">Belum terverifikasi</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Role-specific Information -->
                @if($user->role === 'dokter' && $user->doctor)
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dokter</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->doctor->nama_lengkap }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Spesialis</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->doctor->spesialis }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($user->role === 'pasien' && $user->patient)
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pasien</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->patient->nama_lengkap }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->patient->no_telepon ?? '-' }}</p>
                        </div>
                        <div class="col-span-full">
                            <label class="block text-sm font-medium text-gray-700">Alamat</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $user->patient->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Activity Information -->
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Aktivitas Terbaru</h3>
                    <div class="space-y-4">
                        @if($user->role === 'dokter' && $user->doctor)
                            @php
                                $recentVisits = $user->doctor->visits()->with(['patient.user'])
                                    ->orderBy('created_at', 'desc')->take(5)->get();
                            @endphp
                            @if($recentVisits->count() > 0)
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-2">Kunjungan Terbaru sebagai Dokter</h4>
                                    <div class="space-y-2">
                                        @foreach($recentVisits as $visit)
                                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                                            <div>
                                                <p class="text-sm font-medium">{{ $visit->patient->nama_lengkap }}</p>
                                                <p class="text-xs text-gray-500">{{ $visit->tanggal_kunjungan->format('d M Y') }}</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full
                                                @if($visit->status === 'menunggu') bg-yellow-100 text-yellow-800
                                                @elseif($visit->status === 'selesai') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($visit->status) }}
                                            </span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif

                        @if($user->role === 'pasien' && $user->patient)
                            @php
                                $recentVisits = $user->patient->visits()->with(['doctor.user'])
                                    ->orderBy('created_at', 'desc')->take(5)->get();
                            @endphp
                            @if($recentVisits->count() > 0)
                                <div>
                                    <h4 class="font-medium text-gray-900 mb-2">Kunjungan Terbaru sebagai Pasien</h4>
                                    <div class="space-y-2">
                                        @foreach($recentVisits as $visit)
                                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                                            <div>
                                                <p class="text-sm font-medium">Dr. {{ $visit->doctor->nama_lengkap }}</p>
                                                <p class="text-xs text-gray-500">{{ $visit->tanggal_kunjungan->format('d M Y') }}</p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full
                                                @if($visit->status === 'menunggu') bg-yellow-100 text-yellow-800
                                                @elseif($visit->status === 'selesai') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($visit->status) }}
                                            </span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif

                        @if(($user->role === 'dokter' && (!$user->doctor || $user->doctor->visits->count() == 0)) || 
                            ($user->role === 'pasien' && (!$user->patient || $user->patient->visits->count() == 0)) ||
                            $user->role === 'admin')
                            <p class="text-gray-500 text-center py-4">Tidak ada aktivitas terbaru</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
