@extends('layouts.admin')

@section('title', 'Buat Kunjungan Baru')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.visits.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Buat Kunjungan Baru</h1>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <form action="{{ route('admin.visits.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Patient Selection -->
                    <div>
                        <label for="patient_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Pasien <span class="text-red-500">*</span>
                        </label>
                        <select name="patient_id" id="patient_id" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Pasien --</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}" {{ $selectedPatientId == $patient->id ? 'selected' : '' }}>
                                    {{ $patient->nama_lengkap }} ({{ $patient->user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('patient_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Doctor Selection -->
                    <div>
                        <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Dokter <span class="text-red-500">*</span>
                        </label>
                        <select name="doctor_id" id="doctor_id" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">-- Pilih Dokter --</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">
                                    {{ $doctor->nama_lengkap }} - {{ $doctor->spesialis }}
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Visit Date -->
                    <div>
                        <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Kunjungan <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" 
                               value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('tanggal_kunjungan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Visit Time -->
                    <div>
                        <label for="jam_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                            Jam Kunjungan <span class="text-red-500">*</span>
                        </label>
                        <input type="time" name="jam_kunjungan" id="jam_kunjungan" 
                               value="{{ old('jam_kunjungan') }}" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('jam_kunjungan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="menunggu" {{ old('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="sedang_diperiksa" {{ old('status') == 'sedang_diperiksa' ? 'selected' : '' }}>Sedang Diperiksa</option>
                            <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ old('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Consultation Fee -->
                    <div>
                        <label for="biaya_konsultasi" class="block text-sm font-medium text-gray-700 mb-2">
                            Biaya Konsultasi <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="biaya_konsultasi" id="biaya_konsultasi" 
                               value="{{ old('biaya_konsultasi', 0) }}" min="0" step="1000" required
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('biaya_konsultasi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Main Complaint -->
                <div>
                    <label for="keluhan_utama" class="block text-sm font-medium text-gray-700 mb-2">
                        Keluhan Utama <span class="text-red-500">*</span>
                    </label>
                    <textarea name="keluhan_utama" id="keluhan_utama" rows="3" required
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Masukkan keluhan utama pasien...">{{ old('keluhan_utama') }}</textarea>
                    @error('keluhan_utama')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Examination Results -->
                <div>
                    <label for="hasil_pemeriksaan" class="block text-sm font-medium text-gray-700 mb-2">
                        Hasil Pemeriksaan
                    </label>
                    <textarea name="hasil_pemeriksaan" id="hasil_pemeriksaan" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Masukkan hasil pemeriksaan...">{{ old('hasil_pemeriksaan') }}</textarea>
                    @error('hasil_pemeriksaan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Diagnosis -->
                <div>
                    <label for="diagnosis" class="block text-sm font-medium text-gray-700 mb-2">
                        Diagnosis
                    </label>
                    <textarea name="diagnosis" id="diagnosis" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Masukkan diagnosis...">{{ old('diagnosis') }}</textarea>
                    @error('diagnosis')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Treatment -->
                <div>
                    <label for="tindakan" class="block text-sm font-medium text-gray-700 mb-2">
                        Tindakan
                    </label>
                    <textarea name="tindakan" id="tindakan" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Masukkan tindakan yang dilakukan...">{{ old('tindakan') }}</textarea>
                    @error('tindakan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Advice -->
                <div>
                    <label for="saran" class="block text-sm font-medium text-gray-700 mb-2">
                        Saran
                    </label>
                    <textarea name="saran" id="saran" rows="3"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Masukkan saran untuk pasien...">{{ old('saran') }}</textarea>
                    @error('saran')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 pt-6">
                    <a href="{{ route('admin.visits.index') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200">
                        <i class="fas fa-save mr-2"></i>Simpan Kunjungan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
