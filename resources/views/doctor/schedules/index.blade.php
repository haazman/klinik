@extends('layouts.app')

@section('title', 'My Schedules')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">My Schedules</h1>
            <p class="text-gray-600 mt-1">Kelola jadwal praktik Anda</p>
        </div>
        <a href="{{ route('doctor.schedules.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
            <i class="fas fa-plus mr-2"></i>Tambah Jadwal
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Total Jadwal</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $schedules->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Tersedia</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $schedules->where('status', 'tersedia')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Hari Ini</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $schedules->where('tanggal', today()->format('Y-m-d'))->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-calendar-week text-xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-medium text-gray-500">Minggu Ini</h3>
                    <p class="text-2xl font-bold text-gray-900">{{ $schedules->whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()])->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedules Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Jadwal</h2>
        </div>
        
        @if($schedules->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hari</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($schedules as $schedule)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ \Carbon\Carbon::parse($schedule->tanggal)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($schedule->tanggal)->locale('id')->translatedFormat('l') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $schedule->status == 'tersedia' ? 'bg-green-100 text-green-800' : 
                                           ($schedule->status == 'tidak_tersedia' ? 'bg-red-100 text-red-800' : 
                                            'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst(str_replace('_', ' ', $schedule->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $schedule->keterangan ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <form action="{{ route('doctor.schedules.update', $schedule) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="{{ $schedule->status == 'tersedia' ? 'tidak_tersedia' : 'tersedia' }}">
                                            <button type="submit" 
                                                    class="text-yellow-600 hover:text-yellow-900 transition duration-200"
                                                    title="{{ $schedule->status == 'tersedia' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                                <i class="fas fa-{{ $schedule->status == 'tersedia' ? 'eye-slash' : 'eye' }}"></i>
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('doctor.schedules.delete', $schedule) }}" method="POST" class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 transition duration-200"
                                                    title="Hapus">
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
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-calendar-plus text-6xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Jadwal</h3>
                <p class="text-gray-600 mb-4">Anda belum memiliki jadwal praktik. Mulai dengan menambahkan jadwal baru.</p>
                <a href="{{ route('doctor.schedules.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-plus mr-2"></i>Tambah Jadwal Pertama
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
