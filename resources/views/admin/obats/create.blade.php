@extends('layouts.app')

@section('title', 'Tambah Obat')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Tambah Obat Baru</h1>
        <a href="{{ route('admin.obats.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
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

        <form action="{{ route('admin.obats.store') }}" method="POST"
              onsubmit="console.log('Form submitted'); return true;">>
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama_obat" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Obat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_obat" id="nama_obat" 
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_obat') border-red-500 @enderror"
                           value="{{ old('nama_obat') }}" required>
                    @error('nama_obat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Obat <span class="text-red-500">*</span>
                    </label>
                    <select name="jenis" id="jenis" 
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jenis') border-red-500 @enderror" required>
                        <option value="">Pilih Jenis Obat</option>
                        <option value="tablet" {{ old('jenis') == 'tablet' ? 'selected' : '' }}>Tablet</option>
                        <option value="kapsul" {{ old('jenis') == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                        <option value="sirup" {{ old('jenis') == 'sirup' ? 'selected' : '' }}>Sirup</option>
                        <option value="salep" {{ old('jenis') == 'salep' ? 'selected' : '' }}>Salep</option>
                        <option value="injeksi" {{ old('jenis') == 'injeksi' ? 'selected' : '' }}>Injeksi</option>
                        <option value="lainnya" {{ old('jenis') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('jenis')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="satuan" class="block text-sm font-medium text-gray-700 mb-2">
                        Satuan <span class="text-red-500">*</span>
                    </label>
                    <select name="satuan" id="satuan" 
                            class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('satuan') border-red-500 @enderror" required>
                        <option value="">Pilih Satuan</option>
                        <option value="strip" {{ old('satuan') == 'strip' ? 'selected' : '' }}>Strip</option>
                        <option value="botol" {{ old('satuan') == 'botol' ? 'selected' : '' }}>Botol</option>
                        <option value="tube" {{ old('satuan') == 'tube' ? 'selected' : '' }}>Tube</option>
                        <option value="vial" {{ old('satuan') == 'vial' ? 'selected' : '' }}>Vial</option>
                        <option value="ampul" {{ old('satuan') == 'ampul' ? 'selected' : '' }}>Ampul</option>
                        <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                    </select>
                    @error('satuan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">
                        Stok Awal <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stok" id="stok" min="0"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('stok') border-red-500 @enderror"
                           value="{{ old('stok', 0) }}" required>
                    @error('stok')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                        Harga (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="harga" id="harga" min="0" step="0.01"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('harga') border-red-500 @enderror"
                           value="{{ old('harga') }}" required>
                    @error('harga')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stok_minimum" class="block text-sm font-medium text-gray-700 mb-2">
                        Stok Minimum <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stok_minimum" id="stok_minimum" min="0"
                           class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('stok_minimum') border-red-500 @enderror"
                           value="{{ old('stok_minimum', 10) }}" required>
                    @error('stok_minimum')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi
                </label>
                <textarea name="deskripsi" id="deskripsi" rows="3"
                          class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('deskripsi') border-red-500 @enderror"
                          placeholder="Deskripsi obat, kegunaan, atau informasi tambahan...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('admin.obats.index') }}" 
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-save mr-2"></i>Simpan Obat
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
