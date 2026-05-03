@extends('layouts.app')

@section('title','Tambah Barang')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-slate-700">
            Tambah Barang
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

        <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-2 gap-4 text-sm">

            {{-- NAMA --}}
            <div>
                <label class="text-slate-600 mb-1 block">Nama Barang</label>
                <input type="text" name="nama_barang" value="{{ old('nama_barang') }}"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400" required>
            </div>

            {{-- STOK --}}
            <div>
                <label class="text-slate-600 mb-1 block">Stok</label>
                <input type="number" name="stok" value="{{ old('stok') }}"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400" required>
            </div>

            {{-- HARGA --}}
            <div>
                <label class="text-slate-600 mb-1 block">Harga / Hari</label>
                <input type="number" name="harga_per_hari" value="{{ old('harga_per_hari') }}"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400" required>
            </div>

            {{-- DENDA KERUSAKAN --}}
            <div>
                <label class="text-slate-600 mb-1 block">Denda Kerusakan</label>
                <input type="number" name="denda_kerusakan" value="{{ old('denda_kerusakan') }}"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400" required>
            </div>

            {{-- DENDA TELAT --}}
            <div>
                <label class="text-slate-600 mb-1 block">Denda Keterlambatan / Hari</label>
                <input type="number" name="denda_keterlambatan_per_hari" value="{{ old('denda_keterlambatan_per_hari') }}"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400" required>
            </div>

            {{-- DESKRIPSI --}}
            <div class="col-span-2">
                <label class="text-slate-600 mb-1 block">Deskripsi</label>
                <textarea name="deskripsi" rows="3"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">{{ old('deskripsi') }}</textarea>
            </div>

            {{-- FOTO --}}
            <div class="col-span-2">
                <label class="text-slate-600 mb-1 block">Foto Barang</label>
                <input type="file" name="foto"
                    class="w-full px-3 py-2 border rounded-lg">
            </div>

        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-2 mt-6 border-t pt-4">

            <a href="{{ route('barang.index') }}"
               class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg">
                Batal
            </a>

            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Simpan
            </button>

        </div>

        </form>

    </div>

</div>

@endsection