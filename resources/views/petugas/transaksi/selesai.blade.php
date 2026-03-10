
@extends('layouts.app')
@section('title','Transaksi Selesai')

@section('content')
<h2 class="text-xl font-bold mb-4">Transaksi Selesai</h2>

<table class="w-full border">
<thead class="bg-gray-200">
<tr>
<th>ID</th>
<th>Nama User</th>
<th>Tanggal Sewa</th>
<th>Tanggal Kembali</th>
<th>Denda</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach($data as $d)

<tr class="border-b">

<td>{{ $d->id }}</td>

<td>{{ $d->user->name }}</td>

<td>{{ $d->tanggal_pinjam }}</td>

<td>{{ $d->tanggal_kembali_real }}</td>

<td>@if($d->total_denda > 0)
Rp {{ number_format($d->total_denda) }}
@else
-
@endif</td>

<td class="flex gap-2">

<form action="{{ route('transaksi.hapus',$d->id) }}" method="POST">
@csrf
@method('DELETE')
<button class="bg-red-500 text-white px-3 py-1 rounded">
Hapus
</button>
</form>

<a href="{{ route('transaksi.notaSelesai',$d->id) }}"
class="bg-blue-500 text-white px-3 py-1 rounded">
Cetak Nota
</td>

</tr>

@endforeach

</tbody>
</table>
@endsection