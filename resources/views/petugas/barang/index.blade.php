@extends('layouts.app')

@section('content')
<div class="p-6">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-slate-700">
            Katalog Barang Sewa
        </h1>

        <a href="{{ route('barang.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
            + Tambah Barang
        </a>
    </div>

    <!-- FILTER -->
    <form method="GET" 
        class="bg-white p-4 rounded-xl shadow-sm border border-slate-200 mb-6 flex flex-wrap gap-3 items-center">

        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari barang..."
            class="border px-3 py-2 rounded-lg w-full md:w-1/4 text-sm focus:ring-2 focus:ring-slate-400">

        <select name="status" class="border px-3 py-2 rounded-lg text-sm">
            <option value="">Semua Status</option>
            <option value="tersedia" {{ request('status')=='tersedia'?'selected':'' }}>Tersedia</option>
            <option value="rusak" {{ request('status')=='rusak'?'selected':'' }}>Rusak</option>
            <option value="tidak_tersedia" {{ request('status')=='tidak_tersedia'?'selected':'' }}>Tidak Tersedia</option>
        </select>

        <input type="number" name="min_harga"
            placeholder="Min"
            value="{{ request('min_harga') }}"
            class="border px-3 py-2 rounded-lg w-24 text-sm">

        <input type="number" name="max_harga"
            placeholder="Max"
            value="{{ request('max_harga') }}"
            class="border px-3 py-2 rounded-lg w-24 text-sm">

        <button class="bg-slate-800 text-white px-4 py-2 rounded-lg text-sm hover:bg-slate-700">
            Filter
        </button>

    </form>

    <!-- GRID -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @forelse($barang as $b)
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden 
                    hover:shadow-lg hover:-translate-y-1 transition duration-300">

            <!-- FOTO -->
            <img src="{{ $b->foto ? asset('storage/'.$b->foto) : asset('img/default.png') }}"
                 class="h-40 w-full object-cover">

            <div class="p-4 space-y-2">

                <!-- NAMA -->
                <h2 class="font-semibold text-lg text-slate-700 line-clamp-1">
                    {{ $b->nama_barang }}
                </h2>

                <!-- DESKRIPSI -->
                <p class="text-sm text-slate-500 line-clamp-2">
                    {{ $b->deskripsi ?? '-' }}
                </p>

                <!-- INFO -->
                <div class="flex justify-between text-sm font-medium">
                    <span class="text-blue-600">
                        Rp {{ number_format($b->harga_per_hari,0,',','.') }}/hari
                    </span>
                    <span class="text-slate-500">
                        Stok: {{ $b->stok }}
                    </span>
                </div>

                <!-- STATUS -->
                <span class="inline-block px-2 py-1 text-xs rounded-full
                    {{ $b->status=='tersedia' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $b->status=='rusak' ? 'bg-red-100 text-red-700' : '' }}
                    {{ $b->status=='tidak_tersedia' ? 'bg-gray-100 text-gray-700' : '' }}">
                    {{ strtoupper($b->status) }}
                </span>

                <!-- ACTION -->
                <div class="flex gap-2 mt-3">

                    {{-- EDIT --}}
                    <a href="{{ route('barang.edit',$b->id) }}"
                       class="flex-1 text-center bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600">
                        Edit
                    </a>

                    {{-- DELETE --}}
                    <form action="{{ route('barang.destroy',$b->id) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus barang?')"
                            class="w-full bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700">
                            Hapus
                        </button>
                    </form>

                </div>

            </div>
        </div>

        @empty
        <div class="col-span-full text-center text-slate-400 py-10">
            Tidak ada barang
        </div>
        @endforelse

    </div>

    <!-- PAGINATION -->
    <div class="mt-6">
        {{ $barang->links() }}
    </div>

</div>
@endsection