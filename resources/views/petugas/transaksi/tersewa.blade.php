@extends('layouts.app')
@section('title','Transaksi Terdenda')
@section('content')
<h2 class="text-xl font-bold mb-4">Transaksi Tersewa</h2>

<table class="w-full border">

<thead class="bg-gray-200">
<tr>
<th>ID</th>
<th>Nama User</th>
<th>Tanggal Sewa</th>
<th>Tanggal Kembali Rencana</th>
<th>Total Harga</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach($data as $d)

<tr class="border-b">

<td>{{ $d->id }}</td>

<td>{{ $d->user->name }}</td>

<td>{{ $d->tanggal_pinjam }}</td>
</td>
<td>{{ $d->tanggal_kembali_rencana }}</td>
<td>Rp {{ number_format($d->total_harga) }}</td>
<td>

<form action="{{ route('transaksi.hapus',$d->id) }}" method="POST">

@csrf

<button class="bg-green-600 text-white px-3 py-1 rounded">
Hapus
</button>

</form>
<form action="{{ route('transaksi.diambil',$d->id) }}" method="POST" style="display:inline;">
@csrf
<button class="bg-green-500 text-white px-3 py-1 rounded">
Barang Diambil
</button>
</form>
</td>

</tr>

@endforeach

</tbody>

</table>
@endsection