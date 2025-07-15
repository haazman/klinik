@extends('layouts.app')

@section('title', 'Daftar Kunjungan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Daftar Kunjungan</h1>
        <p class="text-gray-600 mt-1">Kelola kunjungan pasien Anda</p>
    </div>

    <!-- Filter dan Search -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('doctor.visits.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <input type="date" name="date" value="{{ request('date') }}" 
                       class="w-full rounded-md border-gray-300 shadow-sm">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Pasien</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Nama atau NIK pasien..."
                       class="w-full rounded-md border-gray-300 shadow-sm">
            </div>
            
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
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
                    <p class="text-sm font-medium text-gray-600">Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['today'] }}</p>
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
                                Waktu
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pasien
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
                        <tr class="hover:bg-gray-50 {{ $visit->status == 'sedang_diperiksa' ? 'bg-blue-50' : '' }}">
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
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-gray-900">{{ $visit->patient->nama_lengkap }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($visit->patient->tanggal_lahir)->age }} thn | 
                                            {{ $visit->patient->jenis_kelamin == 'L' ? 'L' : 'P' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">{{ Str::limit($visit->keluhan_utama, 50) }}</div>
                                @if($visit->riwayat_penyakit_kunjungan)
                                <div class="text-xs text-gray-500 mt-1">
                                    Riwayat: {{ Str::limit($visit->riwayat_penyakit_kunjungan, 30) }}
                                </div>
                                @endif
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
                                    <a href="{{ route('doctor.visits.show', $visit) }}" 
                                       class="text-blue-600 hover:text-blue-900" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($visit->status == 'menunggu')
                                    <button onclick="startConsultation({{ $visit->id }})" 
                                            class="text-green-600 hover:text-green-900" title="Mulai Konsultasi">
                                        <i class="fas fa-play"></i>
                                    </button>
                                    @endif
                                    
                                    @if($visit->status == 'sedang_diperiksa')
                                    <button onclick="finishConsultation({{ $visit->id }})" 
                                            class="text-purple-600 hover:text-purple-900" title="Selesaikan">
                                        <i class="fas fa-check"></i>
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
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada kunjungan</h3>
                <p class="text-gray-500">Belum ada jadwal kunjungan untuk filter yang dipilih</p>
            </div>
        @endif
    </div>

    <!-- Quick Actions -->
    @if($nextVisit)
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-center justify-between">
            <div class="flex">
                <i class="fas fa-clock text-blue-400 mt-0.5"></i>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Kunjungan Berikutnya</h3>
                    <p class="mt-1 text-sm text-blue-700">
                        {{ $nextVisit->patient->nama_lengkap }} - {{ \Carbon\Carbon::parse($nextVisit->jam_kunjungan)->format('H:i') }}
                    </p>
                </div>
            </div>
            <a href="{{ route('doctor.visits.show', $nextVisit) }}" 
               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                Lihat Detail →
            </a>
        </div>
    </div>
    @endif
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                <i class="fas fa-stethoscope text-blue-600 text-xl"></i>
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
let visitToUpdate = '';
let statusToUpdate = '';

function startConsultation(visitId) {
    visitToUpdate = visitId;
    statusToUpdate = 'sedang_diperiksa';
    document.getElementById('statusMessage').textContent = 'Mulai konsultasi dengan pasien ini?';
    document.getElementById('statusModal').classList.remove('hidden');
}

function finishConsultation(visitId) {
    visitToUpdate = visitId;
    statusToUpdate = 'selesai';
    document.getElementById('statusMessage').textContent = 'Tandai konsultasi sebagai selesai?';
    document.getElementById('statusModal').classList.remove('hidden');
}

function closeStatusModal() {
    document.getElementById('statusModal').classList.add('hidden');
    visitToUpdate = '';
    statusToUpdate = '';
}

function confirmStatusUpdate() {
    if (!visitToUpdate || !statusToUpdate) return;
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/doctor/visits/${visitToUpdate}/update-status`;
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'PATCH';
    form.appendChild(methodInput);
    
    const statusInput = document.createElement('input');
    statusInput.type = 'hidden';
    statusInput.name = 'status';
    statusInput.value = statusToUpdate;
    form.appendChild(statusInput);
    
    document.body.appendChild(form);
    form.submit();
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
