<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    // ================= LIST KATALOG =================
    public function index(Request $request)
{
    $query = Barang::query();

    // SEARCH
    if ($request->search) {
        $query->where('nama_barang', 'like', "%{$request->search}%");
    }

    // FILTER HARGA
    if ($request->min_harga) {
        $query->where('harga_per_hari', '>=', $request->min_harga);
    }
    if ($request->max_harga) {
        $query->where('harga_per_hari', '<=', $request->max_harga);
    }

    $barang = $query->latest()->paginate(12);

    return view('petugas.barang.index', compact('barang'));
}


    // ================= FORM TAMBAH =================
    public function create()
    {
        return view('petugas.barang.create');
    }

    // ================= SIMPAN DATA =================
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'stok' => 'required|integer',
            'harga_per_hari' => 'required|numeric',
            'denda_kerusakan' => 'required|numeric',
            'denda_hilang' => 'required|numeric',
            'denda_keterlambatan_per_hari' => 'required|numeric',
            'foto' => 'image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = $request->all();

        // upload foto
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('barang', 'public');
        }

        Barang::create($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    // ================= FORM EDIT =================
    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('petugas.barang.edit', compact('barang'));
    }

    // ================= UPDATE DATA =================
    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'nama_barang' => 'required',
            'stok' => 'required|integer',
            'harga_per_hari' => 'required|numeric',
            'denda_hilang' => 'required|numeric'
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            // hapus foto lama
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }
            $data['foto'] = $request->file('foto')->store('barang', 'public');
        }

        $barang->update($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate');
    }

    // ================= HAPUS =================
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }
}
