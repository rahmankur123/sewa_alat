@extends('layouts.app')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Data Transaksi</h1>

    <a href="{{ route('petugas.transaksi.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">
        + Transaksi Baru
    </a>

    <table class="w-full mt-4 border">
        <thead class="bg-gray-200">
            <tr>
                <th>ID</th>
                <th>Anggota</th>
                <th>Tanggal Pinjam</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($transaksi as $t)
        <tr class="border-b">
            <td>{{ $t->id }}</td>
            <td>{{ $t->user->name ?? '-' }}</td>
            <td>{{ $t->tanggal_pinjam }}</td>
            <td>Rp {{ number_format($t->total_harga) }}</td>
            <td>{{ $t->status_transaksi }}</td>
            <td>
    <a href="{{ route('petugas.transaksi.show',$t->id) }}" class="bg-blue-500 px-2 py-1 text-white rounded">Detail</a>

    <a href="{{ route('petugas.transaksi.nota',$t->id) }}" class="bg-gray-700 px-2 py-1 text-white rounded">Nota</a>

    <button onclick="openReturnModal({{ $t->id }})" class="bg-green-600 px-2 py-1 text-white rounded">
        Selesai
    </button>
</td>

        </tr>
        @endforeach
        </tbody>
    </table>

    {{-- PAGINATION --}}
    {{ $transaksi->links() }}
</div>
@endsection
