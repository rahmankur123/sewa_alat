@extends('layouts.app')

@section('content')
<div class="p-6">
<h2 class="text-xl font-bold">Detail Transaksi #{{ $transaksi->id }}</h2>

<p>Nama: {{ $transaksi->user->name }}</p>
<p>Tanggal Pinjam: {{ $transaksi->tanggal_pinjam }}</p>
<p>Total: Rp {{ number_format($transaksi->total_harga) }}</p>

<table class="border w-full mt-4">
<tr><th>Barang</th><th>Qty</th><th>Subtotal</th></tr>
@foreach($transaksi->detailTransaksi as $d)
<tr>
<td>{{ $d->barang->nama_barang }}</td>
<td>{{ $d->qty }}</td>
<td>{{ number_format($d->subtotal) }}</td>
</tr>
@endforeach
</table>
</div>
@endsection
