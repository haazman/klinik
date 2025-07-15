@extends('layouts.app')

@section('title', 'Detail Pasien')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detail Pasien</h1>
                <p class="text-gray-600 mt-1">{{ $patient->nama_lengkap }}</p>
            </div>
            <a href="{{ route('doctor.patients.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Patient Info -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="text-center mb-6">
                        <div class="w-24 h-24 bg-gray-300 rounded-full mx-auto flex items-center justify-center">
                            <i class="fas fa-user text-3xl text-gray-600"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mt-4">{{ $patient->nama_lengkap }}</h3>
                        <p class="text-gray-600">{{ $patient->user->email }}</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Tanggal Lahir</label>
                            <p class="text-gray-800">
                                @if($patient->tanggal_lahir)
                                    {{ \Carbon\Carbon::parse($patient->tanggal_lahir)->format('d/m/Y') }}
                                    ({{ \Carbon\Carbon::parse($patient->tanggal_lahir)->age }} tahun)
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Jenis Kelamin</label>
                            <p class="text-gray-800">
                                @if($patient->jenis_kelamin)
                                    {{ ucfirst($patient->jenis_kelamin) }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">No. Telepon</label>
                            <p class="text-gray-800">
                                @if($patient->no_telepon)
                                    {{ $patient->no_telepon }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Alamat</label>
                            <p class="text-gray-800">
                                @if($patient->alamat)
                                    {{ $patient->alamat }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Riwayat Penyakit</label>
                            <p class="text-gray-800">
                                @if($patient->riwayat_penyakit)
                                    {{ $patient->riwayat_penyakit }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </p>
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-600">Alergi</label>
                            <p class="text-gray-800">
                                @if($patient->alergi)
                                    {{ $patient->alergi }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Statistik</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Kunjungan</span>
                            <span class="font-semibold">{{ $visits->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Kunjungan Selesai</span>
                            <span class="font-semibold text-green-600">{{ $visits->where('status', 'selesai')->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Kunjungan Terakhir</span>
                            <span class="font-semibold">
                                @if($visits->count() > 0)
                                    {{ $visits->sortByDesc('tanggal_kunjungan')->first()->tanggal_kunjungan->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Visits History -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Riwayat Kunjungan</h3>
                    </div>

                    @if($visits->count() > 0)
                        <div class="space-y-4">
                            @foreach($visits as $visit)
                                <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h4 class="font-medium text-gray-800">
                                                Kunjungan {{ $visit->tanggal_kunjungan->format('d/m/Y') }}
                                            </h4>
                                            <p class="text-sm text-gray-600">
                                                {{ $visit->tanggal_kunjungan->format('H:i') }} - 
                                                {{ $visit->tanggal_kunjungan->diffForHumans() }}
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                                {{ $visit->status == 'selesai' ? 'bg-green-100 text-green-800' : 
                                                   ($visit->status == 'sedang_diperiksa' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($visit->status == 'menunggu' ? 'bg-blue-100 text-blue-800' : 
                                                    'bg-red-100 text-red-800')) }}">
                                                {{ ucfirst(str_replace('_', ' ', $visit->status)) }}
                                            </span>
                                            <a href="{{ route('visits.show', $visit) }}" 
                                               class="text-blue-600 hover:text-blue-800">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-600">Keluhan Utama:</p>
                                            <p class="text-gray-800">{{ $visit->keluhan_utama }}</p>
                                        </div>
                                        @if($visit->diagnosis)
                                            <div>
                                                <p class="text-gray-600">Diagnosis:</p>
                                                <p class="text-gray-800">{{ $visit->diagnosis }}</p>
                                            </div>
                                        @endif
                                        @if($visit->tindakan)
                                            <div>
                                                <p class="text-gray-600">Tindakan:</p>
                                                <p class="text-gray-800">{{ $visit->tindakan }}</p>
                                            </div>
                                        @endif
                                        @if($visit->saran)
                                            <div>
                                                <p class="text-gray-600">Saran:</p>
                                                <p class="text-gray-800">{{ $visit->saran }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    @if($visit->obatVisits && $visit->obatVisits->count() > 0)
                                        <div class="mt-3 pt-3 border-t border-gray-100">
                                            <p class="text-sm text-gray-600 mb-2">Obat yang Diberikan:</p>
                                            <div class="flex flex-wrap gap-2">
                                                @foreach($visit->obatVisits as $obatVisit)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-50 text-blue-700">
                                                        {{ $obatVisit->obat->nama_obat }} ({{ $obatVisit->jumlah }} {{ $obatVisit->obat->satuan }})
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $visits->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-gray-400 mb-4">
                                <i class="fas fa-clipboard-list text-6xl"></i>
                            </div>
                            <h4 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Riwayat Kunjungan</h4>
                            <p class="text-gray-600">Pasien ini belum pernah melakukan kunjungan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
