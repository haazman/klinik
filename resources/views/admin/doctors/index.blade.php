@extends('layouts.app')

@section('title', 'Data Dokter')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Data Dokter</h1>
        <a href="{{ route('admin.doctors.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
            <i class="fas fa-plus mr-2"></i>Tambah Dokter
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-64">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Dokter</label>
                <input type="text" name="search" id="search" 
                       value="{{ request('search') }}"
                       placeholder="Nama dokter atau spesialisasi..."
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="min-w-40">
                <label for="spesialisasi" class="block text-sm font-medium text-gray-700 mb-1">Spesialisasi</label>
                <select name="spesialisasi" id="spesialisasi" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Spesialisasi</option>
                    <option value="umum" {{ request('spesialisasi') == 'umum' ? 'selected' : '' }}>Dokter Umum</option>
                    <option value="kandungan" {{ request('spesialisasi') == 'kandungan' ? 'selected' : '' }}>Kandungan</option>
                    <option value="anak" {{ request('spesialisasi') == 'anak' ? 'selected' : '' }}>Anak</option>
                    <option value="gigi" {{ request('spesialisasi') == 'gigi' ? 'selected' : '' }}>Gigi</option>
                    <option value="kulit" {{ request('spesialisasi') == 'kulit' ? 'selected' : '' }}>Kulit</option>
                    <option value="mata" {{ request('spesialisasi') == 'mata' ? 'selected' : '' }}>Mata</option>
                    <option value="jantung" {{ request('spesialisasi') == 'jantung' ? 'selected' : '' }}>Jantung</option>
                </select>
            </div>
            
            <div class="flex space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
                <a href="{{ route('admin.doctors.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-user-md text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Dokter</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $doctors->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Dokter Aktif Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $doctors->filter(function($doctor) {
                            return $doctor->schedules()->whereDate('tanggal', now()->toDateString())->exists();
                        })->count() }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-stethoscope text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Spesialisasi Terbanyak</p>
                    <p class="text-lg font-bold text-gray-900 capitalize">
                        {{ $doctors->groupBy('spesialisasi')->sortByDesc(function($group) { return $group->count(); })->keys()->first() ?: 'Umum' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-history text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Kunjungan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $doctors->sum(function($doctor) { return $doctor->visits->count(); }) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Doctors Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Dokter</h3>
        </div>
        
        @if($doctors->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Spesialisasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengalaman</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jadwal Hari Ini</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($doctors as $doctor)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                        <i class="fas fa-user-md text-white"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $doctor->nama_lengkap }}</div>
                                    <div class="text-sm text-gray-500">{{ $doctor->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 capitalize">
                                {{ $doctor->spesialisasi }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $doctor->pengalaman }} tahun
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $doctor->no_telepon }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            @php
                                $todaySchedule = $doctor->schedules()->whereDate('tanggal', now()->toDateString())->first();
                            @endphp
                            @if($todaySchedule)
                                <span class="text-green-600">
                                    {{ $todaySchedule->jam_mulai }} - {{ $todaySchedule->jam_selesai }}
                                </span>
                            @else
                                <span class="text-gray-400">Tidak ada jadwal</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($todaySchedule && now()->between(
                                now()->setTimeFromTimeString($todaySchedule->jam_mulai),
                                now()->setTimeFromTimeString($todaySchedule->jam_selesai)
                            ))
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Sedang Praktik
                                </span>
                            @elseif($todaySchedule)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Jadwal Hari Ini
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Tidak Praktik
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.doctors.show', $doctor) }}" 
                                   class="text-blue-600 hover:text-blue-900 p-1 rounded">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.doctors.edit', $doctor) }}" 
                                   class="text-yellow-600 hover:text-yellow-900 p-1 rounded">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokter ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 p-1 rounded">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @else
        <div class="px-6 py-12 text-center">
            <div class="max-w-md mx-auto">
                <i class="fas fa-user-md text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Data Dokter</h3>
                <p class="text-gray-500 mb-6">Mulai dengan menambahkan dokter pertama.</p>
                <a href="{{ route('admin.doctors.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-plus mr-2"></i>Tambah Dokter Pertama
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
