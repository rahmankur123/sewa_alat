@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto bg-white rounded-xl shadow">

<h2 class="text-2xl font-bold mb-6">Tambah Anggota</h2>

<form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
@csrf

<div>
    <label class="font-semibold">Nama Anggota</label>
    <input type="text" name="name" class="w-full border p-2 rounded" required>
</div>

<div>
    <label class="font-semibold">Alamat</label>
    <textarea name="alamat" class="w-full border p-2 rounded"></textarea>
</div>

<div>
    <label class="font-semibold">No. Telepon</label>
    <input type="text" name="no_telepon" class="w-full border p-2 rounded" required>
</div>

<div>
    <label class="font-semibold">Email</label>
    <input type="email" name="email" class="w-full border p-2 rounded" required>
</div>

<div>
    <label class="font-semibold">Password</label>
    <input type="password" name="password" class="w-full border p-2 rounded" required>
</div>
<div>
    <label class="font-semibold">Konfirmasi Password</label>
    <input type="password" name="password_confirmation" class="w-full border p-2 rounded" required>
</div>
<div>
    <label class="font-semibold">Status</label>
    <select name="status">
    <option value="aktif">Aktif</option>
    <option value="belum_aktif">Belum Aktif</option>
</select>
</div>

<div>
    <label class="font-semibold">Foto Anggota</label>
    <input type="file" name="foto" class="w-full border p-2 rounded">
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
    Simpan
</button>

<a href="{{ route('user.index') }}" class="ml-3 text-gray-600">Kembali</a>

</form>
</div>
@endsection
