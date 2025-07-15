@extends('layouts.app')

@section('title', 'Tambah Jadwal')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Tambah Jadwal Baru</h1>
                <p class="text-gray-600 mt-1">Buat jadwal praktik baru</p>
            </div>
            <a href="{{ route('doctor.schedules.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('doctor.schedules.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tanggal -->
                    <div>
                        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal <span class="text-red-500">*</span>
                        </label>
                        <input type="date" 
                               id="tanggal" 
                               name="tanggal" 
                               value="{{ old('tanggal') }}"
                               min="{{ date('Y-m-d') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('tanggal') border-red-500 @enderror"
                               required>
                        @error('tanggal')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select id="status" 
                                name="status" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror"
                                required>
                            <option value="">Pilih Status</option>
                            <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="tidak_tersedia" {{ old('status') == 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jam Mulai -->
                    <div>
                        <label for="jam_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                            Jam Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" 
                               id="jam_mulai" 
                               name="jam_mulai" 
                               value="{{ old('jam_mulai') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jam_mulai') border-red-500 @enderror"
                               required>
                        @error('jam_mulai')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jam Selesai -->
                    <div>
                        <label for="jam_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                            Jam Selesai <span class="text-red-500">*</span>
                        </label>
                        <input type="time" 
                               id="jam_selesai" 
                               name="jam_selesai" 
                               value="{{ old('jam_selesai') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('jam_selesai') border-red-500 @enderror"
                               required>
                        @error('jam_selesai')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="mt-6">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                        Keterangan
                    </label>
                    <textarea id="keterangan" 
                              name="keterangan" 
                              rows="4"
                              placeholder="Keterangan tambahan (opsional)"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('keterangan') border-red-500 @enderror">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('doctor.schedules.index') }}" 
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-save mr-2"></i>Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>

        <!-- Tips -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Tips Jadwal Praktik</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Pastikan jam mulai lebih awal dari jam selesai</li>
                            <li>Setiap slot jadwal memiliki durasi 30 menit untuk konsultasi</li>
                            <li>Anda dapat mengubah status jadwal menjadi tidak tersedia jika berhalangan</li>
                            <li>Pasien dapat melihat dan memilih jadwal yang tersedia untuk booking</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validation for end time
document.getElementById('jam_selesai').addEventListener('change', function() {
    const jamMulai = document.getElementById('jam_mulai').value;
    const jamSelesai = this.value;
    
    if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
        alert('Jam selesai harus lebih besar dari jam mulai');
        this.value = '';
    }
});

document.getElementById('jam_mulai').addEventListener('change', function() {
    const jamMulai = this.value;
    const jamSelesai = document.getElementById('jam_selesai').value;
    
    if (jamMulai && jamSelesai && jamSelesai <= jamMulai) {
        document.getElementById('jam_selesai').value = '';
    }
});
</script>
@endsection
