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
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="mb-6 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
                            {{ session('info') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('patient.profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama Lengkap -->
                            <div class="md:col-span-2">
                                <label for="nama_lengkap" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" id="nama_lengkap" 
                                       value="{{ old('nama_lengkap', $patient->nama_lengkap ?? '') }}" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                       required>
                                @error('nama_lengkap')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NIK -->
                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-700">NIK</label>
                                <input type="text" name="nik" id="nik" 
                                       value="{{ old('nik', $patient->nik ?? '') }}" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                       maxlength="16" placeholder="16 digit NIK">
                                @error('nik')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- No Telepon -->
                            <div>
                                <label for="no_telepon" class="block text-sm font-medium text-gray-700">No Telepon</label>
                                <input type="text" name="no_telepon" id="no_telepon" 
                                       value="{{ old('no_telepon', $patient->no_telepon ?? '') }}" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                       required>
                                @error('no_telepon')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email" 
                                       value="{{ old('email', $patient->email ?? auth()->user()->email) }}" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Lahir -->
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" 
                                       value="{{ old('tanggal_lahir', $patient && $patient->tanggal_lahir ? $patient->tanggal_lahir->format('Y-m-d') : '') }}" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('tanggal_lahir')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis Kelamin -->
                            <div>
                                <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                                <select name="jenis_kelamin" id="jenis_kelamin" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="L" {{ old('jenis_kelamin', $patient->jenis_kelamin ?? '') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="P" {{ old('jenis_kelamin', $patient->jenis_kelamin ?? '') === 'P' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Golongan Darah -->
                            <div>
                                <label for="golongan_darah" class="block text-sm font-medium text-gray-700">Golongan Darah</label>
                                <select name="golongan_darah" id="golongan_darah" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Pilih Golongan Darah</option>
                                    <option value="A" {{ old('golongan_darah', $patient->golongan_darah ?? '') === 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('golongan_darah', $patient->golongan_darah ?? '') === 'B' ? 'selected' : '' }}>B</option>
                                    <option value="AB" {{ old('golongan_darah', $patient->golongan_darah ?? '') === 'AB' ? 'selected' : '' }}>AB</option>
                                    <option value="O" {{ old('golongan_darah', $patient->golongan_darah ?? '') === 'O' ? 'selected' : '' }}>O</option>
                                </select>
                                @error('golongan_darah')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status Pernikahan -->
                            <div>
                                <label for="status_pernikahan" class="block text-sm font-medium text-gray-700">Status Pernikahan</label>
                                <select name="status_pernikahan" id="status_pernikahan" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Pilih Status Pernikahan</option>
                                    <option value="belum_menikah" {{ old('status_pernikahan', $patient->status_pernikahan ?? '') === 'belum_menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                    <option value="menikah" {{ old('status_pernikahan', $patient->status_pernikahan ?? '') === 'menikah' ? 'selected' : '' }}>Menikah</option>
                                    <option value="cerai" {{ old('status_pernikahan', $patient->status_pernikahan ?? '') === 'cerai' ? 'selected' : '' }}>Cerai</option>
                                </select>
                                @error('status_pernikahan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Pekerjaan -->
                            <div>
                                <label for="pekerjaan" class="block text-sm font-medium text-gray-700">Pekerjaan</label>
                                <input type="text" name="pekerjaan" id="pekerjaan" 
                                       value="{{ old('pekerjaan', $patient->pekerjaan ?? '') }}" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @error('pekerjaan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="mt-6">
                            <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                            <textarea name="alamat" id="alamat" rows="3" 
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                      required>{{ old('alamat', $patient->alamat ?? '') }}</textarea>
                            @error('alamat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Riwayat Penyakit -->
                        <div class="mt-6">
                            <label for="riwayat_penyakit" class="block text-sm font-medium text-gray-700">Riwayat Penyakit</label>
                            <textarea name="riwayat_penyakit" id="riwayat_penyakit" rows="3" 
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                      placeholder="Tuliskan riwayat penyakit yang pernah dialami...">{{ old('riwayat_penyakit', $patient->riwayat_penyakit ?? '') }}</textarea>
                            @error('riwayat_penyakit')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alergi -->
                        <div class="mt-6">
                            <label for="alergi" class="block text-sm font-medium text-gray-700">Alergi</label>
                            <textarea name="alergi" id="alergi" rows="3" 
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" 
                                      placeholder="Tuliskan alergi obat, makanan, atau lainnya...">{{ old('alergi', $patient->alergi ?? '') }}</textarea>
                            @error('alergi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-8">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Simpan Profil
                            </button>
                        </div>
                    </form>

                    <!-- Profile Summary (Read-only) -->
                    @if($patient && ($patient->nama_lengkap || $patient->tanggal_lahir))
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Profil</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="font-medium text-gray-700">Nama:</span>
                                    <span class="text-gray-900">{{ $patient->nama_lengkap }}</span>
                                </div>
                                <div>
                                    <span class="font-medium text-gray-700">Bergabung sejak:</span>
                                    <span class="text-gray-900">{{ auth()->user()->created_at->format('d M Y') }}</span>
                                </div>
                                @if($patient->tanggal_lahir)
                                <div>
                                    <span class="font-medium text-gray-700">Umur:</span>
                                    <span class="text-gray-900">{{ \Carbon\Carbon::parse($patient->tanggal_lahir)->age }} tahun</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
