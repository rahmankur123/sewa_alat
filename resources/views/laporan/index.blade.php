@extends('layouts.app')
@section('title','Laporan')

@section('content')

<h2 class="text-2xl font-bold mb-6">Laporan Transaksi</h2>

{{-- FILTER --}}
<form method="GET" class="mb-6 flex gap-4">

    <input type="date" name="dari" 
        class="border px-3 py-2 rounded">

    <input type="date" name="sampai" 
        class="border px-3 py-2 rounded">

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Filter
    </button>

</form>

{{-- SUMMARY --}}
<div class="grid grid-cols-3 gap-4 mb-6">

    <div class="bg-white p-4 rounded shadow">
        <p>Total Sewa</p>
        <h2 class="font-bold text-xl">
            Rp {{ number_format($total_sewa,0,',','.') }}
        </h2>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p>Total Denda</p>
        <h2 class="font-bold text-xl text-red-500">
            Rp {{ number_format($total_denda,0,',','.') }}
        </h2>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p>Grand Total</p>
        <h2 class="font-bold text-xl text-green-600">
            Rp {{ number_format($grand_total,0,',','.') }}
        </h2>
    </div>

</div>

{{-- TABEL --}}
<div class="bg-white p-4 rounded shadow overflow-x-auto">

<table class="w-full text-sm border">
    <thead class="bg-gray-100">
        <tr>
            <th class="p-2 border">Nama</th>
            <th class="p-2 border">Tanggal</th>
            <th class="p-2 border">Status</th>
            <th class="p-2 border">Sewa</th>
            <th class="p-2 border">Denda</th>
            <th class="p-2 border">Total</th>
        </tr>
    </thead>

    <tbody>

    @forelse($data as $t)

    @php
        $denda = 
            $t->kerusakan->sum('total_denda') +
            $t->keterlambatan->sum('total_denda') +
            $t->hilang->sum('denda');

        $total = $t->total_harga + $denda;
    @endphp

    <tr>
        <td class="p-2 border">{{ $t->user->name }}</td>
        <td class="p-2 border">
            {{ \Carbon\Carbon::parse($t->tanggal_pinjam)->format('d-m-Y') }}
        </td>
        <td class="p-2 border">{{ $t->status_transaksi }}</td>

        <td class="p-2 border text-right">
            Rp {{ number_format($t->total_harga,0,',','.') }}
        </td>

        <td class="p-2 border text-right text-red-500">
            Rp {{ number_format($denda,0,',','.') }}
        </td>

        <td class="p-2 border text-right font-semibold">
            Rp {{ number_format($total,0,',','.') }}
        </td>
    </tr>

    @empty
    <tr>
        <td colspan="6" class="text-center py-4 text-gray-400">
            Tidak ada data
        </td>
    </tr>
    @endforelse

    </tbody>

</table>

</div>

@endsection