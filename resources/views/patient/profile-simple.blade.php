<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Test Profile Page</h3>
                    <p>User: {{ auth()->user()->name }}</p>
                    <p>Patient exists: {{ $patient ? 'Yes - ID: ' . $patient->id : 'No' }}</p>
                    @if($patient)
                        <p>Patient Name: {{ $patient->nama_lengkap }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
