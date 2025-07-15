@extends('layouts.app')

@section('title', 'Detail Obat')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Detail Obat: {{ $obat->nama_obat }}</h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.obats.edit', $obat) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.obats.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Detail Obat -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Obat</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Nama Obat</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $obat->nama_obat }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Jenis</label>
                        <p class="text-gray-800 capitalize">{{ $obat->jenis }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Satuan</label>
                        <p class="text-gray-800 capitalize">{{ $obat->satuan }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Harga</label>
                        <p class="text-lg font-semibold text-green-600">Rp {{ number_format($obat->harga, 0, ',', '.') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Stok Saat Ini</label>
                        <p class="text-lg font-semibold {{ $obat->isLowStock() ? 'text-red-600' : 'text-green-600' }}">
                            {{ $obat->stok }} {{ $obat->satuan }}
                            @if($obat->isLowStock())
                                <span class="inline-block ml-2 px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Stok Rendah</span>
                            @endif
                        </p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Stok Minimum</label>
                        <p class="text-gray-800">{{ $obat->stok_minimum }} {{ $obat->satuan }}</p>
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-600">Deskripsi</label>
                        <p class="text-gray-800">{{ $obat->deskripsi ?: 'Tidak ada deskripsi' }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Ditambahkan</label>
                        <p class="text-gray-800">{{ $obat->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Terakhir Diupdate</label>
                        <p class="text-gray-800">{{ $obat->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status & Actions -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Stok</h3>
                
                @if($obat->isLowStock())
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-red-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    Stok obat ini sudah mencapai batas minimum. Segera lakukan pengisian stok.
                                </p>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    Stok obat masih aman.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Progress bar -->
                <div class="w-full bg-gray-200 rounded-full h-3">
                    @php
                        $percentage = ($obat->stok / max($obat->stok_minimum * 2, 1)) * 100;
                        $percentage = min($percentage, 100);
                        $colorClass = $percentage < 50 ? 'bg-red-500' : ($percentage < 80 ? 'bg-yellow-500' : 'bg-green-500');
                    @endphp
                    <div class="{{ $colorClass }} h-3 rounded-full transition-all duration-300" style="width: {{ $percentage }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-1">{{ round($percentage) }}% dari target stok ideal</p>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Aksi Cepat</h3>
                
                <div class="space-y-3">
                    <button onclick="openStockModal()" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-plus mr-2"></i>Tambah Stok
                    </button>
                    
                    <a href="{{ route('admin.obats.stock-history', $obat) }}" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition duration-200 block text-center">
                        <i class="fas fa-history mr-2"></i>Riwayat Stok
                    </a>
                    
                    <form action="{{ route('admin.obats.destroy', $obat) }}" method="POST" class="w-full" onsubmit="return confirm('Apakah Anda yakin ingin menghapus obat ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-200">
                            <i class="fas fa-trash mr-2"></i>Hapus Obat
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Stock History -->
    @if($stockHistory->count() > 0)
    <div class="bg-white rounded-lg shadow-md p-6 mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Stok Terbaru</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sisa Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($stockHistory->take(5) as $history)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $history->tanggal_masuk->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Masuk
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                            +{{ $history->jumlah }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $history->stok_setelah }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $history->keterangan }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($stockHistory->count() > 5)
        <div class="mt-4 text-center">
            <a href="{{ route('admin.obats.stock-history', $obat) }}" class="text-blue-600 hover:text-blue-800">
                Lihat semua riwayat →
            </a>
        </div>
        @endif
    </div>
    @endif
</div>

<!-- Modal untuk tambah stok -->
<div id="stockModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Tambah Stok Obat</h3>
                
                <form action="{{ route('admin.obat-masuk.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="obat_id" value="{{ $obat->id }}">
                    
                    <div class="mb-4">
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" min="1" required
                               class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    
                    <div class="mb-6">
                        <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" rows="2"
                                  class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                  placeholder="Keterangan tambahan..."></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeStockModal()" 
                                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                            Batal
                        </button>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                            Tambah Stok
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openStockModal() {
    document.getElementById('stockModal').classList.remove('hidden');
}

function closeStockModal() {
    document.getElementById('stockModal').classList.add('hidden');
}
</script>
@endsection
