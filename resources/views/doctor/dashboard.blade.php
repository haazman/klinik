<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Doctor Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">Selamat datang, {{ $doctor->nama_lengkap }}</h3>
                    <p class="text-gray-600">{{ $doctor->spesialis }}</p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-8 w-8 rounded-md bg-blue-500 text-white">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Pasien</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['total_patients'] }}</dd>
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
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['pending_visits'] }}</dd>
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
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['completed_visits'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="flex items-center justify-center h-8 w-8 rounded-md bg-purple-500 text-white">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a6 6 0 100-12 6 6 0 000 12z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Jadwal Hari Ini</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $stats['today_schedules'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Today's Visits -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Kunjungan Hari Ini</h3>
                        <div class="space-y-3">
                            @forelse($todayVisits as $visit)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $visit->patient->nama_lengkap }}</p>
                                    <p class="text-sm text-gray-500">{{ $visit->keluhan_utama }}</p>
                                    <p class="text-xs text-gray-400">
                                        {{ $visit->jam_kunjungan ? \Carbon\Carbon::parse($visit->jam_kunjungan)->format('H:i') : 'Jam belum ditentukan' }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($visit->status === 'menunggu') bg-yellow-100 text-yellow-800
                                        @elseif($visit->status === 'selesai') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($visit->status) }}
                                    </span>
                                    <div class="mt-1">
                                        <a href="{{ route('doctor.visits.show', $visit) }}" class="text-blue-600 hover:text-blue-500 text-xs">
                                            Lihat detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-4">Tidak ada kunjungan hari ini</p>
                            @endforelse
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('doctor.visits.index') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                                Lihat semua kunjungan →
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Upcoming Schedules -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Jadwal Mendatang</h3>
                        <div class="space-y-3">
                            @forelse($upcomingSchedules as $schedule)
                            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ \Carbon\Carbon::parse($schedule->tanggal)->format('d M Y') }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}
                                    </p>
                                    @if($schedule->keterangan)
                                    <p class="text-xs text-gray-400">{{ $schedule->keterangan }}</p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($schedule->is_available) bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $schedule->is_available ? 'Tersedia' : 'Tidak Tersedia' }}
                                    </span>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 text-center py-4">Belum ada jadwal</p>
                            @endforelse
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('doctor.schedules.index') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                                Kelola jadwal →
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <a href="{{ route('doctor.schedules.create') }}" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                            <svg class="h-8 w-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a6 6 0 100-12 6 6 0 000 12z"></path>
                            </svg>
                            <span class="text-sm font-medium text-blue-900">Buat Jadwal</span>
                        </a>

                        <a href="{{ route('doctor.visits.index') }}" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                            <svg class="h-8 w-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            <span class="text-sm font-medium text-green-900">Lihat Kunjungan</span>
                        </a>

                        <a href="{{ route('doctor.patients.index') }}" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                            <svg class="h-8 w-8 text-purple-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path>
                            </svg>
                            <span class="text-sm font-medium text-purple-900">Data Pasien</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
