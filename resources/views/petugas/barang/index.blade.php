@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-4 md:p-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-6">
        <div>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">
                Katalog Barang
            </h1>
            <p class="text-sm text-gray-500">
                Daftar alat yang tersedia untuk disewa
            </p>
        </div>

        <a href="{{ route('barang.create') }}" 
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow-sm hover:bg-indigo-700 transition w-fit">
            + Tambah Barang
        </a>
    </div>

    <!-- FILTER -->
    <form method="GET" 
        class="bg-white p-4 md:p-5 rounded-2xl shadow mb-6 flex flex-col md:flex-row flex-wrap gap-3 md:items-end">

        <div class="flex flex-col">
            <label class="text-xs text-gray-500 mb-1">Cari</label>
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Nama barang..."
                class="bg-gray-50 px-3 py-2 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-400 outline-none transition">
        </div>

        <div class="flex flex-col">
            <label class="text-xs text-gray-500 mb-1">Status</label>
            <select name="status"
                class="bg-gray-50 px-3 py-2 rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-400 outline-none">
                <option value="">Semua</option>
                <option value="tersedia" {{ request('status')=='tersedia'?'selected':'' }}>Tersedia</option>
                <option value="rusak" {{ request('status')=='rusak'?'selected':'' }}>Rusak</option>
                <option value="tidak_tersedia" {{ request('status')=='tidak_tersedia'?'selected':'' }}>Tidak Tersedia</option>
            </select>
        </div>

        <div class="flex flex-col">
            <label class="text-xs text-gray-500 mb-1">Harga</label>
            <div class="flex gap-2">
                <input type="number" name="min_harga" placeholder="Min"
                    value="{{ request('min_harga') }}"
                    class="bg-gray-50 px-3 py-2 rounded-lg w-24 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-400">

                <input type="number" name="max_harga" placeholder="Max"
                    value="{{ request('max_harga') }}"
                    class="bg-gray-50 px-3 py-2 rounded-lg w-24 text-sm focus:bg-white focus:ring-2 focus:ring-indigo-400">
            </div>
        </div>

        <button class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700 transition h-fit">
            Filter
        </button>

    </form>

    <!-- GRID -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @forelse($barang as $b)
        <div class="bg-white rounded-2xl shadow overflow-hidden 
                    hover:shadow-md hover:-translate-y-1 transition duration-300">

            <!-- FOTO -->
            <div class="h-40 w-full overflow-hidden">
                <img src="{{ $b->foto ? asset('storage/'.$b->foto) : asset('img/default.png') }}"
                     class="h-full w-full object-cover hover:scale-105 transition duration-300">
            </div>

            <div class="p-4 space-y-2">

                <!-- NAMA -->
                <h2 class="font-semibold text-gray-800 line-clamp-1">
                    {{ $b->nama_barang }}
                </h2>

                <!-- DESKRIPSI -->
                <p class="text-xs text-gray-500 line-clamp-2">
                    {{ $b->deskripsi ?? '-' }}
                </p>

                <!-- INFO -->
                <div class="flex justify-between items-center text-sm mt-2">
                    <span class="font-semibold text-indigo-600">
                        Rp {{ number_format($b->harga_per_hari,0,',','.') }}
                    </span>
                    <span class="text-gray-400 text-xs">
                        Stok: {{ $b->stok }}
                    </span>
                </div>

                <!-- STATUS -->
                <span class="inline-block px-2 py-1 text-xs rounded-full font-medium
                    {{ $b->status=='tersedia' ? 'bg-green-100 text-green-600' : '' }}
                    {{ $b->status=='rusak' ? 'bg-red-100 text-red-600' : '' }}
                    {{ $b->status=='tidak_tersedia' ? 'bg-gray-100 text-gray-600' : '' }}">
                    {{ ucfirst($b->status) }}
                </span>

                <!-- ACTION -->
                <div class="flex gap-2 mt-3">

                    <a href="{{ route('barang.edit',$b->id) }}"
                       class="flex-1 text-center bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg text-xs hover:bg-indigo-100">
                        Edit
                    </a>

                    <form action="{{ route('barang.destroy',$b->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus barang?')"
                            class="w-full bg-red-500 text-white px-3 py-1.5 rounded-lg text-xs hover:bg-red-600">
                            Hapus
                        </button>
                    </form>

                </div>

            </div>
        </div>

        @empty
        <div class="col-span-full text-center text-gray-400 py-10">
            Tidak ada barang
        </div>
        @endforelse

    </div>

    <!-- PAGINATION -->
    <div class="mt-8">
        {{ $barang->links() }}
    </div>

</div>
@endsection