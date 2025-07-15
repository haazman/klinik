@extends('layouts.app')

@section('title', 'Detail Pasien')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Detail Pasien</h1>
            <p class="text-gray-600 mt-1">No. RM: {{ $patient->no_rekam_medis }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.patients.edit', $patient) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.patients.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Personal Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Pribadi</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Nama Lengkap</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $patient->nama_lengkap }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">NIK</label>
                        <p class="text-gray-800">{{ $patient->nik }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Tanggal Lahir</label>
                        <p class="text-gray-800">{{ $patient->tanggal_lahir ? $patient->tanggal_lahir->format('d/m/Y') : 'Belum diisi' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Umur</label>
                        <p class="text-gray-800">{{ $patient->umur }} tahun</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Jenis Kelamin</label>
                        <span class="px-2 py-1 text-sm rounded-full {{ $patient->jenis_kelamin == 'P' ? 'bg-pink-100 text-pink-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $patient->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-laki' }}
                        </span>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Golongan Darah</label>
                        <p class="text-gray-800">{{ $patient->golongan_darah ?: '-' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Status Pernikahan</label>
                        <p class="text-gray-800 capitalize">{{ str_replace('_', ' ', $patient->status_pernikahan ?: '-') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Terdaftar</label>
                        <p class="text-gray-800">{{ $patient->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Kontak & Alamat</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">No. Telepon</label>
                        <p class="text-gray-800">{{ $patient->no_telepon }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Email</label>
                        <p class="text-gray-800">{{ $patient->email ?: '-' }}</p>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-600">Alamat</label>
                        <p class="text-gray-800">{{ $patient->alamat }}</p>
                    </div>
                </div>
            </div>

            <!-- Medical Information -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Medis</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Riwayat Penyakit</label>
                        <p class="text-gray-800">{{ $patient->riwayat_penyakit ?: 'Tidak ada riwayat penyakit yang tercatat' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Alergi</label>
                        <p class="text-gray-800">{{ $patient->alergi ?: 'Tidak ada alergi yang tercatat' }}</p>
                    </div>
                </div>
            </div>

            <!-- Emergency Contact -->
            @if($patient->kontak_darurat_nama)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Kontak Darurat</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Nama</label>
                        <p class="text-gray-800">{{ $patient->kontak_darurat_nama }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">No. Telepon</label>
                        <p class="text-gray-800">{{ $patient->kontak_darurat_telepon }}</p>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-600">Hubungan</label>
                        <p class="text-gray-800 capitalize">{{ str_replace('_', ' ', $patient->kontak_darurat_hubungan) }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Kunjungan</span>
                        <span class="font-semibold text-blue-600">{{ $patient->visits->count() }}</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Kunjungan Bulan Ini</span>
                        <span class="font-semibold text-green-600">
                            {{ $patient->visits->where('created_at', '>=', now()->startOfMonth())->count() }}
                        </span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Kunjungan Terakhir</span>
                        <span class="text-gray-800">
                            {{ $patient->visits->last() ? $patient->visits->last()->tanggal_kunjungan->format('d/m/Y') : 'Belum ada' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Account Status -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Akun</h3>
                
                @if($patient->user)
                    <div class="bg-green-50 border-l-4 border-green-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    Pasien sudah terdaftar sebagai user sistem dengan email: 
                                    <strong>{{ $patient->user->email }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Pasien belum terdaftar sebagai user sistem.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <button onclick="createUserAccount()" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-user-plus mr-2"></i>Buat Akun User
                    </button>
                @endif
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                
                <div class="space-y-3">
                    <a href="{{ route('visits.create', ['patient_id' => $patient->id]) }}" 
                       class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 block text-center">
                        <i class="fas fa-plus mr-2"></i>Buat Kunjungan
                    </a>
                    
                    <a href="{{ route('admin.patients.edit', $patient) }}" 
                       class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition duration-200 block text-center">
                        <i class="fas fa-edit mr-2"></i>Edit Data
                    </a>
                    
                    <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST" class="w-full" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus pasien ini? Semua data kunjungan akan ikut terhapus.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-trash mr-2"></i>Hapus Pasien
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Visit History -->
    @if($patient->visits->count() > 0)
    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Kunjungan Terakhir</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dokter</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keluhan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnosis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($patient->visits->take(5) as $visit)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $visit->tanggal_kunjungan->format('d/m/Y') }}
                            @if($visit->jam_kunjungan)
                                <br><span class="text-xs text-gray-500">{{ $visit->jam_kunjungan }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $visit->doctor->nama_lengkap }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">
                            {{ $visit->keluhan_utama }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate">
                            {{ $visit->diagnosis }}
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
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('visits.show', $visit) }}" 
                               class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($patient->visits->count() > 5)
        <div class="mt-4 text-center">
            <a href="{{ route('visits.index', ['patient_id' => $patient->id]) }}" class="text-blue-600 hover:text-blue-800">
                Lihat semua kunjungan →
            </a>
        </div>
        @endif
    </div>
    @endif
</div>

<script>
function createUserAccount() {
    if (confirm('Apakah Anda yakin ingin membuat akun user untuk pasien ini?')) {
        // Here you can implement the logic to create user account
        alert('Fitur ini akan segera tersedia');
    }
}
</script>
@endsection
