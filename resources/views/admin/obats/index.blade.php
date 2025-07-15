@extends('layouts.app')

@section('title', 'Manajemen Obat')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manajemen Obat</h1>
        <a href="{{ route('admin.obats.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
            <i class="fas fa-plus mr-2"></i>Tambah Obat
        </a>
    </div>
    @if($lowStockCount > 0)
    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle mr-2"></i>
            <span>
                <strong>Peringatan!</strong> Ada {{ $lowStockCount }} obat dengan stok di bawah batas minimum.
            </span>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                    <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Obat
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jenis & Satuan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stok
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($obats as $obat)
                        <tr class="{{ $obat->isLowStock() ? 'bg-red-50' : '' }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $obat->nama_obat }}
                                </div>
                                @if($obat->deskripsi)
                                <div class="text-sm text-gray-500">
                                    {{ Str::limit($obat->deskripsi, 50) }}
                                </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 capitalize">{{ $obat->jenis }}</div>
                                <div class="text-sm text-gray-500">{{ $obat->satuan }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium {{ $obat->isLowStock() ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $obat->stok }} {{ $obat->satuan }}
                                    @if($obat->isLowStock())
                                        <span class="inline-block ml-1 px-2 py-1 text-xs bg-red-100 text-red-800 rounded">Rendah</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500">Min: {{ $obat->stok_minimum }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Rp {{ number_format($obat->harga, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.obats.show', $obat) }}" 
                                       class="text-blue-600 hover:text-blue-900 transition duration-200">
                                        <i class="fas fa-eye mr-1"></i>Detail
                                    </a>
                                    <a href="{{ route('admin.obats.edit', $obat) }}" 
                                       class="text-yellow-600 hover:text-yellow-900 transition duration-200">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    @if($obat->isLowStock())
                                    <button onclick="openAddStockModal({{ $obat->id }}, '{{ $obat->nama_obat }}')" 
                                            class="text-green-600 hover:text-green-900 transition duration-200">
                                        <i class="fas fa-plus mr-1"></i>Stok
                                    </button>
                                    @endif
                                    <form method="POST" action="{{ route('admin.obats.destroy', $obat) }}" 
                                          class="inline" 
                                          onsubmit="return confirm('Yakin ingin menghapus obat {{ $obat->nama_obat }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition duration-200">
                                            <i class="fas fa-trash mr-1"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center">
                                <div class="text-gray-500">
                                    <i class="fas fa-pills text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">Belum ada obat</p>
                                    <p class="text-sm">Tambahkan obat pertama Anda dengan klik tombol "Tambah Obat"</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($obats->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $obats->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal untuk tambah stok -->
<div id="addStockModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-800 mb-4">Tambah Stok Obat</h3>
                
                <form id="addStockForm" method="POST" action="">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                            <input type="number" name="jumlah" min="1" required 
                                   class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                            <textarea name="keterangan" rows="2"
                                      class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="Keterangan tambahan..."></textarea>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" onclick="closeAddStockModal()" 
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
function openAddStockModal(obatId, obatName) {
    document.getElementById('modalTitle').textContent = `Tambah Stok - ${obatName}`;
    document.getElementById('addStockForm').action = `/admin/obat-masuk`;
    // Add hidden input for obat_id
    let obatInput = document.querySelector('input[name="obat_id"]');
    if (!obatInput) {
        obatInput = document.createElement('input');
        obatInput.type = 'hidden';
        obatInput.name = 'obat_id';
        document.getElementById('addStockForm').appendChild(obatInput);
    }
    obatInput.value = obatId;
    document.getElementById('addStockModal').classList.remove('hidden');
}

function closeAddStockModal() {
    document.getElementById('addStockModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('addStockModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAddStockModal();
    }
});
</script>
@endsection
