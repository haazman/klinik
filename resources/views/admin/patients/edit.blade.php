@extends('layouts.app')

@section('title', 'Edit Pasien')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit Pasien</h1>
            <p class="text-gray-600 mt-1">No. RM: {{ $patient->no_rekam_medis }}</p>
        </div>
        <a href="{{ route('admin.patients.show', $patient) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 overflow-hidden">
        <form action="{{ route('admin.patients.update', $patient) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 overflow-hidden">
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
                           value="{{ old('nama_lengkap', $patient->nama_lengkap) }}" required>
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
                           value="{{ old('nik', $patient->nik) }}" maxlength="16" required>
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
                           value="{{ old('tanggal_lahir', $patient->tanggal_lahir ? $patient->tanggal_lahir->format('Y-m-d') : '') }}" required>
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
                        <option value="L" {{ old('jenis_kelamin', $patient->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $patient->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
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
                        <option value="A" {{ old('golongan_darah', $patient->golongan_darah) == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('golongan_darah', $patient->golongan_darah) == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('golongan_darah', $patient->golongan_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('golongan_darah', $patient->golongan_darah) == 'O' ? 'selected' : '' }}>O</option>
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
                        <option value="belum_menikah" {{ old('status_pernikahan', $patient->status_pernikahan) == 'belum_menikah' ? 'selected' : '' }}>Belum Menikah</option>
                        <option value="menikah" {{ old('status_pernikahan', $patient->status_pernikahan) == 'menikah' ? 'selected' : '' }}>Menikah</option>
                        <option value="cerai" {{ old('status_pernikahan', $patient->status_pernikahan) == 'cerai' ? 'selected' : '' }}>Cerai</option>
                        <option value="janda_duda" {{ old('status_pernikahan', $patient->status_pernikahan) == 'janda_duda' ? 'selected' : '' }}>Janda/Duda</option>
                    </select>
                    @error('status_pernikahan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="pekerjaan" class="block text-sm font-medium text-gray-700 mb-2">
                        Pekerjaan
                    </label>
                    <input type="text" name="pekerjaan" id="pekerjaan" 
                           class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('pekerjaan') border-red-500 @else border-gray-300 @enderror"
                           value="{{ old('pekerjaan', $patient->pekerjaan) }}" placeholder="Masukkan pekerjaan">
                    @error('pekerjaan')
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
                           value="{{ old('no_telepon', $patient->no_telepon) }}" required>
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
                           value="{{ old('email', $patient->email) }}">
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
                              placeholder="Alamat lengkap dengan RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten" required>{{ old('alamat', $patient->alamat) }}</textarea>
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
                              placeholder="Riwayat penyakit yang pernah diderita...">{{ old('riwayat_penyakit', $patient->riwayat_penyakit) }}</textarea>
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
                              placeholder="Alergi obat, makanan, atau lainnya...">{{ old('alergi', $patient->alergi) }}</textarea>
                    @error('alergi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('admin.patients.show', $patient) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-save mr-2"></i>Update Pasien
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
