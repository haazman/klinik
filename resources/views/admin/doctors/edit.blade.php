@extends('layouts.app')

@section('title', 'Edit Dokter')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Dokter: {{ $doctor->name }}</h1>
        <a href="{{ route('admin.doctors.show', $doctor) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                <h4 class="font-semibold mb-2"><i class="fas fa-exclamation-circle mr-2"></i>Ada kesalahan:</h4>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.doctors.update', $doctor) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ old('name', $doctor->name) }}" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ old('email', $doctor->email) }}" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password Baru <small class="text-gray-500">(kosongkan jika tidak ingin mengubah)</small>
                    </label>
                    <input type="password" name="password" id="password" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password Baru
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label for="spesialisasi" class="block text-sm font-medium text-gray-700 mb-2">
                        Spesialisasi <span class="text-red-500">*</span>
                    </label>
                    <select name="spesialisasi" id="spesialisasi" 
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Pilih Spesialisasi</option>
                        <option value="umum" {{ old('spesialisasi', $doctor->spesialisasi) == 'umum' ? 'selected' : '' }}>Dokter Umum</option>
                        <option value="kandungan" {{ old('spesialisasi', $doctor->spesialisasi) == 'kandungan' ? 'selected' : '' }}>Kandungan & Kebidanan</option>
                        <option value="anak" {{ old('spesialisasi', $doctor->spesialisasi) == 'anak' ? 'selected' : '' }}>Spesialis Anak</option>
                        <option value="penyakit_dalam" {{ old('spesialisasi', $doctor->spesialisasi) == 'penyakit_dalam' ? 'selected' : '' }}>Penyakit Dalam</option>
                        <option value="bedah" {{ old('spesialisasi', $doctor->spesialisasi) == 'bedah' ? 'selected' : '' }}>Bedah</option>
                        <option value="kulit" {{ old('spesialisasi', $doctor->spesialisasi) == 'kulit' ? 'selected' : '' }}>Kulit & Kelamin</option>
                        <option value="mata" {{ old('spesialisasi', $doctor->spesialisasi) == 'mata' ? 'selected' : '' }}>Mata</option>
                        <option value="tht" {{ old('spesialisasi', $doctor->spesialisasi) == 'tht' ? 'selected' : '' }}>THT</option>
                        <option value="jiwa" {{ old('spesialisasi', $doctor->spesialisasi) == 'jiwa' ? 'selected' : '' }}>Kesehatan Jiwa</option>
                        <option value="lainnya" {{ old('spesialisasi', $doctor->spesialisasi) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('spesialisasi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="pengalaman" class="block text-sm font-medium text-gray-700 mb-2">
                        Pengalaman (Tahun) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="pengalaman" id="pengalaman" min="0" max="50"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('pengalaman') border-red-500 @enderror"
                           value="{{ old('pengalaman', $doctor->pengalaman) }}" required>
                    @error('pengalaman')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="telepon" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="telepon" id="telepon" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ old('telepon', $doctor->telepon) }}" required>
                    @error('telepon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="sip" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor SIP <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="sip" id="sip" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ old('sip', $doctor->sip) }}" required>
                    @error('sip')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="str" class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor STR
                    </label>
                    <input type="text" name="str" id="str" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ old('str', $doctor->str) }}">
                    @error('str')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tarif_konsultasi" class="block text-sm font-medium text-gray-700 mb-2">
                        Tarif Konsultasi (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="tarif_konsultasi" id="tarif_konsultasi" min="0"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           value="{{ old('tarif_konsultasi', $doctor->tarif_konsultasi) }}" required>
                    @error('tarif_konsultasi')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status
                    </label>
                    <select name="status" id="status" 
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="aktif" {{ old('status', $doctor->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $doctor->status) == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                    Alamat
                </label>
                <textarea name="alamat" id="alamat" rows="3"
                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Alamat lengkap dokter...">{{ old('alamat', $doctor->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('admin.doctors.show', $doctor) }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-save mr-2"></i>Update Dokter
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
