@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto bg-white rounded-xl shadow">

<h2 class="text-2xl font-bold mb-6">Tambah Barang</h2>

<form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
@csrf

<div>
    <label class="font-semibold">Nama Barang</label>
    <input type="text" name="nama_barang" class="w-full border p-2 rounded" required>
</div>

<div>
    <label class="font-semibold">Deskripsi</label>
    <textarea name="deskripsi" class="w-full border p-2 rounded"></textarea>
</div>

<div>
    <label class="font-semibold">Stok</label>
    <input type="number" name="stok" class="w-full border p-2 rounded" required>
</div>

<div>
    <label class="font-semibold">Harga Per Hari</label>
    <input type="number" name="harga_per_hari" class="w-full border p-2 rounded" required>
</div>

<div>
    <label class="font-semibold">Denda Kerusakan</label>
    <input type="number" name="denda_kerusakan" class="w-full border p-2 rounded" required>
</div>

<div>
    <label class="font-semibold">Denda Keterlambatan / Hari</label>
    <input type="number" name="denda_keterlambatan_per_hari" class="w-full border p-2 rounded" required>
</div>

<div>
    <label class="font-semibold">Status</label>
    <select name="status" class="w-full border p-2 rounded">
        <option value="tersedia">Tersedia</option>
        <option value="rusak">Rusak</option>
        <option value="tidak_tersedia">Tidak Tersedia</option>
    </select>
</div>

<div>
    <label class="font-semibold">Foto Barang</label>
    <input type="file" name="foto" class="w-full border p-2 rounded">
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
    Simpan
</button>

<a href="{{ route('barang.index') }}" class="ml-3 text-gray-600">Kembali</a>

</form>
</div>
@endsection
