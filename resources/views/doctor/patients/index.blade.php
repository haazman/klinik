@extends('layouts.app')

@section('title', 'My Patients')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">My Patients</h1>
            <p class="text-gray-600 mt-1">Daftar pasien yang pernah berobat dengan Anda</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Pasien</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $patients->total() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-user-check text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Aktif Bulan Ini</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $patients->filter(function($p) { return $p->visits->where('tanggal_kunjungan', '>=', now()->startOfMonth())->count() > 0; })->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-calendar text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Kunjungan Bulan Ini</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $patients->sum(function($p) { return $p->visits->where('tanggal_kunjungan', '>=', now()->startOfMonth())->count(); }) }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-heartbeat text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Rata-rata Kunjungan</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $patients->count() > 0 ? number_format($patients->sum(function($p) { return $p->visits->count(); }) / $patients->count(), 1) : 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Patients Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Pasien</h2>
        </div>
        
        @if($patients->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kontak</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Kunjungan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kunjungan Terakhir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Terakhir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($patients as $patient)
                            @php
                                $lastVisit = $patient->visits->sortByDesc('tanggal_kunjungan')->first();
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                <i class="fas fa-user text-gray-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $patient->nama_lengkap }}</div>
                                            <div class="text-sm text-gray-500">{{ $patient->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div>
                                        @if($patient->no_telepon)
                                            <div class="flex items-center">
                                                <i class="fas fa-phone mr-2"></i>
                                                {{ $patient->no_telepon }}
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </div>
                                    <div class="mt-1">
                                        @if($patient->tanggal_lahir)
                                            <div class="flex items-center text-xs">
                                                <i class="fas fa-birthday-cake mr-2"></i>
                                                {{ \Carbon\Carbon::parse($patient->tanggal_lahir)->format('d/m/Y') }}
                                                ({{ \Carbon\Carbon::parse($patient->tanggal_lahir)->age }} thn)
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $patient->visits->count() }} kunjungan
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($lastVisit)
                                        <div>{{ \Carbon\Carbon::parse($lastVisit->tanggal_kunjungan)->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($lastVisit->tanggal_kunjungan)->diffForHumans() }}</div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($lastVisit)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                            {{ $lastVisit->status == 'selesai' ? 'bg-green-100 text-green-800' : 
                                               ($lastVisit->status == 'sedang_diperiksa' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($lastVisit->status == 'menunggu' ? 'bg-blue-100 text-blue-800' : 
                                                'bg-red-100 text-red-800')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $lastVisit->status)) }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('doctor.patients.show', $patient) }}" 
                                           class="text-blue-600 hover:text-blue-900 transition duration-200"
                                           title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if($patient->visits->count() > 0)
                                            <a href="{{ route('doctor.visits.index', ['patient_id' => $patient->id]) }}" 
                                               class="text-green-600 hover:text-green-900 transition duration-200"
                                               title="Riwayat Kunjungan">
                                                <i class="fas fa-history"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $patients->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-user-injured text-6xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Pasien</h3>
                <p class="text-gray-600">Anda belum memiliki pasien yang pernah berobat.</p>
            </div>
        @endif
    </div>
</div>
@endsection
