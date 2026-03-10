
@extends('layouts.app')
@section('title','Transaksi Baru')

@section('content')
<h2 class="text-xl font-bold mb-4">Transaksi Dipinjam</h2>

<table class="w-full border">
<thead class="bg-gray-200">
<tr>
<th>ID</th>
<th>Nama User</th>
<th>Tanggal Sewa</th>
<th>Rencana Kembali</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach($data as $d)

<tr class="border-b">

<td>{{ $d->id }}</td>

<td>{{ $d->user->name }}</td>

<td>{{ $d->tanggal_pinjam }}</td>

<td>{{ $d->tanggal_kembali_rencana }}</td>

<td class="flex gap-2">

<form action="{{ route('transaksi.hapus',$d->id) }}" method="POST">
@csrf
@method('DELETE')
<button class="bg-red-500 text-white px-3 py-1 rounded">
Hapus
</button>
</form>

<a href="{{ route('transaksi.formKembalikan',$d->id) }}"
class="bg-green-500 text-white px-3 py-1 rounded">
Dikembalikan
</a>

</td>

</tr>

@endforeach

</tbody>
</table>
@endsection