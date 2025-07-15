@extends('layouts.app')

@section('title', 'Daftar Kunjungan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Riwayat Kunjungan</h1>
            <p class="text-gray-600 mt-1">Daftar kunjungan dan konsultasi Anda</p>
        </div>
        <a href="{{ route('patient.visits.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
            <i class="fas fa-plus mr-2"></i>Buat Janji Baru
        </a>
    </div>

    <!-- Filter dan Search -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('patient.visits.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="sedang_diperiksa" {{ request('status') == 'sedang_diperiksa' ? 'selected' : '' }}>Sedang Diperiksa</option>
                    <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dokter</label>
                <select name="doctor_id" class="w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Semua Dokter</option>
                    @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                        Dr. {{ $doctor->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Periode</label>
                <select name="period" class="w-full rounded-md border-gray-300 shadow-sm">
                    <option value="">Semua Periode</option>
                    <option value="this_month" {{ request('period') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="last_month" {{ request('period') == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
                    <option value="this_year" {{ request('period') == 'this_year' ? 'selected' : '' }}>Tahun Ini</option>
                </select>
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="w-full bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-calendar-check text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Kunjungan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Menunggu</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['waiting'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-stethoscope text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Sedang Diperiksa</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['ongoing'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['completed'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Visits List -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        @if($visits->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal & Waktu
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dokter
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Keluhan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($visits as $visit)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $visit->tanggal_kunjungan->format('d/m/Y') }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $visit->tanggal_kunjungan->format('H:i') }} WIB
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-md text-blue-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">Dr. {{ $visit->doctor->nama_lengkap }}</div>
                                        <div class="text-sm text-gray-500">{{ $visit->doctor->spesialisasi }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ Str::limit($visit->keluhan_utama, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $visit->status == 'selesai' ? 'bg-green-100 text-green-800' : 
                                       ($visit->status == 'sedang_diperiksa' ? 'bg-blue-100 text-blue-800' : 
                                       ($visit->status == 'menunggu' ? 'bg-yellow-100 text-yellow-800' : 
                                        'bg-red-100 text-red-800')) }}">
                                    {{ ucfirst($visit->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('patient.visits.show', $visit) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($visit->status == 'menunggu' && $visit->tanggal_kunjungan > now())
                                    <button onclick="editVisit({{ $visit->id }})" 
                                            class="text-yellow-600 hover:text-yellow-900">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <button onclick="cancelVisit({{ $visit->id }})" 
                                            class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-times"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                {{ $visits->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada riwayat kunjungan</h3>
                <p class="text-gray-500 mb-4">Anda belum memiliki riwayat kunjungan ke Klinik Bidan Yulis Setiawan</p>
                <a href="{{ route('patient.visits.create') }}" 
                   class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Buat Janji Pertama
                </a>
            </div>
        @endif
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
                <button id="confirmCancel" 
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
function cancelVisit(visitId) {
    document.getElementById('cancelModal').classList.remove('hidden');
    document.getElementById('confirmCancel').onclick = function() {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/patient/visits/${visitId}/cancel`;
        
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
    };
}

function closeCancelModal() {
    document.getElementById('cancelModal').classList.add('hidden');
}

function editVisit(visitId) {
    window.location.href = `/patient/visits/${visitId}/edit`;
}

// Close modal when clicking outside
document.getElementById('cancelModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCancelModal();
    }
});
</script>
@endpush
