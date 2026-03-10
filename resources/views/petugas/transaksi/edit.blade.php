@extends('layouts.app')

@section('content')
<form action="{{ route('petugas.transaksi.update',$transaksi->id) }}" method="POST">
@csrf @method('PUT')

@foreach($transaksi->detail as $d)
<div class="flex gap-2">
    <select name="barang_id[]" class="border">
        @foreach($barang as $b)
        <option value="{{ $b->id }}" {{ $b->id==$d->barang_id?'selected':'' }}>
            {{ $b->nama_barang }}
        </option>
        @endforeach
    </select>
    <input type="number" name="qty[]" value="{{ $d->qty }}" class="border w-20">
</div>
@endforeach

<button class="bg-blue-600 text-white px-4 py-2">Update</button>
</form>
@endsection
