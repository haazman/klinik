@extends('layouts.app')

@section('title', 'Detail Kunjungan')

@section('content')
                @if($visit->diagnosis)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Diagnosa</h3>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-blue-800">{{ $visit->diagnosis }}</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>

<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Kunjungan</h1>
                <p class="text-gray-600 mt-1">ID Kunjungan: #{{ $visit->id }}</p>
            </div>
            <div class="flex space-x-3">
                @if($visit->status == 'menunggu' && $visit->tanggal_kunjungan > now())
                <a href="{{ route('patient.visits.edit', $visit) }}" 
                   class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-200">
                    <i class="fas fa-edit mr-2"></i>Edit Janji
                </a>
                <button onclick="cancelVisit()" 
                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-200">
                    <i class="fas fa-times mr-2"></i>Batalkan
                </button>
                @endif
                <a href="{{ route('patient.visits.index') }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Status and Basic Info -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-start mb-4">
                        <h2 class="text-xl font-semibold text-gray-800">Informasi Kunjungan</h2>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            {{ $visit->status == 'selesai' ? 'bg-green-100 text-green-800' : 
                               ($visit->status == 'sedang_diperiksa' ? 'bg-blue-100 text-blue-800' : 
                               ($visit->status == 'menunggu' ? 'bg-yellow-100 text-yellow-800' : 
                                'bg-red-100 text-red-800')) }}">
                            {{ ucfirst($visit->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Tanggal & Waktu</p>
                            <p class="text-gray-900">{{ $visit->tanggal_kunjungan->format('d F Y, H:i') }} WIB</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-600">Durasi Estimasi</p>
                            <p class="text-gray-900">30 menit</p>
                        </div>
                        @if($visit->created_at)
                        <div>
                            <p class="text-sm font-medium text-gray-600">Dibuat Pada</p>
                            <p class="text-gray-900">{{ $visit->created_at->format('d F Y, H:i') }} WIB</p>
                        </div>
                        @endif
                        @if($visit->updated_at && $visit->updated_at != $visit->created_at)
                        <div>
                            <p class="text-sm font-medium text-gray-600">Terakhir Diperbarui</p>
                            <p class="text-gray-900">{{ $visit->updated_at->format('d F Y, H:i') }} WIB</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Keluhan -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Keluhan</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-800">{{ $visit->keluhan_utama }}</p>
                    </div>
                </div>

                <!-- Riwayat Penyakit -->
                @if($visit->riwayat_penyakit_kunjungan)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Riwayat Penyakit Terkait</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-800">{{ $visit->riwayat_penyakit_kunjungan }}</p>
                    </div>
                </div>
                @endif

                <!-- Diagnosa (jika sudah ada) -->
                @if($visit->diagnosa)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Diagnosa</h3>
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                        <p class="text-blue-800">{{ $visit->diagnosa }}</p>
                    </div>
                </div>
                @endif

                <!-- Resep Obat -->
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

                <!-- Catatan Tambahan -->
                @if($visit->catatan)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Catatan Tambahan</h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-800">{{ $visit->catatan }}</p>
                    </div>
                </div>
                @endif

                <!-- Catatan Dokter -->
                @if($visit->catatan_dokter)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Catatan Dokter</h3>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-blue-800">{{ $visit->catatan_dokter }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Doctor Information -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Dokter</h3>
                    <div class="flex items-start">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-md text-blue-600 text-2xl"></i>
                        </div>
                        <div class="ml-4 flex-1">
                            <h4 class="font-medium text-gray-900">Dr. {{ $visit->doctor->name }}</h4>
                            <p class="text-sm text-gray-600">{{ $visit->doctor->spesialisasi }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $visit->doctor->pengalaman }} tahun pengalaman</p>
                            
                            @if($visit->doctor->telepon)
                            <div class="mt-3 flex items-center text-sm text-gray-500">
                                <i class="fas fa-phone mr-2"></i>
                                {{ $visit->doctor->telepon }}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Status Timeline -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Timeline Status</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Janji Dibuat</p>
                                <p class="text-xs text-gray-500">{{ $visit->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($visit->status == 'menunggu')
                        <div class="flex items-start">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full mt-1.5"></div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Menunggu Konsultasi</p>
                                <p class="text-xs text-gray-500">{{ $visit->tanggal_kunjungan->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($visit->status == 'sedang_diperiksa')
                        <div class="flex items-start">
                            <div class="w-3 h-3 bg-blue-500 rounded-full mt-1.5"></div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Konsultasi Sedang Berlangsung</p>
                                <p class="text-xs text-gray-500">Sedang dalam pemeriksaan</p>
                            </div>
                        </div>
                        @endif

                        @if($visit->status == 'selesai')
                        <div class="flex items-start">
                            <div class="w-3 h-3 bg-green-500 rounded-full mt-1.5"></div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Konsultasi Selesai</p>
                                <p class="text-xs text-gray-500">{{ $visit->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        @endif

                        @if($visit->status == 'dibatalkan')
                        <div class="flex items-start">
                            <div class="w-3 h-3 bg-red-500 rounded-full mt-1.5"></div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Janji Dibatalkan</p>
                                <p class="text-xs text-gray-500">{{ $visit->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                @if($visit->status == 'selesai')
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi</h3>
                    <div class="space-y-3">
                        <button onclick="window.print()" 
                                class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                            <i class="fas fa-print mr-2"></i>Cetak Hasil
                        </button>
                        
                        <a href="{{ route('patient.visits.create') }}" 
                           class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200 inline-block text-center">
                            <i class="fas fa-calendar-plus mr-2"></i>Buat Janji Lagi
                        </a>
                    </div>
                </div>
                @endif

                <!-- Patient Reminder -->
                @if($visit->status == 'menunggu' && $visit->tanggal_kunjungan->isToday())
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-bell text-yellow-400 mt-0.5"></i>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Pengingat</h3>
                            <p class="mt-1 text-sm text-yellow-700">
                                Konsultasi Anda hari ini pukul {{ $visit->tanggal_kunjungan->format('H:i') }}. 
                                Harap datang 15 menit lebih awal.
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Cancel Visit Modal -->
<div id="cancelModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Batalkan Kunjungan?</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin membatalkan janji temu ini? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button onclick="confirmCancel()" 
                        class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600">
                    Ya, Batalkan
                </button>
                <button onclick="closeCancelModal()" 
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-16 hover:bg-gray-600">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function cancelVisit() {
    document.getElementById('cancelModal').classList.remove('hidden');
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
}

function confirmCancel() {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("patient.visits.cancel", $visit) }}';
    
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
    
    document.body.appendChild(form);
    form.submit();
}

// Close modal when clicking outside
document.getElementById('cancelModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCancelModal();
    }
});
</script>
@endpush
