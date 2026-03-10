@extends('layouts.app')

@section('content')
<div class="p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Katalog Barang Sewa</h1>
        <a href="{{ route('barang.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
            + Tambah Barang
        </a>
    </div>

    <!-- FILTER & SEARCH -->
    <form method="GET" class="bg-white p-4 rounded-xl shadow mb-6 flex flex-wrap gap-3">

        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari barang..."
            class="border p-2 rounded w-full md:w-1/4">

        <select name="status" class="border p-2 rounded">
            <option value="">Semua Status</option>
            <option value="tersedia" {{ request('status')=='tersedia'?'selected':'' }}>Tersedia</option>
            <option value="rusak" {{ request('status')=='rusak'?'selected':'' }}>Rusak</option>
            <option value="tidak_tersedia" {{ request('status')=='tidak_tersedia'?'selected':'' }}>Tidak Tersedia</option>
        </select>

        <input type="number" name="min_harga" placeholder="Harga min"
            value="{{ request('min_harga') }}" class="border p-2 rounded">

        <input type="number" name="max_harga" placeholder="Harga max"
            value="{{ request('max_harga') }}" class="border p-2 rounded">

        <button class="bg-black text-white px-4 py-2 rounded">Filter</button>

    </form>

    <!-- GRID KATALOG -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @forelse($barang as $b)
        <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

            <!-- FOTO -->
            <img src="{{ $b->foto ? asset('storage/'.$b->foto) : asset('img/default.png') }}"
                 class="h-40 w-full object-cover">

            <div class="p-4 space-y-2">
                <h2 class="font-bold text-lg">{{ $b->nama_barang }}</h2>

                <p class="text-sm text-gray-500">{{ $b->deskripsi }}</p>

                <div class="flex justify-between text-sm font-semibold">
                    <span>Rp {{ number_format($b->harga_per_hari) }}/hari</span>
                    <span>Stok: {{ $b->stok }}</span>
                </div>

                <!-- STATUS BADGE -->
                <span class="px-2 py-1 text-xs rounded
                    {{ $b->status=='tersedia'?'bg-green-100 text-green-700':'' }}
                    {{ $b->status=='rusak'?'bg-red-100 text-red-700':'' }}
                    {{ $b->status=='tidak_tersedia'?'bg-gray-100 text-gray-700':'' }}">
                    {{ strtoupper($b->status) }}
                </span>

                <!-- BUTTON -->
                <div class="flex gap-2 mt-3">
                    <a href="{{ route('barang.edit',$b->id) }}"
                       class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">Edit</a>

                    <form action="{{ route('barang.destroy',$b->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus barang?')"
                            class="bg-red-600 text-white px-3 py-1 rounded text-sm">
                            Hapus
                        </button>
                    </form>
                </div>

            </div>
        </div>
        @empty
        <p class="text-gray-500">Tidak ada barang.</p>
        @endforelse

    </div>

    <!-- PAGINATION -->
    <div class="mt-6">
        {{ $barang->links() }}
    </div>

</div>
@endsection
