@extends('layouts.app')

@section('title', 'Detail Kunjungan')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Kunjungan</h1>
                <p class="text-gray-600 mt-1">ID Kunjungan: #{{ $visit->id }}</p>
            </div>
            <div class="flex space-x-3">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.visits.edit', $visit) }}" 
                       class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-200">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                @endif
                @if(auth()->user()->role === 'dokter' && $visit->doctor->user_id === auth()->id())
                    <a href="{{ route('doctor.visits.edit', $visit) }}" 
                       class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition duration-200">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                @endif
                <button onclick="printVisit()" 
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">
                    <i class="fas fa-print mr-2"></i>Cetak
                </button>
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.visits.index') }}" 
                       class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                @elseif(auth()->user()->role === 'dokter')
                    <a href="{{ route('doctor.visits.index') }}" 
                       class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                @else
                    <a href="{{ route('patient.visits.index') }}" 
                       class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                @endif
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
                            {{ ucfirst(str_replace('_', ' ', $visit->status)) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Informasi Pasien</h4>
                            <div class="space-y-2">
                                <p><span class="font-medium">Nama:</span> {{ $visit->patient->nama_lengkap }}</p>
                                @if(auth()->user()->role !== 'pasien')
                                    <p><span class="font-medium">Email:</span> {{ $visit->patient->user->email }}</p>
                                    <p><span class="font-medium">No. Telepon:</span> {{ $visit->patient->no_telepon ?? '-' }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Informasi Dokter</h4>
                            <div class="space-y-2">
                                <p><span class="font-medium">Nama:</span> Dr. {{ $visit->doctor->nama_lengkap }}</p>
                                <p><span class="font-medium">Spesialisasi:</span> {{ $visit->doctor->spesialis }}</p>
                                <p><span class="font-medium">Pengalaman:</span> {{ $visit->doctor->pengalaman }} tahun</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Jadwal Kunjungan</h4>
                            <div class="space-y-2">
                                <p><span class="font-medium">Tanggal:</span> {{ \Carbon\Carbon::parse($visit->tanggal_kunjungan)->format('d/m/Y') }}</p>
                                <p><span class="font-medium">Jam:</span> {{ \Carbon\Carbon::parse($visit->jam_kunjungan)->format('H:i') }}</p>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Biaya</h4>
                            <div class="space-y-2">
                                <p><span class="font-medium">Konsultasi:</span> Rp {{ number_format($visit->biaya_konsultasi ?? 0, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Keluhan & Diagnosis -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Keluhan & Diagnosis</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Keluhan Utama</h4>
                            <p class="text-gray-800 bg-gray-50 p-3 rounded-md">{{ $visit->keluhan_utama }}</p>
                        </div>

                        @if($visit->riwayat_penyakit_kunjungan)
                        <div>
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Riwayat Penyakit</h4>
                            <p class="text-gray-800 bg-gray-50 p-3 rounded-md">{{ $visit->riwayat_penyakit_kunjungan }}</p>
                        </div>
                        @endif

                        @if($visit->catatan)
                        <div>
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Catatan Tambahan</h4>
                            <p class="text-gray-800 bg-gray-50 p-3 rounded-md">{{ $visit->catatan }}</p>
                        </div>
                        @endif

                        @if($visit->hasil_pemeriksaan)
                        <div>
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Hasil Pemeriksaan</h4>
                            <p class="text-gray-800 bg-gray-50 p-3 rounded-md">{{ $visit->hasil_pemeriksaan }}</p>
                        </div>
                        @endif

                        @if($visit->diagnosis)
                        <div>
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Diagnosis</h4>
                            <p class="text-gray-800 bg-green-50 p-3 rounded-md border border-green-200">{{ $visit->diagnosis }}</p>
                        </div>
                        @endif

                        @if($visit->tindakan)
                        <div>
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Tindakan</h4>
                            <p class="text-gray-800 bg-blue-50 p-3 rounded-md border border-blue-200">{{ $visit->tindakan }}</p>
                        </div>
                        @endif

                        @if($visit->saran)
                        <div>
                            <h4 class="text-sm font-medium text-gray-600 mb-2">Saran & Anjuran</h4>
                            <p class="text-gray-800 bg-yellow-50 p-3 rounded-md border border-yellow-200">{{ $visit->saran }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Resep Obat -->
                @if($visit->obatVisits && $visit->obatVisits->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">Resep Obat</h2>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Obat</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aturan Pakai</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($visit->obatVisits as $obatVisit)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $obatVisit->obat->nama_obat }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $obatVisit->jumlah }} {{ $obatVisit->obat->satuan }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $obatVisit->aturan_pakai }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        Rp {{ number_format($obatVisit->harga_total, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50">
                                <tr>
                                    <td colspan="3" class="px-6 py-3 text-right font-medium text-gray-900">Total Obat:</td>
                                    <td class="px-6 py-3 text-sm font-medium text-gray-900">
                                        Rp {{ number_format($visit->obatVisits->sum('harga_total'), 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
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
                        @if(auth()->user()->role === 'admin')
                            @if($visit->status === 'menunggu')
                                <form action="{{ route('admin.visits.updateStatus', $visit) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="sedang_diperiksa">
                                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                                        <i class="fas fa-play mr-2"></i>Mulai Pemeriksaan
                                    </button>
                                </form>
                            @elseif($visit->status === 'sedang_diperiksa')
                                <form action="{{ route('admin.visits.updateStatus', $visit) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="selesai">
                                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                                        <i class="fas fa-check mr-2"></i>Selesaikan
                                    </button>
                                </form>
                            @endif
                        @endif

                        @if(auth()->user()->role === 'dokter' && $visit->doctor->user_id === auth()->id())
                            @if($visit->status === 'menunggu')
                                <form action="{{ route('doctor.visits.updateStatus', $visit) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="sedang_diperiksa">
                                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                                        <i class="fas fa-play mr-2"></i>Mulai Pemeriksaan
                                    </button>
                                </form>
                            @elseif($visit->status === 'sedang_diperiksa')
                                <form action="{{ route('doctor.visits.updateStatus', $visit) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="selesai">
                                    <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                                        <i class="fas fa-check mr-2"></i>Selesaikan
                                    </button>
                                </form>
                            @endif
                        @endif
                        
                        @if(auth()->user()->role === 'pasien' && $visit->status === 'menunggu')
                            <form action="{{ route('patient.visits.cancel', $visit) }}" method="POST" class="w-full" onsubmit="return confirm('Yakin ingin membatalkan kunjungan ini?')">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200">
                                    <i class="fas fa-times mr-2"></i>Batalkan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Visit Timeline -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Timeline</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 bg-blue-600 rounded-full mt-2"></div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Kunjungan Dibuat</p>
                                <p class="text-xs text-gray-500">{{ $visit->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($visit->updated_at != $visit->created_at)
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-2 h-2 bg-yellow-600 rounded-full mt-2"></div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">Terakhir Diupdate</p>
                                <p class="text-xs text-gray-500">{{ $visit->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function printVisit() {
    window.print();
}
</script>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    .print-break-inside-avoid {
        break-inside: avoid;
    }
}
</style>
@endsection
