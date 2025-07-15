@extends('layouts.app')

@section('title', 'Edit Kunjungan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Edit Kunjungan</h1>
            <p class="text-gray-600 mt-1">ID Kunjungan: #{{ $visit->id }}</p>
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

            <form action="{{ route('admin.visits.update', $visit) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Patient Information (Read Only) -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pasien</h3>
                            <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                                <p><span class="font-medium">Nama:</span> {{ $visit->patient->nama_lengkap }}</p>
                                <p><span class="font-medium">NIK:</span> {{ $visit->patient->nik }}</p>
                                <p><span class="font-medium">Umur:</span> {{ \Carbon\Carbon::parse($visit->patient->tanggal_lahir)->age }} tahun</p>
                                <p><span class="font-medium">Telepon:</span> {{ $visit->patient->no_telepon ?? '-' }}</p>
                            </div>
                        </div>

                        <!-- Doctor -->
                        <div>
                            <label for="doctor_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Dokter <span class="text-red-500">*</span>
                            </label>
                            <select name="doctor_id" id="doctor_id" required 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" {{ $visit->doctor_id == $doctor->id ? 'selected' : '' }}>
                                    Dr. {{ $doctor->nama_lengkap }} - {{ $doctor->spesialis }}
                                </option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date and Time -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="tanggal_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan" required
                                       value="{{ $visit->tanggal_kunjungan->format('Y-m-d') }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('tanggal_kunjungan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="jam_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jam <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="jam_kunjungan" id="jam_kunjungan" required
                                       value="{{ $visit->jam_kunjungan ? \Carbon\Carbon::parse($visit->jam_kunjungan)->format('H:i') : '' }}"
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('jam_kunjungan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status" required 
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="menunggu" {{ $visit->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="sedang_diperiksa" {{ $visit->status == 'sedang_diperiksa' ? 'selected' : '' }}>Sedang Diperiksa</option>
                                <option value="selesai" {{ $visit->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="dibatalkan" {{ $visit->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Keluhan -->
                        <div>
                            <label for="keluhan_utama" class="block text-sm font-medium text-gray-700 mb-2">
                                Keluhan Utama <span class="text-red-500">*</span>
                            </label>
                            <textarea name="keluhan_utama" id="keluhan_utama" rows="4" required
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('keluhan_utama', $visit->keluhan_utama) }}</textarea>
                            @error('keluhan_utama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Riwayat Penyakit -->
                        <div>
                            <label for="riwayat_penyakit_kunjungan" class="block text-sm font-medium text-gray-700 mb-2">
                                Riwayat Penyakit Terkait
                            </label>
                            <textarea name="riwayat_penyakit_kunjungan" id="riwayat_penyakit_kunjungan" rows="3"
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('riwayat_penyakit_kunjungan', $visit->riwayat_penyakit_kunjungan) }}</textarea>
                            @error('riwayat_penyakit_kunjungan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Diagnosis -->
                        <div>
                            <label for="diagnosis" class="block text-sm font-medium text-gray-700 mb-2">
                                Diagnosis
                            </label>
                            <textarea name="diagnosis" id="diagnosis" rows="3"
                                      placeholder="Hasil diagnosis dari dokter..."
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('diagnosis', $visit->diagnosis) }}</textarea>
                            @error('diagnosis')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tindakan -->
                        <div>
                            <label for="tindakan" class="block text-sm font-medium text-gray-700 mb-2">
                                Tindakan Medis
                            </label>
                            <textarea name="tindakan" id="tindakan" rows="3"
                                      placeholder="Tindakan medis yang dilakukan..."
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('tindakan', $visit->tindakan) }}</textarea>
                            @error('tindakan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catatan -->
                        <div>
                            <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan Pasien
                            </label>
                            <textarea name="catatan" id="catatan" rows="3"
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('catatan', $visit->catatan) }}</textarea>
                            @error('catatan')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Catatan Dokter -->
                        <div>
                            <label for="catatan_dokter" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan Dokter
                            </label>
                            <textarea name="catatan_dokter" id="catatan_dokter" rows="3"
                                      placeholder="Catatan khusus dari dokter..."
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('catatan_dokter', $visit->catatan_dokter) }}</textarea>
                            @error('catatan_dokter')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Resep Obat Section -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Resep Obat</h3>
                        <button type="button" onclick="addMedicine()" 
                                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                            <i class="fas fa-plus mr-2"></i>Tambah Obat
                        </button>
                    </div>

                    <div id="medicineContainer">
                        @if($visit->obatVisits && $visit->obatVisits->count() > 0)
                            @foreach($visit->obatVisits as $index => $obatVisit)
                            <div class="medicine-row bg-gray-50 rounded-lg p-4 mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Obat</label>
                                        <select name="medicines[{{ $index }}][obat_id]" class="w-full rounded-md border-gray-300 shadow-sm">
                                            <option value="">Pilih Obat</option>
                                            @foreach($medicines as $medicine)
                                            <option value="{{ $medicine->id }}" {{ $obatVisit->obat_id == $medicine->id ? 'selected' : '' }}>
                                                {{ $medicine->nama_obat }} ({{ $medicine->stok }} {{ $medicine->satuan }})
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                                        <input type="number" name="medicines[{{ $index }}][jumlah]" 
                                               value="{{ $obatVisit->jumlah }}" min="1"
                                               class="w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Dosis</label>
                                        <input type="text" name="medicines[{{ $index }}][dosis]" 
                                               value="{{ $obatVisit->dosis }}"
                                               placeholder="3x1"
                                               class="w-full rounded-md border-gray-300 shadow-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Aturan Pakai</label>
                                        <div class="flex">
                                            <input type="text" name="medicines[{{ $index }}][aturan_pakai]" 
                                                   value="{{ $obatVisit->aturan_pakai }}"
                                                   placeholder="Sesudah makan"
                                                   class="flex-1 rounded-l-md border-gray-300 shadow-sm">
                                            <button type="button" onclick="removeMedicine(this)" 
                                                    class="bg-red-500 text-white px-3 py-2 rounded-r-md hover:bg-red-600">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex justify-between">
                    <a href="{{ route('admin.visits.show', $visit) }}" 
                       class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-400 transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    
                    <div class="space-x-3">
                        <button type="submit" 
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let medicineIndex = {{ $visit->obatVisits ? $visit->obatVisits->count() : 0 }};

function addMedicine() {
    const container = document.getElementById('medicineContainer');
    const medicineRow = document.createElement('div');
    medicineRow.className = 'medicine-row bg-gray-50 rounded-lg p-4 mb-4';
    
    medicineRow.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Obat</label>
                <select name="medicines[${medicineIndex}][obat_id]" class="w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Pilih Obat</option>
                    @foreach($medicines as $medicine)
                    <option value="{{ $medicine->id }}">{{ $medicine->nama_obat }} ({{ $medicine->stok }} {{ $medicine->satuan }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                <input type="number" name="medicines[${medicineIndex}][jumlah]" min="1" 
                       class="w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dosis</label>
                <input type="text" name="medicines[${medicineIndex}][dosis]" placeholder="3x1"
                       class="w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Aturan Pakai</label>
                <div class="flex">
                    <input type="text" name="medicines[${medicineIndex}][aturan_pakai]" placeholder="Sesudah makan"
                           class="flex-1 rounded-l-md border-gray-300 shadow-sm">
                    <button type="button" onclick="removeMedicine(this)" 
                            class="bg-red-500 text-white px-3 py-2 rounded-r-md hover:bg-red-600">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.appendChild(medicineRow);
    medicineIndex++;
}

function removeMedicine(button) {
    const row = button.closest('.medicine-row');
    row.remove();
}

// Auto-update datetime when status changes
document.getElementById('status').addEventListener('change', function() {
    const status = this.value;
    const now = new Date();
    
    // Update date and time for certain status changes
    if (status === 'sedang_diperiksa' || status === 'selesai') {
        const today = now.toISOString().split('T')[0];
        const currentTime = now.toTimeString().slice(0, 5);
        
        if (confirm('Update tanggal dan waktu ke sekarang?')) {
            document.getElementById('tanggal_kunjungan').value = today;
            document.getElementById('jam_kunjungan').value = currentTime;
        }
    }
});
</script>
@endpush
