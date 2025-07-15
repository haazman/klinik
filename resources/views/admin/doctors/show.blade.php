@extends('layouts.app')

@section('title', 'Detail Dokter')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Detail Dokter: {{ $doctor->name }}</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.doctors.edit', $doctor) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.doctors.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Detail Dokter -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Dokter</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Nama Lengkap</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $doctor->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Email</label>
                        <p class="text-gray-800">{{ $doctor->email }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Spesialisasi</label>
                        <p class="text-gray-800 capitalize">{{ $doctor->spesialisasi }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Pengalaman</label>
                        <p class="text-gray-800">{{ $doctor->pengalaman }} tahun</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Nomor Telepon</label>
                        <p class="text-gray-800">{{ $doctor->telepon }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Nomor SIP</label>
                        <p class="text-gray-800">{{ $doctor->sip }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Nomor STR</label>
                        <p class="text-gray-800">{{ $doctor->str ?: '-' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Tarif Konsultasi</label>
                        <p class="text-lg font-semibold text-green-600">Rp {{ number_format($doctor->tarif_konsultasi, 0, ',', '.') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Status</label>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $doctor->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($doctor->status) }}
                        </span>
                    </div>
                    
                    @if($doctor->alamat)
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-600">Alamat</label>
                        <p class="text-gray-800">{{ $doctor->alamat }}</p>
                    </div>
                    @endif
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Bergabung</label>
                        <p class="text-gray-800">{{ $doctor->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Terakhir Diupdate</label>
                        <p class="text-gray-800">{{ $doctor->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status & Actions -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Dokter</h3>
                
                @if($doctor->status == 'aktif')
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    Dokter aktif dan dapat menerima jadwal konsultasi.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    Dokter tidak aktif dan tidak dapat menerima jadwal konsultasi.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('admin.doctors.edit', $doctor) }}" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition duration-200 block text-center">
                        <i class="fas fa-edit mr-2"></i>Edit Data
                    </a>
                    
                    @if($doctor->status == 'aktif')
                        <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="nonaktif">
                            <button type="submit" class="w-full bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition duration-200"
                                    onclick="return confirm('Apakah Anda yakin ingin menonaktifkan dokter ini?')">
                                <i class="fas fa-pause mr-2"></i>Nonaktifkan
                            </button>
                        </form>
                    @else
                        <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="aktif">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200">
                                <i class="fas fa-play mr-2"></i>Aktifkan
                            </button>
                        </form>
                    @endif
                    
                    <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="w-full" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokter ini? Data ini tidak dapat dipulihkan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-trash mr-2"></i>Hapus Dokter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    @if(isset($stats))
    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Dokter</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="text-center">
                <div class="text-2xl font-bold text-blue-600">{{ $stats['total_visits'] ?? 0 }}</div>
                <div class="text-sm text-gray-600">Total Kunjungan</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-green-600">{{ $stats['this_month_visits'] ?? 0 }}</div>
                <div class="text-sm text-gray-600">Kunjungan Bulan Ini</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-yellow-600">{{ $stats['pending_visits'] ?? 0 }}</div>
                <div class="text-sm text-gray-600">Menunggu Konsultasi</div>
            </div>
            <div class="text-center">
                <div class="text-2xl font-bold text-purple-600">{{ $stats['completed_visits'] ?? 0 }}</div>
                <div class="text-sm text-gray-600">Selesai Konsultasi</div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
