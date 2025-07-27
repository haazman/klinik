@extends('layouts.app')

@section('title', 'Data Kunjungan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Data Kunjungan Pasien</h1>
        <a href="{{ route('admin.patients.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
            <i class="fas fa-plus mr-2"></i>Kelola Pasien
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-48">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text" name="search" id="search" 
                       value="{{ request('search') }}"
                       placeholder="Nama pasien, dokter, atau diagnosis..."
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="min-w-32">
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" id="status" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="sedang_diperiksa" {{ request('status') == 'sedang_diperiksa' ? 'selected' : '' }}>Sedang Diperiksa</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            
            <div class="min-w-40">
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" id="start_date" 
                       value="{{ request('start_date') }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="min-w-40">
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" id="end_date" 
                       value="{{ request('end_date') }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="flex space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.visits.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
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
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Kunjungan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $visits->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Menunggu</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $visits->where('status', 'menunggu')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Selesai Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $visits->where('status', 'selesai')->where('tanggal_kunjungan', today())->count() }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-money-bill-wave text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pendapatan Hari Ini</p>
                    <p class="text-xl font-bold text-gray-900">
                        Rp {{ number_format($visits->where('tanggal_kunjungan', today())->sum('biaya_konsultasi'), 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Visits Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Kunjungan</h3>
        </div>
        
        @if($visits->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Jam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keluhan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Biaya</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($visits as $visit)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $visit->tanggal_kunjungan->format('d/m/Y') }}
                            @if($visit->jam_kunjungan)
                                <br><span class="text-xs text-gray-500">{{ $visit->jam_kunjungan }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $visit->patient->nama_lengkap }}</div>
                            <div class="text-sm text-gray-500">{{ $visit->patient->no_rekam_medis }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $visit->doctor->nama_lengkap }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate" title="{{ $visit->keluhan_utama }}">
                            {{ $visit->keluhan_utama }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate" title="{{ $visit->diagnosis }}">
                            {{ $visit->diagnosis ?: '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($visit->status == 'selesai') bg-green-100 text-green-800
                                @elseif($visit->status == 'sedang_diperiksa') bg-yellow-100 text-yellow-800
                                @elseif($visit->status == 'menunggu') bg-blue-100 text-blue-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst(str_replace('_', ' ', $visit->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                            Rp {{ number_format($visit->biaya_konsultasi, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('visits.show', $visit) }}" 
                                   class="text-blue-600 hover:text-blue-900 p-1 rounded" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($visit->status == 'menunggu')
                                    <form action="{{ route('admin.visits.updateStatus', $visit) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="sedang_diperiksa">
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-900 p-1 rounded" title="Mulai Pemeriksaan">
                                            <i class="fas fa-play"></i>
                                        </button>
                                    </form>
                                @endif
                                
                                @if(in_array($visit->status, ['menunggu', 'sedang_diperiksa']))
                                    <a href="{{ route('admin.visits.edit', $visit) }}" 
                                       class="text-green-600 hover:text-green-900 p-1 rounded" title="Edit/Selesaikan">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                                
                                @if($visit->status == 'menunggu')
                                    <form action="{{ route('admin.visits.updateStatus', $visit) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Apakah Anda yakin ingin membatalkan kunjungan ini?')">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="dibatalkan">
                                        <button type="submit" class="text-red-600 hover:text-red-900 p-1 rounded" title="Batalkan">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($visits->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $visits->links() }}
        </div>
        @endif
        
        @else
        <div class="px-6 py-12 text-center">
            <div class="max-w-md mx-auto">
                <i class="fas fa-calendar-alt text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Data Kunjungan</h3>
                <p class="text-gray-500 mb-6">Belum ada kunjungan pasien yang tercatat.</p>
                <a href="{{ route('admin.patients.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-plus mr-2"></i>Kelola Pasien
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
