@extends('layouts.app')
@section('title','Dashboard')

@section('content')

<h2 class="text-2xl font-bold mb-6">Dashboard</h2>

<div class="grid grid-cols-4 gap-4 mb-6">

    <div class="bg-white p-4 rounded shadow">
        <p>Total Barang</p>
        <h2 class="text-xl font-bold">{{ $total_barang }}</h2>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p>Total Transaksi</p>
        <h2 class="text-xl font-bold">{{ $total_transaksi }}</h2>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p>Dipinjam</p>
        <h2 class="text-xl font-bold text-blue-500">{{ $dipinjam }}</h2>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p>Terdenda</p>
        <h2 class="text-xl font-bold text-red-500">{{ $terdenda }}</h2>
    </div>

</div>

<div class="bg-white p-4 rounded shadow mb-6">
    <p>Total Denda</p>
    <h2 class="text-xl font-bold text-red-600">
        Rp {{ number_format($total_denda,0,',','.') }}
    </h2>
</div>

<div class="bg-white p-4 rounded shadow">
    <h3 class="font-semibold mb-3">Transaksi Terbaru</h3>

    <table class="w-full text-sm">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
        @foreach($latest as $t)
            <tr>
                <td>{{ $t->user->name }}</td>
                <td>{{ $t->status_transaksi }}</td>
                <td>{{ $t->created_at->format('d-m-Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@endsection