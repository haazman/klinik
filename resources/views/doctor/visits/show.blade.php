@extends('layouts.app')

@section('title', 'Detail Kunjungan Pasien')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Kunjungan</h1>
                <p class="text-gray-600 mt-1">ID Kunjungan: #{{ $visit->id }}</p>
            </div>
            <div class="flex space-x-3">
                @if($visit->status == 'sedang_diperiksa')
                <button onclick="showDiagnoseModal()" 
                        class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                    <i class="fas fa-stethoscope mr-2"></i>Buat Diagnosa
                </button>
                @endif
                <a href="{{ route('doctor.visits.index') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Patient Information -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Pasien</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Nama Lengkap</span>
                                <p class="text-gray-900 font-medium">{{ $visit->patient->nama_lengkap }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">NIK</span>
                                <p class="text-gray-900">{{ $visit->patient->nik }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Tanggal Lahir</span>
                                <p class="text-gray-900">
                                    {{ \Carbon\Carbon::parse($visit->patient->tanggal_lahir)->format('d F Y') }}
                                    ({{ \Carbon\Carbon::parse($visit->patient->tanggal_lahir)->age }} tahun)
                                </p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Jenis Kelamin</span>
                                <p class="text-gray-900">{{ $visit->patient->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-600">Telepon</span>
                                <p class="text-gray-900">{{ $visit->patient->telepon }}</p>
                            </div>
                            @if($visit->patient->email)
                            <div>
                                <span class="text-sm font-medium text-gray-600">Email</span>
                                <p class="text-gray-900">{{ $visit->patient->email }}</p>
                            </div>
                            @endif
                            <div>
                                <span class="text-sm font-medium text-gray-600">Golongan Darah</span>
                                <p class="text-gray-900">{{ $visit->patient->golongan_darah ?: '-' }}</p>
                            </div>
                            <div>
                                <span class="text-sm font-medium text-gray-600">Status</span>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $visit->status == 'selesai' ? 'bg-green-100 text-green-800' : 
                                       ($visit->status == 'sedang_diperiksa' ? 'bg-blue-100 text-blue-800' : 
                                       ($visit->status == 'menunggu' ? 'bg-yellow-100 text-yellow-800' : 
                                        'bg-red-100 text-red-800')) }}">
                                    {{ ucfirst($visit->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    @if($visit->patient->alamat)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <span class="text-sm font-medium text-gray-600">Alamat</span>
                        <p class="text-gray-900 mt-1">{{ $visit->patient->alamat }}</p>
                    </div>
                    @endif
                </div>

                <!-- Visit Information -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Detail Kunjungan</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <span class="text-sm font-medium text-gray-600">Tanggal & Waktu</span>
                            <p class="text-gray-900">{{ $visit->tanggal_kunjungan->format('d F Y, H:i') }} WIB</p>
                        </div>
                        <div>
                            <span class="text-sm font-medium text-gray-600">Dibuat Pada</span>
                            <p class="text-gray-900">{{ $visit->created_at->format('d F Y, H:i') }} WIB</p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Keluhan Utama</h4>
                            <div class="bg-red-50 border-l-4 border-red-400 p-4">
                                <p class="text-red-800">{{ $visit->keluhan_utama }}</p>
                            </div>
                        </div>

                        @if($visit->riwayat_penyakit_kunjungan)
                        <div>
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Riwayat Penyakit Terkait</h4>
                            <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                                <p class="text-blue-800">{{ $visit->riwayat_penyakit_kunjungan }}</p>
                            </div>
                        </div>
                        @endif

                        @if($visit->patient->riwayat_penyakit)
                        <div>
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Riwayat Penyakit Pasien</h4>
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                <p class="text-yellow-800">{{ $visit->patient->riwayat_penyakit }}</p>
                            </div>
                        </div>
                        @endif

                        @if($visit->catatan)
                        <div>
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Catatan Pasien</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-800">{{ $visit->catatan }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Medical Records -->
                @if($visit->diagnosis || $visit->tindakan || $visit->catatan_dokter)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Catatan Medis</h3>
                    
                    @if($visit->diagnosis)
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-600 mb-2">Diagnosa</h4>
                        <div class="bg-green-50 border-l-4 border-green-400 p-4">
                            <p class="text-green-800 font-medium">{{ $visit->diagnosis }}</p>
                        </div>
                    </div>
                    @endif

                    @if($visit->tindakan)
                    <div class="mb-4">
                        <h4 class="text-sm font-medium text-gray-600 mb-2">Tindakan Medis</h4>
                        <div class="bg-purple-50 border-l-4 border-purple-400 p-4">
                            <p class="text-purple-800">{{ $visit->tindakan }}</p>
                        </div>
                    </div>
                    @endif

                    @if($visit->catatan_dokter)
                    <div>
                        <h4 class="text-sm font-medium text-gray-600 mb-2">Catatan Dokter</h4>
                        <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                            <p class="text-blue-800">{{ $visit->catatan_dokter }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Prescription -->
                @if($visit->obatVisits && $visit->obatVisits->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Resep Obat</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Obat</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dosis</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aturan Pakai</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($visit->obatVisits as $obatVisit)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-pills text-green-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $obatVisit->obat->nama_obat }}</div>
                                                <div class="text-sm text-gray-500">{{ $obatVisit->obat->jenis }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $obatVisit->jumlah }} {{ $obatVisit->obat->satuan }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                        {{ $obatVisit->dosis }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-900">
                                        {{ $obatVisit->aturan_pakai }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        @if($visit->status == 'menunggu')
                        <button onclick="updateStatus('sedang_diperiksa')" 
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                            <i class="fas fa-play mr-2"></i>Mulai Konsultasi
                        </button>
                        @endif

                        @if($visit->status == 'sedang_diperiksa')
                        <button onclick="showDiagnoseModal()" 
                                class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                            <i class="fas fa-stethoscope mr-2"></i>Buat Diagnosa
                        </button>
                        @endif

                        <button onclick="window.print()" 
                                class="w-full bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-200">
                            <i class="fas fa-print mr-2"></i>Cetak Rekam Medis
                        </button>
                    </div>
                </div>

                <!-- Patient History -->
                @if($patientHistory->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Kunjungan</h3>
                    <div class="space-y-3 max-h-64 overflow-y-auto">
                        @foreach($patientHistory as $history)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-stethoscope text-blue-600 text-sm"></i>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $history->tanggal_kunjungan->format('d/m/Y') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ Str::limit($history->keluhan, 40) }}
                                </p>
                                @if($history->diagnosa)
                                <p class="text-xs text-green-600 mt-1">
                                    {{ Str::limit($history->diagnosa, 30) }}
                                </p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Next Appointment -->
                @if($nextAppointment)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-calendar-plus text-blue-400 mt-0.5"></i>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Janji Berikutnya</h3>
                            <p class="mt-1 text-sm text-blue-700">
                                {{ $nextAppointment->tanggal_kunjungan->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Diagnose Modal -->
<div id="diagnoseModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-5 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Buat Diagnosa dan Resep</h3>
            
            <form action="{{ route('doctor.visits.diagnose', $visit) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <div>
                            <label for="diagnosis" class="block text-sm font-medium text-gray-700 mb-2">
                                Diagnosa <span class="text-red-500">*</span>
                            </label>
                            <textarea name="diagnosis" id="diagnosis" rows="3" required
                                      placeholder="Masukkan diagnosa pasien..."
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $visit->diagnosis }}</textarea>
                        </div>

                        <div>
                            <label for="tindakan" class="block text-sm font-medium text-gray-700 mb-2">
                                Tindakan Medis
                            </label>
                            <textarea name="tindakan" id="tindakan" rows="3"
                                      placeholder="Tindakan yang dilakukan..."
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $visit->tindakan }}</textarea>
                        </div>

                        <div>
                            <label for="catatan_dokter" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan Dokter
                            </label>
                            <textarea name="catatan_dokter" id="catatan_dokter" rows="3"
                                      placeholder="Catatan khusus untuk pasien..."
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $visit->catatan_dokter }}</textarea>
                        </div>
                    </div>

                    <!-- Right Column - Prescription -->
                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <label class="block text-sm font-medium text-gray-700">Resep Obat</label>
                            <button type="button" onclick="addMedicine()" 
                                    class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                <i class="fas fa-plus mr-1"></i>Tambah
                            </button>
                        </div>
                        
                        <div id="medicineContainer" class="space-y-3 max-h-80 overflow-y-auto">
                            @if($visit->obatVisits && $visit->obatVisits->count() > 0)
                                @foreach($visit->obatVisits as $index => $obatVisit)
                                <div class="medicine-row bg-gray-50 rounded-lg p-3">
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <select name="medicines[{{ $index }}][obat_id]" class="w-full text-sm rounded-md border-gray-300">
                                                <option value="">Pilih Obat</option>
                                                @foreach($medicines as $medicine)
                                                <option value="{{ $medicine->id }}" {{ $obatVisit->obat_id == $medicine->id ? 'selected' : '' }}>
                                                    {{ $medicine->nama_obat }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="flex">
                                            <input type="number" name="medicines[{{ $index }}][jumlah]" 
                                                   value="{{ $obatVisit->jumlah }}" min="1" placeholder="Qty"
                                                   class="flex-1 text-sm rounded-l-md border-gray-300">
                                            <button type="button" onclick="removeMedicine(this)" 
                                                    class="bg-red-500 text-white px-2 rounded-r-md hover:bg-red-600">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                        <div>
                                            <input type="text" name="medicines[{{ $index }}][dosis]" 
                                                   value="{{ $obatVisit->dosis }}" placeholder="Dosis (3x1)"
                                                   class="w-full text-sm rounded-md border-gray-300">
                                        </div>
                                        <div>
                                            <input type="text" name="medicines[{{ $index }}][aturan_pakai]" 
                                                   value="{{ $obatVisit->aturan_pakai }}" placeholder="Sesudah makan"
                                                   class="w-full text-sm rounded-md border-gray-300">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6 pt-4 border-t">
                    <button type="button" onclick="closeDiagnoseModal()" 
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        Simpan & Selesaikan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let medicineIndex = {{ $visit->obatVisits ? $visit->obatVisits->count() : 0 }};

function showDiagnoseModal() {
    document.getElementById('diagnoseModal').classList.remove('hidden');
}

function closeDiagnoseModal() {
    document.getElementById('diagnoseModal').classList.add('hidden');
}

function addMedicine() {
    const container = document.getElementById('medicineContainer');
    const medicineRow = document.createElement('div');
    medicineRow.className = 'medicine-row bg-gray-50 rounded-lg p-3';
    
    medicineRow.innerHTML = `
        <div class="grid grid-cols-2 gap-2">
            <div>
                <select name="medicines[${medicineIndex}][obat_id]" class="w-full text-sm rounded-md border-gray-300">
                    <option value="">Pilih Obat</option>
                    @foreach($medicines as $medicine)
                    <option value="{{ $medicine->id }}">{{ $medicine->nama_obat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex">
                <input type="number" name="medicines[${medicineIndex}][jumlah]" min="1" placeholder="Qty"
                       class="flex-1 text-sm rounded-l-md border-gray-300">
                <button type="button" onclick="removeMedicine(this)" 
                        class="bg-red-500 text-white px-2 rounded-r-md hover:bg-red-600">
                    <i class="fas fa-trash text-xs"></i>
                </button>
            </div>
            <div>
                <input type="text" name="medicines[${medicineIndex}][dosis]" placeholder="Dosis (3x1)"
                       class="w-full text-sm rounded-md border-gray-300">
            </div>
            <div>
                <input type="text" name="medicines[${medicineIndex}][aturan_pakai]" placeholder="Sesudah makan"
                       class="w-full text-sm rounded-md border-gray-300">
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

function updateStatus(status) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("doctor.visits.updateStatus", $visit) }}';
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'PUT';
    form.appendChild(methodInput);
    
    const statusInput = document.createElement('input');
    statusInput.type = 'hidden';
    statusInput.name = 'status';
    statusInput.value = status;
    form.appendChild(statusInput);
    
    document.body.appendChild(form);
    form.submit();
}

// Close modal when clicking outside
document.getElementById('diagnoseModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDiagnoseModal();
    }
});
</script>
@endpush
