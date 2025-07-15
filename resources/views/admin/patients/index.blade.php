@extends('layouts.app')

@section('title', 'Data Pasien')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Data Pasien</h1>
        <a href="{{ route('admin.patients.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
            <i class="fas fa-plus mr-2"></i>Tambah Pasien
        </a>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-64">
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Pasien</label>
                <input type="text" name="search" id="search" 
                       value="{{ request('search') }}"
                       placeholder="Nama, No. RM, atau NIK..."
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="min-w-32">
                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" 
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua</option>
                    <option value="L" {{ request('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ request('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>
            
            <div class="flex space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
                <a href="{{ route('admin.patients.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
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
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pasien</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $patients->total() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-user-plus text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pasien Baru Bulan Ini</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $patients->where('created_at', '>=', now()->startOfMonth())->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-pink-100 text-pink-600">
                    <i class="fas fa-venus text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pasien Perempuan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $patients->where('jenis_kelamin', 'P')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-mars text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pasien Laki-laki</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $patients->where('jenis_kelamin', 'L')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Patients Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Daftar Pasien</h3>
        </div>
        
        @if($patients->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. RM</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pasien</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Umur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telepon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terdaftar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($patients as $patient)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-blue-600">{{ $patient->no_rekam_medis }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <i class="fas fa-user text-gray-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $patient->nama_lengkap }}</div>
                                    @if($patient->user)
                                    <div class="text-sm text-green-600">
                                        <i class="fas fa-check-circle mr-1"></i>Terdaftar sebagai user
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $patient->nik }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $patient->jenis_kelamin == 'P' ? 'bg-pink-100 text-pink-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $patient->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-laki' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $patient->umur }} tahun
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $patient->no_telepon }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $patient->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.patients.show', $patient) }}" 
                                   class="text-blue-600 hover:text-blue-900 p-1 rounded">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.patients.edit', $patient) }}" 
                                   class="text-yellow-600 hover:text-yellow-900 p-1 rounded">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus pasien ini?')">
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

        <!-- Pagination -->
        @if($patients->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $patients->links() }}
        </div>
        @endif
        
        @else
        <div class="px-6 py-12 text-center">
            <div class="max-w-md mx-auto">
                <i class="fas fa-users text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Data Pasien</h3>
                <p class="text-gray-500 mb-6">Mulai dengan menambahkan pasien pertama.</p>
                <a href="{{ route('admin.patients.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-plus mr-2"></i>Tambah Pasien Pertama
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
