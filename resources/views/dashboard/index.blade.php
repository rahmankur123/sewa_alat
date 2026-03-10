@extends('layouts.app')

@section('title','Dashboard')

@section('content')

<div class="grid grid-cols-4 gap-6">

    <div class="bg-linear-to-r from-indigo-500 to-purple-500 text-white p-5 rounded shadow">
        <h3 class="text-lg">Total Barang</h3>
        <p class="text-3xl font-bold">120</p>
    </div>

    <div class="bg-linear-to-r from-green-500 to-teal-500 text-white p-5 rounded shadow">
        <h3 class="text-lg">Transaksi Aktif</h3>
        <p class="text-3xl font-bold">15</p>
    </div>

    <div class="bg-linear-to-r from-yellow-500 to-orange-500 text-white p-5 rounded shadow">
        <h3 class="text-lg">Anggota</h3>
        <p class="text-3xl font-bold">89</p>
    </div>

    <div class="bg-linear-to-r from-red-500 to-pink-500 text-white p-5 rounded shadow">
        <h3 class="text-lg">Total Denda</h3>
        <p class="text-3xl font-bold">Rp 2.500.000</p>
    </div>

</div>

@endsection
