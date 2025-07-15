@extends('layouts.app')

@section('title', 'Tambah Pasien')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Pasien Baru</h1>
        <a href="{{ route('admin.patients.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.patients.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Data Pribadi -->
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Pribadi</h3>
                </div>

                <div>
                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" 
                           class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_lengkap') border-red-500 @else border-gray-300 @enderror"
                           value="{{ old('nama_lengkap') }}" required>
                    @error('nama_lengkap')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                        NIK <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nik" id="nik" 
                           class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nik') border-red-500 @else border-gray-300 @enderror"
                           value="{{ old('nik') }}" maxlength="16" required>
                    @error('nik')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Lahir <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                           class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('tanggal_lahir') border-red-500 @else border-gray-300 @enderror"
                           value="{{ old('tanggal_lahir') }}" required>
                    @error('tanggal_lahir')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Kelamin <span class="text-red-500">*</span>
                    </label>
                    <select name="jenis_kelamin" id="jenis_kelamin" 
                            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jenis_kelamin') border-red-500 @else border-gray-300 @enderror" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="golongan_darah" class="block text-sm font-medium text-gray-700 mb-2">
                        Golongan Darah
                    </label>
                    <select name="golongan_darah" id="golongan_darah" 
                            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('golongan_darah') border-red-500 @else border-gray-300 @enderror">
                        <option value="">Pilih Golongan Darah</option>
                        <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                    </select>
                    @error('golongan_darah')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status_pernikahan" class="block text-sm font-medium text-gray-700 mb-2">
                        Status Pernikahan
                    </label>
                    <select name="status_pernikahan" id="status_pernikahan" 
                            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status_pernikahan') border-red-500 @else border-gray-300 @enderror">
                        <option value="">Pilih Status</option>
                        <option value="belum_menikah" {{ old('status_pernikahan') == 'belum_menikah' ? 'selected' : '' }}>Belum Menikah</option>
                        <option value="menikah" {{ old('status_pernikahan') == 'menikah' ? 'selected' : '' }}>Menikah</option>
                        <option value="cerai" {{ old('status_pernikahan') == 'cerai' ? 'selected' : '' }}>Cerai</option>
                        <option value="janda_duda" {{ old('status_pernikahan') == 'janda_duda' ? 'selected' : '' }}>Janda/Duda</option>
                    </select>
                    @error('status_pernikahan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kontak & Alamat -->
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 mt-6">Kontak & Alamat</h3>
                </div>

                <div>
                    <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-2">
                        No. Telepon <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" name="no_telepon" id="no_telepon" 
                           class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_telepon') border-red-500 @else border-gray-300 @enderror"
                           value="{{ old('no_telepon') }}" required>
                    @error('no_telepon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>
                    <input type="email" name="email" id="email" 
                           class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @else border-gray-300 @enderror"
                           value="{{ old('email') }}">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="lg:col-span-2">
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea name="alamat" id="alamat" rows="3"
                              class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alamat') border-red-500 @else border-gray-300 @enderror"
                              placeholder="Alamat lengkap dengan RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Informasi Medis -->
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 mt-6">Informasi Medis</h3>
                </div>

                <div class="lg:col-span-2">
                    <label for="riwayat_penyakit" class="block text-sm font-medium text-gray-700 mb-2">
                        Riwayat Penyakit
                    </label>
                    <textarea name="riwayat_penyakit" id="riwayat_penyakit" rows="3"
                              class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('riwayat_penyakit') border-red-500 @else border-gray-300 @enderror"
                              placeholder="Riwayat penyakit yang pernah diderita...">{{ old('riwayat_penyakit') }}</textarea>
                    @error('riwayat_penyakit')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="lg:col-span-2">
                    <label for="alergi" class="block text-sm font-medium text-gray-700 mb-2">
                        Alergi
                    </label>
                    <textarea name="alergi" id="alergi" rows="2"
                              class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alergi') border-red-500 @else border-gray-300 @enderror"
                              placeholder="Alergi obat, makanan, atau lainnya...">{{ old('alergi') }}</textarea>
                    @error('alergi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kontak Darurat -->
                <div class="lg:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2 mt-6">Kontak Darurat</h3>
                </div>

                <div>
                    <label for="kontak_darurat_nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kontak Darurat
                    </label>
                    <input type="text" name="kontak_darurat_nama" id="kontak_darurat_nama" 
                           class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kontak_darurat_nama') border-red-500 @else border-gray-300 @enderror"
                           value="{{ old('kontak_darurat_nama') }}">
                    @error('kontak_darurat_nama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="kontak_darurat_telepon" class="block text-sm font-medium text-gray-700 mb-2">
                        No. Telepon Kontak Darurat
                    </label>
                    <input type="tel" name="kontak_darurat_telepon" id="kontak_darurat_telepon" 
                           class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kontak_darurat_telepon') border-red-500 @else border-gray-300 @enderror"
                           value="{{ old('kontak_darurat_telepon') }}">
                    @error('kontak_darurat_telepon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="lg:col-span-2">
                    <label for="kontak_darurat_hubungan" class="block text-sm font-medium text-gray-700 mb-2">
                        Hubungan dengan Pasien
                    </label>
                    <select name="kontak_darurat_hubungan" id="kontak_darurat_hubungan" 
                            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('kontak_darurat_hubungan') border-red-500 @else border-gray-300 @enderror">
                        <option value="">Pilih Hubungan</option>
                        <option value="ayah" {{ old('kontak_darurat_hubungan') == 'ayah' ? 'selected' : '' }}>Ayah</option>
                        <option value="ibu" {{ old('kontak_darurat_hubungan') == 'ibu' ? 'selected' : '' }}>Ibu</option>
                        <option value="suami" {{ old('kontak_darurat_hubungan') == 'suami' ? 'selected' : '' }}>Suami</option>
                        <option value="istri" {{ old('kontak_darurat_hubungan') == 'istri' ? 'selected' : '' }}>Istri</option>
                        <option value="anak" {{ old('kontak_darurat_hubungan') == 'anak' ? 'selected' : '' }}>Anak</option>
                        <option value="saudara" {{ old('kontak_darurat_hubungan') == 'saudara' ? 'selected' : '' }}>Saudara</option>
                        <option value="lainnya" {{ old('kontak_darurat_hubungan') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('kontak_darurat_hubungan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('admin.patients.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-save mr-2"></i>Simpan Pasien
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Auto-generate No. Rekam Medis
document.addEventListener('DOMContentLoaded', function() {
    // Auto-calculate age from birth date
    const birthDateInput = document.getElementById('tanggal_lahir');
    
    birthDateInput.addEventListener('change', function() {
        const birthDate = new Date(this.value);
        const today = new Date();
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        
        console.log('Umur yang dihitung:', age);
    });
});
</script>
@endsection
