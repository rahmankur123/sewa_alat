@extends('layouts.app')
@section('title','Transaksi Terdenda')
@section('content')
<h2 class="text-xl font-bold mb-4">Transaksi Terdenda</h2>

<table class="w-full border">

<thead class="bg-gray-200">
<tr>
<th>ID</th>
<th>Nama User</th>
<th>Total Denda</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@foreach($data as $d)

<tr class="border-b">

<td>{{ $d->id }}</td>

<td>{{ $d->user->name }}</td>

<td>
Rp {{
    number_format(
        $d->kerusakan->sum('total_denda')
        +
        $d->keterlambatan->sum('total_denda')
    )
}}
</td>

<td>

<form action="{{ route('transaksi.lunas',$d->id) }}" method="POST">

@csrf

<button class="bg-green-600 text-white px-3 py-1 rounded">
Lunas
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>
@endsection