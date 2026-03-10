@extends('layouts.app')
@section('title','Pengembalian Barang')
@section('content')
<h2 class="text-xl font-bold mb-4">Pengembalian Barang</h2>

<form method="POST"
action="{{ route('transaksi.prosesKembalikan',$transaksi->id) }}">

@csrf

<label>Tanggal Kembali</label>
<input type="date" name="tanggal_kembali_real" required
class="border p-2 w-full mb-4">

<h3 class="font-bold mb-2">Kerusakan Barang</h3>

@foreach($transaksi->detail as $item)

<div class="mb-4">

<b>{{ $item->barang->nama_barang }}</b>
Qty Pinjam : {{ $item->qty }}

<div class="flex gap-2 mt-2">

@for($i=1;$i<=$item->qty;$i++)

<label class="flex items-center gap-1">
<input type="checkbox"
name="rusak[{{ $item->barang_id }}][]"
value="1">
Rusak
</label>

@endfor

</div>

</div>

@endforeach

<button class="bg-blue-600 text-white px-4 py-2 rounded">
Simpan
</button>

</form>
@endsection