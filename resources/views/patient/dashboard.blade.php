<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Pasien - Klinik Bidan Yulis Setiawan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Selamat datang, {{ $patient->nama_lengkap ?? auth()->user()->name }}</h3>
                    @if(isset($isProfileIncomplete) && $isProfileIncomplete)
                        <div class="mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                            <p class="text-yellow-800 text-sm">
                                Silakan lengkapi data profil Anda untuk dapat mengajukan kunjungan.
                                <a href="{{ route('patient.profile') }}" class="font-medium underline">Lengkapi sekarang</a>
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Main Features Card -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6">
                    <h4 class="text-lg font-medium text-gray-900 mb-4">Fitur Utama</h4>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <a href="{{ route('patient.visits.create') }}" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <svg class="h-8 w-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span class="text-sm font-medium text-blue-900">Buat Kunjungan</span>
                        </a>
                        
                        <a href="{{ route('patient.visits.index') }}" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <svg class="h-8 w-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <span class="text-sm font-medium text-green-900">Riwayat Kunjungan</span>
                        </a>
                        
                        <a href="{{ route('patient.schedules.available') }}" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <svg class="h-8 w-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium text-purple-900">Jadwal Dokter</span>
                        </a>
                        
                        <a href="{{ route('patient.profile') }}" class="flex flex-col items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors">
                            <svg class="h-8 w-8 text-orange-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span class="text-sm font-medium text-orange-900">Profil Saya</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            @if(isset($stats))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-8 w-8 rounded-md bg-blue-500 text-white">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Kunjungan</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['total_visits'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-8 w-8 rounded-md bg-yellow-500 text-white">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Menunggu</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['pending_visits'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-8 w-8 rounded-md bg-green-500 text-white">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Selesai</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['completed_visits'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Recent Visits -->
            @if(isset($recentVisits) && $recentVisits->count() > 0)
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Kunjungan Terbaru</h3>
                    <div class="space-y-3">
                        @forelse($recentVisits as $visit)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $visit->tanggal_kunjungan }}</p>
                                <p class="text-sm text-gray-500">Dokter: {{ $visit->doctor->name ?? 'Belum ditentukan' }}</p>
                            </div>
                            <div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    @if($visit->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($visit->status == 'approved') bg-blue-100 text-blue-800
                                    @elseif($visit->status == 'completed') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($visit->status) }}
                                </span>
                            </div>
                        </div>
                        @empty
                        <p class="text-gray-500 text-center py-4">Belum ada kunjungan</p>
                        @endforelse
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('patient.visits.index') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                            Lihat semua kunjungan →
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Quick Info Card -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-white">
                    <h3 class="text-lg font-medium mb-2">Klinik Bidan Yulis Setiawan</h3>
                    <p class="text-blue-100">
                        Melayani kesehatan ibu dan anak dengan fasilitas modern dan tenaga medis berpengalaman.
                    </p>
                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <strong>Jam Operasional:</strong><br>
                            Senin - Sabtu: 08:00 - 20:00<br>
                            Minggu: 08:00 - 16:00
                        </div>
                        <div>
                            <strong>Layanan:</strong><br>
                            • Konsultasi Kehamilan<br>
                            • Pemeriksaan Rutin<br>
                            • Layanan KB
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
