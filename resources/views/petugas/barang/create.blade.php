@extends('layouts.app')

@section('title','Tambah Barang')

@section('content')

<div class="max-w-4xl mx-auto">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-6">
        <div>
            <h2 class="text-xl md:text-2xl font-semibold text-gray-800">
                Tambah Barang
            </h2>
            <p class="text-sm text-gray-500">
                Tambahkan data barang baru ke sistem
            </p>
        </div>

        <a href="{{ route('barang.index') }}"
           class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm w-fit">
            ← Kembali
        </a>
    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-2xl shadow p-6 md:p-8">

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 text-red-700">
                <p class="font-semibold mb-1">Terjadi kesalahan:</p>
                <ul class="list-disc pl-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

            {{-- NAMA --}}
            <div>
                <label class="block text-gray-500 mb-1">Nama Barang</label>
                <input type="text" name="nama_barang" value="{{ old('nama_barang') }}"
                    class="w-full px-3 py-2 bg-gray-50 rounded-lg focus:bg-white focus:ring-2 focus:ring-indigo-400 outline-none transition"
                    placeholder="Contoh: Sarung Tinju" required>
            </div>

            {{-- STOK --}}
            <div>
                <label class="block text-gray-500 mb-1">Stok</label>
                <input type="number" name="stok" value="{{ old('stok') }}"
                    class="w-full px-3 py-2 bg-gray-50 rounded-lg focus:bg-white focus:ring-2 focus:ring-indigo-400 outline-none transition"
                    placeholder="0" required>
            </div>

            {{-- HARGA --}}
            <div>
                <label class="block text-gray-500 mb-1">Harga / Hari</label>
                <input type="number" name="harga_per_hari" value="{{ old('harga_per_hari') }}"
                    class="w-full px-3 py-2 bg-gray-50 rounded-lg focus:bg-white focus:ring-2 focus:ring-indigo-400 outline-none transition"
                    placeholder="Rp" required>
            </div>

            {{-- DENDA KERUSAKAN --}}
            <div>
                <label class="block text-gray-500 mb-1">Denda Kerusakan</label>
                <input type="number" name="denda_kerusakan" value="{{ old('denda_kerusakan') }}"
                    class="w-full px-3 py-2 bg-gray-50 rounded-lg focus:bg-white focus:ring-2 focus:ring-indigo-400 outline-none transition">
            </div>

            {{-- DENDA TELAT --}}
            <div>
                <label class="block text-gray-500 mb-1">Denda Keterlambatan / Hari</label>
                <input type="number" name="denda_keterlambatan_per_hari"
                    value="{{ old('denda_keterlambatan_per_hari') }}"
                    class="w-full px-3 py-2 bg-gray-50 rounded-lg focus:bg-white focus:ring-2 focus:ring-indigo-400 outline-none transition">
            </div>

            {{-- DENDA HILANG --}}
            <div>
                <label class="block text-gray-500 mb-1">Denda Hilang</label>
                <input type="number" name="denda_hilang" value="{{ old('denda_hilang') }}"
                    class="w-full px-3 py-2 bg-gray-50 rounded-lg focus:bg-white focus:ring-2 focus:ring-indigo-400 outline-none transition">
            </div>

            {{-- DESKRIPSI --}}
            <div class="md:col-span-2">
                <label class="block text-gray-500 mb-1">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                    class="w-full px-3 py-2 bg-gray-50 rounded-lg focus:bg-white focus:ring-2 focus:ring-indigo-400 outline-none transition"
                    placeholder="Deskripsi barang...">{{ old('deskripsi') }}</textarea>
            </div>

            {{-- FOTO --}}
            <div class="md:col-span-2">
                <label class="block text-gray-500 mb-1">Foto Barang</label>
                <input type="file" name="foto"
                    class="w-full text-sm bg-gray-50 rounded-lg file:mr-3 file:px-3 file:py-2 file:bg-indigo-50 file:text-indigo-600 file:border-0 file:rounded-md">
            </div>

        </div>

        {{-- BUTTON --}}
        <div class="flex flex-col sm:flex-row justify-end gap-2 mt-8 pt-5">

            <a href="{{ route('barang.index') }}"
               class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-center">
                Batal
            </a>

            <button type="submit"
                class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition shadow-sm">
                Simpan
            </button>

        </div>

        </form>

    </div>

</div>

@endsection