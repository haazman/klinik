<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Test Profile Page
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3>Debug Information</h3>
                <p>User ID: {{ auth()->id() }}</p>
                <p>User Name: {{ auth()->user()->name }}</p>
                <p>Patient exists: {{ $patient ? 'Yes' : 'No' }}</p>
                @if($patient)
                    <p>Patient ID: {{ $patient->id }}</p>
                    <p>Patient Name: {{ $patient->nama_lengkap }}</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
