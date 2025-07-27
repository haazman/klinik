@extends('layouts.app')

@section('title', 'Detail Kunjungan')

@section('content')                @if($visit->diagnosis)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Diagnosa</h3>
                    <div class="bg-green-50 rounded-lg p-4">
                        <p class="text-green-800 font-medium">{{ $visit->diagnosis }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<div class="container mx-auto px-4 py-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Kunjungan</h1>
                <p class="text-gray-600 mt-1">ID Kunjungan: #{{ $visit->id }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.visits.edit', $visit) }}" 
                   class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit
                </a>
                <button onclick="printVisit()" 
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                    <i class="fas fa-print mr-2"></i>Cetak
                </button>
                <a href="{{ route('admin.visits.index') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-start mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">Informasi Kunjungan</h2>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            {{ $visit->status == 'selesai' ? 'bg-green-100 text-green-800' : 
                               ($visit->status == 'sedang_diperiksa' ? 'bg-blue-100 text-blue-800' : 
                               ($visit->status == 'menunggu' ? 'bg-yellow-100 text-yellow-800' : 
                                'bg-red-100 text-red-800')) }}">
                            {{ ucfirst($visit->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Informasi Pasien</h4>
                            <div class="space-y-2">
                                <p><span class="font-medium">Nama:</span> {{ $visit->patient->nama_lengkap }}</p>
                                <p><span class="font-medium">NIK:</span> {{ $visit->patient->nik }}</p>
                                <p><span class="font-medium">Umur:</span> {{ \Carbon\Carbon::parse($visit->patient->tanggal_lahir)->age }} tahun</p>
                                <p><span class="font-medium">Jenis Kelamin:</span> {{ $visit->patient->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                <p><span class="font-medium">Telepon:</span> {{ $visit->patient->telepon }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Informasi Kunjungan</h4>
                            <div class="space-y-2">
                                <p><span class="font-medium">Tanggal:</span> {{ $visit->tanggal_kunjungan->format('d F Y') }}</p>
                                <p><span class="font-medium">Waktu:</span> {{ $visit->tanggal_kunjungan->format('H:i') }} WIB</p>
                                <p><span class="font-medium">Dokter:</span> Dr. {{ $visit->doctor->nama_lengkap }}</p>
                                <p><span class="font-medium">Spesialisasi:</span> {{ $visit->doctor->spesialisasi }}</p>
                                <p><span class="font-medium">Dibuat:</span> {{ $visit->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keluhan -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Keluhan Pasien</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-800">{{ $visit->keluhan_utama }}</p>
                    </div>
                </div>

                <!-- Riwayat Penyakit -->
                @if($visit->riwayat_penyakit_kunjungan)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Penyakit Terkait</h3>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-blue-800">{{ $visit->riwayat_penyakit_kunjungan }}</p>
                    </div>
                </div>
                @endif

                <!-- Diagnosa -->
                @if($visit->diagnosa)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Diagnosa</h3>
                    <div class="bg-green-50 border-l-4 border-green-400 p-4">
                        <p class="text-green-800 font-medium">{{ $visit->diagnosa }}</p>
                    </div>
                </div>
                @endif

                <!-- Tindakan -->
                @if($visit->tindakan)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Tindakan Medis</h3>
                    <div class="bg-purple-50 rounded-lg p-4">
                        <p class="text-purple-800">{{ $visit->tindakan }}</p>
                    </div>
                </div>
                @endif

                <!-- Resep Obat -->
                @if($visit->obatVisits && $visit->obatVisits->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Resep Obat</h3>
                        <span class="text-sm text-gray-500">{{ $visit->obatVisits->count() }} item</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Obat</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dosis</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aturan Pakai</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
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
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ number_format($obatVisit->obat->harga * $obatVisit->jumlah, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-right text-sm font-medium text-gray-900">
                                        Total Biaya Obat:
                                    </td>
                                    <td class="px-4 py-3 text-sm font-bold text-gray-900">
                                        Rp {{ number_format($visit->obatVisits->sum(function($item) { return $item->obat->harga * $item->jumlah; }), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @endif

                <!-- Catatan -->
                @if($visit->catatan)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Catatan Pasien</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-800">{{ $visit->catatan }}</p>
                    </div>
                </div>
                @endif

                <!-- Catatan Dokter -->
                @if($visit->catatan_dokter)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Catatan Dokter</h3>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-blue-800">{{ $visit->catatan_dokter }}</p>
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
                        <button onclick="updateStatus('selesai')" 
                                class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                            <i class="fas fa-check mr-2"></i>Selesaikan
                        </button>
                        @endif

                        @if($visit->status == 'menunggu')
                        <button onclick="updateStatus('dibatalkan')" 
                                class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200">
                            <i class="fas fa-times mr-2"></i>Batalkan
                        </button>
                        @endif

                        <a href="{{ route('admin.visits.edit', $visit) }}" 
                           class="w-full bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition duration-200 inline-block text-center">
                            <i class="fas fa-edit mr-2"></i>Edit Detail
                        </a>
                    </div>
                </div>

                <!-- Visit Statistics -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik Pasien</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Kunjungan</span>
                            <span class="font-medium">{{ $patientStats['total_visits'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Kunjungan Bulan Ini</span>
                            <span class="font-medium">{{ $patientStats['monthly_visits'] }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Terakhir Berkunjung</span>
                            <span class="font-medium text-sm">
                                @if($patientStats['last_visit'])
                                    {{ $patientStats['last_visit']->format('d/m/Y') }}
                                @else
                                    Pertama kali
                                @endif
                            </span>
                        </div>
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
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full 
                                {{ $history->status == 'selesai' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($history->status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Contact Information -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Kontak</h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <i class="fas fa-phone text-gray-400 w-5"></i>
                            <span class="ml-3 text-sm">{{ $visit->patient->telepon }}</span>
                        </div>
                        @if($visit->patient->email)
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-gray-400 w-5"></i>
                            <span class="ml-3 text-sm">{{ $visit->patient->email }}</span>
                        </div>
                        @endif
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-gray-400 w-5 mt-1"></i>
                            <span class="ml-3 text-sm">{{ $visit->patient->alamat }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                <i class="fas fa-edit text-blue-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Update Status Kunjungan</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500" id="statusMessage"></p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="confirmStatus" 
                        class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-blue-600">
                    Ya, Update
                </button>
                <button onclick="closeStatusModal()" 
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-16 hover:bg-gray-600">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let statusToUpdate = '';

function updateStatus(status) {
    statusToUpdate = status;
    const messages = {
        'sedang_diperiksa': 'Mulai konsultasi dengan pasien?',
        'selesai': 'Tandai konsultasi sebagai selesai?',
        'dibatalkan': 'Batalkan kunjungan ini?'
    };
    
    document.getElementById('statusMessage').textContent = messages[status];
    document.getElementById('statusModal').classList.remove('hidden');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
    statusToUpdate = '';
}

function confirmStatusUpdate() {
    if (!statusToUpdate) return;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("admin.visits.updateStatus", $visit) }}';
    
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
    statusInput.value = statusToUpdate;
    form.appendChild(statusInput);
    
    document.body.appendChild(form);
    form.submit();
}

function printVisit() {
    window.print();
}

// Set up event listener
document.getElementById('confirmStatus').onclick = confirmStatusUpdate;

// Close modal when clicking outside
document.getElementById('statusModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeStatusModal();
    }
});
</script>
@endpush

@push('styles')
<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        -webkit-print-color-adjust: exact;
    }
}
</style>
@endpush
