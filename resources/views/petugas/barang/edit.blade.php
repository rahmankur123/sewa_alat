@extends('layouts.app')

@section('title','Edit Barang')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-slate-700">
            Edit Barang
        </h2>

        <a href="{{ route('barang.index') }}"
           class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 text-sm">
            ← Kembali
        </a>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700 border border-red-300">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('barang.update',$barang->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4 text-sm">

            {{-- NAMA --}}
            <div>
                <label class="text-slate-600 mb-1 block">Nama Barang</label>
                <input type="text" name="nama_barang"
                    value="{{ old('nama_barang', $barang->nama_barang) }}"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400">
            </div>

            {{-- STOK --}}
            <div>
                <label class="text-slate-600 mb-1 block">Stok</label>
                <input type="number" name="stok"
                    value="{{ old('stok', $barang->stok) }}"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400">
            </div>

            {{-- HARGA --}}
            <div>
                <label class="text-slate-600 mb-1 block">Harga / Hari</label>
                <input type="number" name="harga_per_hari"
                    value="{{ old('harga_per_hari', $barang->harga_per_hari) }}"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400">
            </div>

            {{-- DENDA KERUSAKAN --}}
            <div>
                <label class="text-slate-600 mb-1 block">Denda Kerusakan</label>
                <input type="number" name="denda_kerusakan"
                    value="{{ old('denda_kerusakan', $barang->denda_kerusakan) }}"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400">
            </div>

            {{-- DENDA TELAT --}}
            <div>
                <label class="text-slate-600 mb-1 block">Denda Keterlambatan / Hari</label>
                <input type="number" name="denda_keterlambatan_per_hari"
                    value="{{ old('denda_keterlambatan_per_hari', $barang->denda_keterlambatan_per_hari) }}"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400">
            </div>

            {{--Denda Hilang--}}
            <div>
                <label class="text-slate-600 mb-1 block">Denda Hilang</label>
                <input type="number" name="denda_hilang"
                    value="{{ old('denda_hilang', $barang->denda_hilang) }}"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400">
            </div>

            {{-- DESKRIPSI --}}
            <div class="col-span-2">
                <label class="text-slate-600 mb-1 block">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400">{{ old('deskripsi', $barang->deskripsi) }}</textarea>
            </div>

            {{-- FOTO --}}
            <div class="col-span-2">
                <label class="text-slate-600 mb-1 block">Foto Barang</label>
                <input type="file" name="foto"
                    class="w-full px-3 py-2 border rounded-lg">

                @if($barang->foto)
                    <div class="mt-3">
                        <p class="text-xs text-slate-500 mb-1">Foto saat ini:</p>
                        <img src="{{ asset('storage/'.$barang->foto) }}"
                             class="h-32 rounded-lg border shadow-sm">
                    </div>
                @endif
            </div>

        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-2 mt-6 border-t pt-4">

            <a href="{{ route('barang.index') }}"
               class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg">
                Batal
            </a>

            <button type="submit"
                class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                Update
            </button>

        </div>

        </form>

    </div>

</div>

@endsection