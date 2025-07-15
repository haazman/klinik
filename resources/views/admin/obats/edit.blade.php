@extends('layouts.app')

@section('title', 'Edit Obat')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Obat: {{ $obat->nama_obat }}</h1>
        <a href="{{ route('admin.obats.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.obats.update', $obat) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama_obat" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Obat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_obat" id="nama_obat" 
                           class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_obat') border-red-500 @else border-gray-300 @enderror"
                           value="{{ old('nama_obat', $obat->nama_obat) }}" required>
                    @error('nama_obat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">
                        Jenis Obat <span class="text-red-500">*</span>
                    </label>
                    <select name="jenis" id="jenis" 
                            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jenis') border-red-500 @else border-gray-300 @enderror" required>
                        <option value="">Pilih Jenis Obat</option>
                        <option value="tablet" {{ old('jenis', $obat->jenis) == 'tablet' ? 'selected' : '' }}>Tablet</option>
                        <option value="kapsul" {{ old('jenis', $obat->jenis) == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                        <option value="sirup" {{ old('jenis', $obat->jenis) == 'sirup' ? 'selected' : '' }}>Sirup</option>
                        <option value="salep" {{ old('jenis', $obat->jenis) == 'salep' ? 'selected' : '' }}>Salep</option>
                        <option value="injeksi" {{ old('jenis', $obat->jenis) == 'injeksi' ? 'selected' : '' }}>Injeksi</option>
                        <option value="lainnya" {{ old('jenis', $obat->jenis) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('satuan') border-red-500 @else border-gray-300 @enderror" required>
                        <option value="">Pilih Satuan</option>
                        <option value="strip" {{ old('satuan', $obat->satuan) == 'strip' ? 'selected' : '' }}>Strip</option>
                        <option value="botol" {{ old('satuan', $obat->satuan) == 'botol' ? 'selected' : '' }}>Botol</option>
                        <option value="tube" {{ old('satuan', $obat->satuan) == 'tube' ? 'selected' : '' }}>Tube</option>
                        <option value="vial" {{ old('satuan', $obat->satuan) == 'vial' ? 'selected' : '' }}>Vial</option>
                        <option value="ampul" {{ old('satuan', $obat->satuan) == 'ampul' ? 'selected' : '' }}>Ampul</option>
                        <option value="pcs" {{ old('satuan', $obat->satuan) == 'pcs' ? 'selected' : '' }}>Pcs</option>
                    </select>
                    @error('satuan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">
                        Stok Saat Ini
                    </label>
                    <input type="number" name="stok" id="stok" min="0"
                           class="w-full border rounded-md px-3 py-2 bg-gray-100 cursor-not-allowed" 
                           value="{{ $obat->stok }}" readonly>
                    <p class="text-sm text-gray-500 mt-1">Stok tidak dapat diubah dari sini. Gunakan fitur Stok Masuk.</p>
                </div>

                <div>
                    <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                        Harga (Rp) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="harga" id="harga" min="0" step="0.01"
                           class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('harga') border-red-500 @else border-gray-300 @enderror"
                           value="{{ old('harga', $obat->harga) }}" required>
                    @error('harga')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="stok_minimum" class="block text-sm font-medium text-gray-700 mb-2">
                        Stok Minimum <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="stok_minimum" id="stok_minimum" min="0"
                           class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('stok_minimum') border-red-500 @else border-gray-300 @enderror"
                           value="{{ old('stok_minimum', $obat->stok_minimum) }}" required>
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
                          class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('deskripsi') border-red-500 @else border-gray-300 @enderror"
                          placeholder="Deskripsi obat, kegunaan, atau informasi tambahan...">{{ old('deskripsi', $obat->deskripsi) }}</textarea>
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
                    <i class="fas fa-save mr-2"></i>Update Obat
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
