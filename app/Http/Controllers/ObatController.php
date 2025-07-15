<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\ObatMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::orderBy('nama_obat')->paginate(15);
        $lowStockCount = Obat::whereRaw('stok <= stok_minimum')->count();
        
        return view('admin.obats.index', compact('obats', 'lowStockCount'));
    }

    public function create()
    {
        return view('admin.obats.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_obat' => 'required|string|max:255',
                'jenis' => 'required|string|max:255',
                'satuan' => 'required|string|max:255',
                'stok' => 'required|integer|min:0',
                'harga' => 'required|numeric|min:0',
                'stok_minimum' => 'required|integer|min:0',
                'deskripsi' => 'nullable|string',
            ]);

            $obat = Obat::create($request->all());

            return redirect()->route('admin.obats.index')->with('success', 'Obat berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Obat $obat)
    {
        $obat->load('obatMasuks');
        $stockHistory = $obat->obatMasuks()->orderBy('created_at', 'desc')->take(10)->get();
        
        return view('admin.obats.show', compact('obat', 'stockHistory'));
    }

    public function edit(Obat $obat)
    {
        return view('admin.obats.edit', compact('obat'));
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'kode_obat' => 'required|string|max:255|unique:obats,kode_obat,' . $obat->id,
            'nama_obat' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'expired_date' => 'nullable|date|after:today',
        ]);

        $obat->update($request->all());

        return redirect()->route('admin.obats.index')->with('success', 'Data obat berhasil diupdate.');
    }

    public function destroy(Obat $obat)
    {
        if ($obat->obatVisits()->exists()) {
            return back()->withErrors(['error' => 'Tidak dapat menghapus obat yang sudah digunakan dalam kunjungan.']);
        }

        $obat->delete();
        return redirect()->route('admin.obats.index')->with('success', 'Obat berhasil dihapus.');
    }

    public function stockHistory(Obat $obat)
    {
        $stockHistory = $obat->obatMasuks()
            ->orderBy('tanggal_masuk', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.obats.stock-history', compact('obat', 'stockHistory'));
    }

    public function addStock(Request $request, Obat $obat)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'supplier' => 'required|string|max:255',
            'kontak_supplier' => 'nullable|string|max:255',
            'tanggal_masuk' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $obat) {
            // Add stock entry
            ObatMasuk::create([
                'obat_id' => $obat->id,
                'jumlah' => $request->jumlah,
                'supplier' => $request->supplier,
                'kontak_supplier' => $request->kontak_supplier,
                'tanggal_masuk' => $request->tanggal_masuk,
            ]);

            // Update stock
            $obat->increment('stok', $request->jumlah);
        });

        return redirect()->route('admin.obats.show', $obat)->with('success', 'Stok obat berhasil ditambahkan.');
    }

    // API endpoint for getting medicine data (for AJAX in doctor visit form)
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        $obats = Obat::where('nama_obat', 'LIKE', "%{$query}%")
            ->orWhere('kode_obat', 'LIKE', "%{$query}%")
            ->where('stok', '>', 0)
            ->select('id', 'kode_obat', 'nama_obat', 'stok', 'harga')
            ->limit(10)
            ->get();

        return response()->json($obats);
    }

    public function storeObatMasuk(Request $request)
    {
        $request->validate([
            'obat_id' => 'required|exists:obats,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $obat = Obat::findOrFail($request->obat_id);
        
        DB::transaction(function () use ($request, $obat) {
            // Store stock before update
            $stokSebelum = $obat->stok;
            
            // Create stock entry
            ObatMasuk::create([
                'obat_id' => $obat->id,
                'jumlah' => $request->jumlah,
                'supplier' => 'Manual Entry',
                'kontak_supplier' => 'System',
                'tanggal_masuk' => now(),
            ]);

            // Update stock
            $obat->increment('stok', $request->jumlah);
        });

        return redirect()->back()->with('success', 'Stok obat berhasil ditambahkan.');
    }
}
