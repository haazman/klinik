@extends('layouts.app')

@section('title', 'Jadwal Dokter Tersedia')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Jadwal Dokter Tersedia</h1>
        <a href="{{ route('patient.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
        </a>
    </div>

    @if($schedules->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-8 text-center">
            <i class="fas fa-calendar-times text-6xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak Ada Jadwal Tersedia</h3>
            <p class="text-gray-500 mb-4">Saat ini tidak ada jadwal dokter yang tersedia. Silakan coba lagi nanti.</p>
            <a href="{{ route('patient.visits.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                <i class="fas fa-plus mr-2"></i>Buat Janji Temu
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-blue-50 px-6 py-4 border-b border-blue-100">
                <div class="flex items-center">
                    <i class="fas fa-calendar-alt text-blue-600 mr-3"></i>
                    <h2 class="text-lg font-semibold text-blue-800">Jadwal Tersedia</h2>
                </div>
                <p class="text-sm text-blue-600 mt-1">Pilih jadwal dokter untuk membuat janji temu</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dokter
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Spesialisasi
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jam Praktik
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
                        @php
                            $currentDate = null;
                        @endphp
                        @foreach($schedules as $schedule)
                            @php
                                $scheduleDate = \Carbon\Carbon::parse($schedule->tanggal);
                                $isNewDate = $currentDate !== $scheduleDate->format('Y-m-d');
                                $currentDate = $scheduleDate->format('Y-m-d');
                            @endphp
                            <tr class="hover:bg-gray-50 {{ $isNewDate ? 'border-t-2 border-blue-200' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($isNewDate)
                                        <div class="flex flex-col">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $scheduleDate->format('d/m/Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ $scheduleDate->translatedFormat('l') }}
                                            </div>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center">
                                                <i class="fas fa-user-md text-white"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $schedule->doctor->nama_lengkap }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $schedule->doctor->pengalaman }} tahun pengalaman
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 capitalize">
                                        {{ $schedule->doctor->spesialis }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center">
                                        <i class="fas fa-clock text-gray-400 mr-2"></i>
                                        {{ \Carbon\Carbon::parse($schedule->jam_mulai)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($schedule->jam_selesai)->format('H:i') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Tersedia
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('patient.visits.create', ['doctor_id' => $schedule->doctor->id, 'date' => $schedule->tanggal]) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200 inline-flex items-center">
                                        <i class="fas fa-calendar-plus mr-2"></i>
                                        Buat Janji
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-check text-2xl text-blue-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Total Jadwal Tersedia
                                </dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $schedules->count() }} jadwal
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-md text-2xl text-green-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Dokter Tersedia
                                </dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $schedules->unique('doctor_id')->count() }} dokter
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar-alt text-2xl text-purple-600"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Hari Tersedia
                                </dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $schedules->unique('tanggal')->count() }} hari
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tips Section -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-lightbulb text-blue-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Tips Membuat Janji Temu</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li>Pilih jadwal yang sesuai dengan kebutuhan Anda</li>
                            <li>Siapkan keluhan dan gejala yang akan disampaikan</li>
                            <li>Datang 15 menit sebelum jadwal untuk pendaftaran</li>
                            <li>Bawa identitas diri dan kartu asuransi (jika ada)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
