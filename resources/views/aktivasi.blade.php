@extends('layouts.app')
@section('content')

<div class="max-w-md mx-auto bg-white p-6 shadow rounded mt-10">
    <h2 class="text-xl font-bold mb-4">Aktivasi Akun</h2>

    <form method="POST">
        @csrf

        <input type="text" name="name" placeholder="Nama Lengkap" class="border p-2 w-full mb-3">

        <input type="text" name="alamat" placeholder="Alamat" class="border p-2 w-full mb-3">

        <input type="password" name="password" placeholder="Password" class="border p-2 w-full mb-3">

        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" class="border p-2 w-full mb-3">

        <button class="bg-blue-600 text-white w-full py-2 rounded">
            Aktivasi
        </button>
    </form>
</div>

@endsection