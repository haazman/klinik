@extends('layouts.app')

@section('title', 'Tambah Dokter')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Dokter Baru</h1>
        <a href="{{ route('admin.doctors.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
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

        <form action="{{ route('admin.doctors.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_lengkap" id="name" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('name') border-red-500 @enderror"
                           value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                           value="{{ old('email') }}" required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password" id="password" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror"
                           required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password <span class="text-red-500">*</span>
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                <div>
                    <label for="spesialisasi" class="block text-sm font-medium text-gray-700 mb-2">
                        Spesialisasi <span class="text-red-500">*</span>
                    </label>
                    <select name="spesialis" id="spesialisasi" 
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('spesialisasi') border-red-500 @enderror" required>
                        <option value="">Pilih Spesialisasi</option>
                        <option value="umum" {{ old('spesialisasi') == 'umum' ? 'selected' : '' }}>Dokter Umum</option>
                        <option value="kandungan" {{ old('spesialisasi') == 'kandungan' ? 'selected' : '' }}>Kandungan & Kebidanan</option>
                        <option value="anak" {{ old('spesialisasi') == 'anak' ? 'selected' : '' }}>Spesialis Anak</option>
                        <option value="penyakit_dalam" {{ old('spesialisasi') == 'penyakit_dalam' ? 'selected' : '' }}>Penyakit Dalam</option>
                        <option value="bedah" {{ old('spesialisasi') == 'bedah' ? 'selected' : '' }}>Bedah</option>
                        <option value="kulit" {{ old('spesialisasi') == 'kulit' ? 'selected' : '' }}>Kulit & Kelamin</option>
                        <option value="mata" {{ old('spesialisasi') == 'mata' ? 'selected' : '' }}>Mata</option>
                        <option value="tht" {{ old('spesialisasi') == 'tht' ? 'selected' : '' }}>THT</option>
                        <option value="jiwa" {{ old('spesialisasi') == 'jiwa' ? 'selected' : '' }}>Kesehatan Jiwa</option>
                        <option value="lainnya" {{ old('spesialisasi') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                           value="{{ old('pengalaman', 0) }}" required>
                    @error('pengalaman')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="no_sip" class="block text-sm font-medium text-gray-700 mb-2">
                        No. SIP (Surat Izin Praktik)
                    </label>
                    <input type="text" name="no_sip" id="no_sip" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_sip') border-red-500 @enderror"
                           value="{{ old('no_sip') }}">
                    @error('no_sip')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="no_telepon" class="block text-sm font-medium text-gray-700 mb-2">
                        No. Telepon
                    </label>
                    <input type="tel" name="no_telepon" id="no_telepon" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_telepon') border-red-500 @enderror"
                           value="{{ old('no_telepon') }}">
                    @error('no_telepon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="alamat_praktik" class="block text-sm font-medium text-gray-700 mb-2">
                    Alamat Praktik
                </label>
                <textarea name="alamat_praktik" id="alamat_praktik" rows="3"
                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alamat_praktik') border-red-500 @enderror">{{ old('alamat_praktik') }}</textarea>
                @error('alamat_praktik')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
    
            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('admin.doctors.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-save mr-2"></i>Simpan Dokter
                </button>
            </div>
        </form>
    </div>
</div>
@endsection