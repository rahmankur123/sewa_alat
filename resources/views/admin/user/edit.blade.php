@extends('layouts.app')

@section('content')
<div class="p-6 max-w-3xl mx-auto bg-white rounded-xl shadow">

<h2 class="text-2xl font-bold mb-6">Edit Anggota</h2>

<form action="{{ route('user.update',$user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
@csrf
@method('PUT')

<!-- Nama -->
<div>
    <label class="font-semibold">Nama Anggota</label>
    <input type="text" name="name"
        value="{{ old('name', $user->name) }}"
        class="w-full border p-2 rounded">
</div>

<!-- Deskripsi -->
<div>
    <label class="font-semibold">Alamat</label>
    <textarea name="alamat" class="w-full border p-2 rounded" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
</div>

<!-- Stok -->
<div>
    <label class="font-semibold">No. Telepon</label>
    <input type="text" name="no_telepon"
        value="{{ old('no_telepon', $user->no_telepon) }}"
        class="w-full border p-2 rounded">
</div>

<!-- Harga -->
<div>
    <label class="font-semibold">Email</label>
    <input type="email" name="email"
        value="{{ old('email', $user->email) }}"
        class="w-full border p-2 rounded">
</div>

<!-- Denda Kerusakan -->
<div>
    <label class="font-semibold">Password(opsional)</label>
    <input type="password" name="password"
        value="{{ old('password') }}"
        class="w-full border p-2 rounded">
</div>


<!-- Status -->
<div>
    <label class="font-semibold">Status</label>
    <select name="status" class="w-full border p-2 rounded">
        <option value="aktif" {{ old('status',$user->status)=='aktif'?'selected':'' }}>Aktif</option>
        <option value="belum_aktif" {{ old('status',$user->status)=='belum_aktif'?'selected':'' }}>Belum Aktif</option>
    </select>
</div>

<!-- Foto -->
<div>
    <label class="font-semibold">Foto Profil</label>
    <input type="file" name="foto" class="w-full border p-2 rounded">
    @if($user->foto)
        <img src="{{ asset('storage/'.$user->foto) }}" class="h-40 mt-3 rounded">
    @endif
</div>

<button class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
    Update Anggota
</button>

<a href="{{ route('user.index') }}" class="ml-3 text-gray-600">Kembali</a>

</form>
</div>
@endsection
