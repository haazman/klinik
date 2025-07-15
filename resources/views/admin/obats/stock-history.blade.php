@extends('layouts.app')

@section('title', 'Riwayat Stok Obat')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Riwayat Stok Obat</h1>
            <p class="text-gray-600 mt-1">{{ $obat->nama_obat }} - Stok Saat Ini: {{ $obat->stok }} {{ $obat->satuan }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('admin.obats.show', $obat) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-eye mr-2"></i>Detail Obat
            </a>
            <a href="{{ route('admin.obats.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-boxes text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Stok Saat Ini</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $obat->stok }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-plus text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Masuk</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stockHistory->sum('jumlah') }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Stok Minimum</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $obat->stok_minimum }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <i class="fas fa-history text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Transaksi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stockHistory->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-48">
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" id="start_date" 
                       value="{{ request('start_date') }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="flex-1 min-w-48">
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" id="end_date" 
                       value="{{ request('end_date') }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div class="flex space-x-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.obats.stock-history', $obat) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Stock History Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800">Riwayat Perubahan Stok</h3>
        </div>
        
        @if($stockHistory->count() > 0)
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Sebelum</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok Sesudah</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($stockHistory as $history)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $history->tanggal_masuk->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-plus mr-1"></i>Masuk
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                            +{{ $history->jumlah }} {{ $obat->satuan }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $history->stok_sebelum }} {{ $obat->satuan }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $history->stok_setelah }} {{ $obat->satuan }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate" title="{{ $history->keterangan }}">
                            {{ $history->keterangan ?: '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $history->created_at->format('H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($stockHistory->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $stockHistory->links() }}
        </div>
        @endif
        
        @else
        <div class="px-6 py-12 text-center">
            <div class="max-w-md mx-auto">
                <i class="fas fa-inbox text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Riwayat Stok</h3>
                <p class="text-gray-500 mb-6">Belum ada perubahan stok untuk obat ini.</p>
                <button onclick="openStockModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                    <i class="fas fa-plus mr-2"></i>Tambah Stok Pertama
                </button>
            </div>
        </div>
        @endif
    </div>
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
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah ({{ $obat->satuan }})
                        </label>
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
