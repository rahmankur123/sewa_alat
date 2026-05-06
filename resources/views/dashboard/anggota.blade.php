@extends('layouts.app')
@section('title','Dashboard')

@section('content')

<h2 class="text-2xl font-bold mb-6">Dashboard Saya</h2>

<div class="grid grid-cols-3 gap-4 mb-6">

    <div class="bg-white p-4 rounded shadow">
        <p>Total Sewa</p>
        <h2 class="text-xl font-bold">{{ $total_sewa }}</h2>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p>Sedang Dipinjam</p>
        <h2 class="text-blue-500 text-xl font-bold">{{ $dipinjam }}</h2>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p>Denda</p>
        <h2 class="text-red-500 text-xl font-bold">{{ $terdenda }}</h2>
    </div>

</div>

<div class="bg-white p-4 rounded shadow">
    <h3 class="font-semibold mb-3">Riwayat Terakhir</h3>

    <table class="w-full text-sm">
        <thead>
            <tr>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
        @foreach($latest as $t)
            <tr>
                <td>{{ $t->status_transaksi }}</td>
                <td>{{ $t->created_at->format('d-m-Y') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@endsection