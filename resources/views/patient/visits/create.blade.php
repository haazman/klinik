@extends('layouts.app')

@section('title', 'Buat Janji Temu')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Buat Janji Temu</h1>
            <p class="text-gray-600 mt-1">Jadwalkan konsultasi dengan dokter</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle text-red-400 mt-0.5"></i>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat beberapa error:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('patient.visits.store') }}" method="POST" id="visitForm">
                @csrf
                
                <!-- Pilih Dokter -->
                <div class="mb-6">
                    <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Dokter <span class="text-red-500">*</span>
                    </label>
                    <select name="doctor_id" id="doctor_id" required 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            onchange="loadDoctorSchedule()">
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ old('doctor_id', $selectedDoctorId) == $doctor->id ? 'selected' : '' }}>
                            Dr. {{ $doctor->name }} - {{ $doctor->spesialisasi }}
                        </option>
                        @endforeach
                    </select>
                    @error('doctor_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Dokter -->
                <div id="doctorInfo" class="hidden mb-6 p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-start">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-md text-blue-600"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <h4 class="font-medium text-blue-900" id="doctorName"></h4>
                            <p class="text-sm text-blue-700" id="doctorSpecialization"></p>
                            <p class="text-sm text-blue-600 mt-1" id="doctorExperience"></p>
                        </div>
                    </div>
                </div>

                <!-- Tanggal Kunjungan -->
                <div class="mb-6">
                    <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Kunjungan <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" required
                           min="{{ date('Y-m-d') }}" 
                           value="{{ old('tanggal_kunjungan', $selectedDate) }}"
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           onchange="loadAvailableSlots()">
                    @error('tanggal_kunjungan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jam Tersedia -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Jam <span class="text-red-500">*</span>
                    </label>
                    <div id="availableSlots" class="grid grid-cols-3 gap-2">
                        <div class="col-span-3 text-center text-gray-500 py-4">
                            Pilih dokter dan tanggal terlebih dahulu
                        </div>
                    </div>
                    <input type="hidden" name="jam_kunjungan" id="selectedTime" value="{{ old('jam_kunjungan') }}">
                    @error('jam_kunjungan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Keluhan -->
                <div class="mb-6">
                    <label for="keluhan" class="block text-sm font-medium text-gray-700 mb-2">
                        Keluhan / Gejala <span class="text-red-500">*</span>
                    </label>
                    <textarea name="keluhan" id="keluhan" rows="4" required
                              placeholder="Jelaskan keluhan atau gejala yang Anda alami..."
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('keluhan') }}</textarea>
                    @error('keluhan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Riwayat Penyakit -->
                <div class="mb-6">
                    <label for="riwayat_penyakit_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                        Riwayat Penyakit Terkait (Opsional)
                    </label>
                    <textarea name="riwayat_penyakit_kunjungan" id="riwayat_penyakit_kunjungan" rows="3"
                              placeholder="Jelaskan riwayat penyakit yang berhubungan dengan keluhan saat ini..."
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('riwayat_penyakit_kunjungan') }}</textarea>
                    @error('riwayat_penyakit_kunjungan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catatan Tambahan -->
                <div class="mb-6">
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan Tambahan (Opsional)
                    </label>
                    <textarea name="catatan" id="catatan" rows="2"
                              placeholder="Catatan tambahan untuk dokter..."
                              class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Info Penting -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 mb-6">
                    <div class="flex">
                        <i class="fas fa-info-circle text-yellow-400 mt-0.5"></i>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Informasi Penting:</h3>
                            <ul class="mt-2 text-sm text-yellow-700 list-disc list-inside space-y-1">
                                <li>Harap datang 15 menit sebelum jam konsultasi</li>
                                <li>Bawa kartu identitas dan kartu BPJS (jika ada)</li>
                                <li>Pembatalan dapat dilakukan maksimal H-1</li>
                                <li>Biaya konsultasi: Rp 50.000</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-between">
                    <a href="{{ route('patient.visits.index') }}" 
                       class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-calendar-check mr-2"></i>Buat Janji Temu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Data dokter untuk JavaScript
const doctorsData = @json($doctors->keyBy('id'));

function loadDoctorSchedule() {
    const doctorId = document.getElementById('doctor_id').value;
    const doctorInfo = document.getElementById('doctorInfo');
    
    if (doctorId && doctorsData[doctorId]) {
        const doctor = doctorsData[doctorId];
        
        document.getElementById('doctorName').textContent = `Dr. ${doctor.user?.name || doctor.name || 'N/A'}`;
        document.getElementById('doctorSpecialization').textContent = doctor.spesialisasi || 'Umum';
        document.getElementById('doctorExperience').textContent = `Pengalaman: ${doctor.pengalaman || 0} tahun`;
        
        doctorInfo.classList.remove('hidden');
        
        // Reset jam yang tersedia
        loadAvailableSlots();
    } else {
        doctorInfo.classList.add('hidden');
        document.getElementById('availableSlots').innerHTML = `
            <div class="col-span-3 text-center text-gray-500 py-4">
                Pilih dokter dan tanggal terlebih dahulu
            </div>
        `;
    }
}

function loadAvailableSlots() {
    const doctorId = document.getElementById('doctor_id').value;
    const tanggal = document.getElementById('tanggal_kunjungan').value;
    const slotsContainer = document.getElementById('availableSlots');
    
    if (!doctorId || !tanggal) {
        slotsContainer.innerHTML = `
            <div class="col-span-3 text-center text-gray-500 py-4">
                Pilih dokter dan tanggal terlebih dahulu
            </div>
        `;
        return;
    }
    
    // Show loading
    slotsContainer.innerHTML = `
        <div class="col-span-3 text-center text-gray-500 py-4">
            <i class="fas fa-spinner fa-spin mr-2"></i>Memuat jadwal...
        </div>
    `;
    
    // Fetch available slots
    fetch(`/available-slots?doctor_id=${doctorId}&date=${tanggal}`)
        .then(response => response.json())
        .then(data => {
            if (data.slots && data.slots.length > 0) {
                let slotsHtml = '';
                data.slots.forEach(slot => {
                    slotsHtml += `
                        <button type="button" 
                                class="time-slot px-3 py-2 border rounded-md text-sm hover:bg-blue-50 hover:border-blue-300 transition duration-200" 
                                onclick="selectTimeSlot('${slot.time}', this)">
                            ${slot.display}
                        </button>
                    `;
                });
                slotsContainer.innerHTML = slotsHtml;
            } else {
                slotsContainer.innerHTML = `
                    <div class="col-span-3 text-center text-gray-500 py-4">
                        <i class="fas fa-calendar-times text-2xl mb-2"></i><br>
                        Tidak ada jadwal tersedia untuk tanggal ini
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            slotsContainer.innerHTML = `
                <div class="col-span-3 text-center text-red-500 py-4">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Gagal memuat jadwal
                </div>
            `;
        });
}

function selectTimeSlot(time, button) {
    // Remove selection from all buttons
    document.querySelectorAll('.time-slot').forEach(btn => {
        btn.classList.remove('bg-blue-500', 'text-white', 'border-blue-500');
        btn.classList.add('hover:bg-blue-50', 'hover:border-blue-300');
    });
    
    // Add selection to clicked button
    button.classList.add('bg-blue-500', 'text-white', 'border-blue-500');
    button.classList.remove('hover:bg-blue-50', 'hover:border-blue-300');
    
    // Set hidden input value
    document.getElementById('selectedTime').value = time;
}

// Form validation
document.getElementById('visitForm').addEventListener('submit', function(e) {
    const selectedTime = document.getElementById('selectedTime').value;
    
    if (!selectedTime) {
        e.preventDefault();
        alert('Silakan pilih jam kunjungan terlebih dahulu');
        return false;
    }
});

// Load initial data if form has old values
document.addEventListener('DOMContentLoaded', function() {
    const doctorId = document.getElementById('doctor_id').value;
    if (doctorId) {
        loadDoctorSchedule();
        
        const tanggal = document.getElementById('tanggal_kunjungan').value;
        if (tanggal) {
            setTimeout(() => {
                loadAvailableSlots();
                
                // Select old time if exists
                const oldTime = '{{ old('jam_kunjungan') }}';
                if (oldTime) {
                    setTimeout(() => {
                        const timeButton = Array.from(document.querySelectorAll('.time-slot'))
                            .find(btn => btn.textContent.trim() === oldTime);
                        if (timeButton) {
                            selectTimeSlot(oldTime, timeButton);
                        }
                    }, 1000);
                }
            }, 500);
        }
    }
});
</script>
@endpush
