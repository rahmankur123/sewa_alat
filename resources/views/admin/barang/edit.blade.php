@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto bg-white rounded-xl shadow">

<h2 class="text-2xl font-bold mb-6">Edit Barang</h2>

<form action="{{ route('barang.update',$barang->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
@csrf
@method('PUT')

<!-- Nama -->
<div>
    <label class="font-semibold">Nama Barang</label>
    <input type="text" name="nama_barang"
        value="{{ old('nama_barang', $barang->nama_barang) }}"
        class="w-full border p-2 rounded">
</div>

<!-- Deskripsi -->
<div>
    <label class="font-semibold">Deskripsi</label>
    <textarea name="deskripsi" class="w-full border p-2 rounded">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
</div>

<!-- Stok -->
<div>
    <label class="font-semibold">Stok</label>
    <input type="number" name="stok"
        value="{{ old('stok', $barang->stok) }}"
        class="w-full border p-2 rounded">
</div>

<!-- Harga -->
<div>
    <label class="font-semibold">Harga Per Hari</label>
    <input type="number" name="harga_per_hari"
        value="{{ old('harga_per_hari', $barang->harga_per_hari) }}"
        class="w-full border p-2 rounded">
</div>

<!-- Denda Kerusakan -->
<div>
    <label class="font-semibold">Denda Kerusakan</label>
    <input type="number" name="denda_kerusakan"
        value="{{ old('denda_kerusakan', $barang->denda_kerusakan) }}"
        class="w-full border p-2 rounded">
</div>

<!-- Denda Keterlambatan -->
<div>
    <label class="font-semibold">Denda Keterlambatan / Hari</label>
    <input type="number" name="denda_keterlambatan_per_hari"
        value="{{ old('denda_keterlambatan_per_hari', $barang->denda_keterlambatan_per_hari) }}"
        class="w-full border p-2 rounded">
</div>

<!-- Status -->
<div>
    <label class="font-semibold">Status</label>
    <select name="status" class="w-full border p-2 rounded">
        <option value="tersedia" {{ old('status',$barang->status)=='tersedia'?'selected':'' }}>Tersedia</option>
        <option value="rusak" {{ old('status',$barang->status)=='rusak'?'selected':'' }}>Rusak</option>
        <option value="tidak_tersedia" {{ old('status',$barang->status)=='tidak_tersedia'?'selected':'' }}>Tidak Tersedia</option>
    </select>
</div>

<!-- Foto -->
<div>
    <label class="font-semibold">Foto Baru (opsional)</label>
    <input type="file" name="foto" class="w-full border p-2 rounded">

    @if($barang->foto)
        <p class="text-sm text-gray-500 mt-2">Foto sebelumnya:</p>
        <img src="{{ asset('storage/'.$barang->foto) }}" class="w-32 rounded shadow">
    @endif
</div>

<button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
    Update Barang
</button>

<a href="{{ route('barang.index') }}" class="ml-3 text-gray-600">Kembali</a>

</form>
</div>
@endsection
